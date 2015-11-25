<?php

namespace staticsquish\data;

use staticsquish\Site;
use staticsquish\models\RootDataObject;
use staticsquish\models\File;
use staticsquish\models\FieldScalarValueText;
use staticsquish\models\FieldScalarValueDateTime;
use staticsquish\models\FieldScalarValueLatLng;
use staticsquish\models\FieldListValue;

/**
 *  @license 3-clause BSD
 */
class RootDataLoaderIni extends  BaseRootDataLoader {

	function  isLoadableDataInSite(Site $site, $filename)
	{
		$file = $site->getDir().DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."data.ini";
		return file_exists($file);
	}

	function loadRootDataInSite(Site $site, $filename)
	{
		$data = parse_ini_file($site->getDir().DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."data.ini", true);

        \staticsquish\ArrayChangeKeyCaseRecursive::convert($data, CASE_LOWER);

		$r = new RootDataObject();
		$r->setSlug($filename);
		$r->setTitle($filename);

		if (isset($data['data']['slug']) && $data['data']['slug']) {
			$r->setSlug($data['data']['slug']);
		}
		if (isset($data['data']['title']) && $data['data']['title']) {
			$r->setTitle($data['data']['title']);
		}
		if (isset($data['data']['description']) && $data['data']['description']) {
			$r->setDescription($data['data']['description']);
		}

		if (isset($data['data'])) {
			foreach(array_keys($data['data']) as $k) {
				if (!in_array($k, array('title','slug','description'))) {

					$fieldConfig = isset($site->getConfig()->fields[$k]) ? $site->getConfig()->fields[$k] : null;

					if ($fieldConfig && $fieldConfig->isList) {

							$field = new FieldListValue;
							foreach(explode(',', $data['data'][$k]) as $valueBit) {
								$field->addValue($this->getFieldValue(trim($valueBit), $fieldConfig));
							}

					} else {
						// no config - just treat as string
						$field = $this->getFieldValue($data['data'][$k], $fieldConfig);
					}

					$r->addField($k, $field);
				}
			}
		}

		foreach(scandir($site->getDir() . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$filename) as $fileInFolderName) {
			if (substr($fileInFolderName,0,1) != "." && $fileInFolderName != 'data.ini') {
				$r->addFile(
					new File($site->getDir() . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$filename, $fileInFolderName)
				);
			}
		}

		return $r;

	}

	protected function getFieldValue($data, $fieldConfig = null) {
		if ($fieldConfig && $fieldConfig->isDateTime) {
			return new FieldScalarValueDateTime($data, $fieldConfig);
		}
        if ($fieldConfig && $fieldConfig->isLatLng) {
            return new FieldScalarValueLatLng($data);
        }

		return new FieldScalarValueText($data);

	}

}

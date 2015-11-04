<?php

namespace filedatabrowserstaticgenerator\data;

use filedatabrowserstaticgenerator\Site;
use filedatabrowserstaticgenerator\models\RootDataObject;
use filedatabrowserstaticgenerator\models\File;
use filedatabrowserstaticgenerator\models\FieldValue;
use filedatabrowserstaticgenerator\models\FieldListValue;

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
								$field->addValue(new FieldValue(trim($valueBit)));
							}

					} else {
						// no config - just treat as string
						$field = new FieldValue($data['data'][$k]);
					}

					$r->addField($k, $field);
				}
			}
		}

		foreach(scandir($site->getDir() . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$filename) as $fileInFolderName) {
			if (substr($fileInFolderName,0,1) != ".") {
				$r->addFile(
					new File($site->getDir() . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$filename, $fileInFolderName)
				);
			}
		}

		return $r;

	}

}

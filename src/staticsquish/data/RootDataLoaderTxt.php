<?php

namespace staticsquish\data;

use staticsquish\Site;
use staticsquish\models\RootDataObject;
use staticsquish\models\File;
use staticsquish\models\FieldScalarValueText;
use staticsquish\models\FieldScalarValueDateTime;
use staticsquish\models\FieldScalarValueLatLng;
use staticsquish\models\FieldListValue;
use staticsquish\FileLoaderTxt;

/**
*  @license 3-clause BSD
*/
class RootDataLoaderTxt extends  BaseRootDataLoader {

  function  isLoadableDataInSite(Site $site, $filename)
  {
    $file = $site->getDir().DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."data.txt";
    return file_exists($file);
  }

  function loadRootDataInSite(Site $site, $filename)
  {

    $fileLoader = new FileLoaderTxt($site->getDir().DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."data.txt", $site->getConfig()->fields);

    $r = new RootDataObject();
    $r->setSlug($filename);
    $r->setTitle($filename);

    if ($fileLoader->hasAsValue('title')) {
      $r->setTitle($fileLoader->getAsValue('title'));
    }
    if ($fileLoader->hasAsValue('description')) {
      $r->setDescription($fileLoader->getAsValue('description'));
    }
    if ($fileLoader->hasAsValue('slug')) {
      $r->setSlug($fileLoader->getAsValue('slug'));
    }

    foreach($fileLoader->getKeys() as $k) {
      if (!in_array($k, array('title','slug','description'))) {

        $fieldConfig = isset($site->getConfig()->fields[$k]) ? $site->getConfig()->fields[$k] : null;

        $field = null;

        if ($fieldConfig && $fieldConfig->isList) {

          $field = new FieldListValue;
          foreach($fileLoader->getAsList($k) as $valueBit) {
            $field->addValue($this->getFieldValue(trim($valueBit), $fieldConfig));
          }

        } else {
          // no config - just treat as string
          $fieldPossible = $this->getFieldValue($fileLoader->getAsValue($k), $fieldConfig);
          if ($fieldPossible->hasValue()) {
            $field = $fieldPossible;
          }
        }

        if ($field) {
          $r->addField($k, $field);
        }
      }
    }

    foreach(scandir($site->getDir() . DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR.$filename) as $fileInFolderName) {
        if (substr($fileInFolderName,0,1) != "." && $fileInFolderName != 'data.txt') {
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

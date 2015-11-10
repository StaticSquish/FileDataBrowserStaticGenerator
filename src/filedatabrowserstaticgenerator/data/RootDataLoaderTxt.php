<?php

namespace filedatabrowserstaticgenerator\data;

use filedatabrowserstaticgenerator\Site;
use filedatabrowserstaticgenerator\models\RootDataObject;
use filedatabrowserstaticgenerator\models\File;
use filedatabrowserstaticgenerator\models\FieldValue;
use filedatabrowserstaticgenerator\models\FieldListValue;
use filedatabrowserstaticgenerator\FileLoaderTxt;

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

    $fileLoader = new FileLoaderTxt($site->getDir().DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."data.txt");

    $r = new RootDataObject();
    $r->setSlug($filename);
    $r->setTitle($filename);

    if ($fileLoader->hasKey('title')) {
      $r->setTitle($fileLoader->getAsValue('title'));
    }
    if ($fileLoader->hasKey('description')) {
      $r->setDescription($fileLoader->getAsValue('description'));
    }
    if ($fileLoader->hasKey('slug')) {
      $r->setSlug($fileLoader->getAsValue('slug'));
    }

    foreach($fileLoader->getKeys() as $k) {
      if (!in_array($k, array('title','slug','description'))) {

        $fieldConfig = isset($site->getConfig()->fields[$k]) ? $site->getConfig()->fields[$k] : null;

        if ($fieldConfig && $fieldConfig->isList) {

          $field = new FieldListValue;
          foreach($fileLoader->getAsList($k) as $valueBit) {
            $field->addValue(new FieldValue(trim($valueBit)));
          }

        } else {
          // no config - just treat as string
          $field = new FieldValue($fileLoader->getAsValue($k));
        }

        $r->addField($k, $field);
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

}

<?php

namespace filedatabrowserstaticgenerator;


/**
*  @license 3-clause BSD
*/

class OutFolder
{

  protected $folder;

  public function __construct($folder) {
    $this->folder = $folder;
    if (!file_exists($this->folder)) {
      mkdir($this->folder);
    }
  }

  public function addFileContents($folderName, $fileName, $contents) {
    if ($folderName) {
      if (!file_exists($this->folder . DIRECTORY_SEPARATOR .  $folderName )) {
        mkdir($this->folder . DIRECTORY_SEPARATOR .  $folderName);
      }
    }
    file_put_contents(
      $this->folder . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $fileName,
      $contents
    );
  }



}

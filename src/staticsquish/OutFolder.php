<?php

namespace staticsquish;


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

  public function copyFolder($sourceFolder, $destFolder = '') {
    if (is_dir($sourceFolder)) {
      foreach(scandir($sourceFolder) as $fileInFolderName) {
        if (substr($fileInFolderName,0,1) != ".") {
          if (is_dir($sourceFolder . DIRECTORY_SEPARATOR. $fileInFolderName)) {
            // It's a dir!
            // Make folder
            if (!file_exists($this->folder.DIRECTORY_SEPARATOR.$destFolder.DIRECTORY_SEPARATOR.$fileInFolderName)) {
              mkdir($this->folder.DIRECTORY_SEPARATOR.$destFolder.DIRECTORY_SEPARATOR.$fileInFolderName);
            }
            // call recursively
            $this->copyFolder($sourceFolder.DIRECTORY_SEPARATOR.$fileInFolderName, $destFolder.DIRECTORY_SEPARATOR.$fileInFolderName);
          } else if (is_file($sourceFolder . DIRECTORY_SEPARATOR. $fileInFolderName)) {
            // it's a file!
            // copy!
            copy($sourceFolder.DIRECTORY_SEPARATOR.$fileInFolderName, $this->folder.DIRECTORY_SEPARATOR.$destFolder.DIRECTORY_SEPARATOR.$fileInFolderName);
          }
        }
      }
    }
  }



}

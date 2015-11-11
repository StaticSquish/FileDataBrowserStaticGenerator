<?php


namespace staticsquish\models;

/**
 *  @license 3-clause BSD
 */
class File {

  protected $name;

  protected $dir;

  public function __construct($dir, $name) {
    $this->dir = $dir;
    $this->name = $name;
  }


  /**
   * Get the value of Name
   *
   * @return mixed
   */
  public function getName()
  {
      return $this->name;
  }


  /**
   * Get the value of Dir
   *
   * @return mixed
   */
  public function getDir()
  {
      return $this->dir;
  }

  public function getSize() {
    return filesize($this->dir . DIRECTORY_SEPARATOR. $this->name);
  }

  public function getSizeHumanReadable() {
    $bytes = $this->getSize();

    if ($bytes >= 1024 * 1024 * 1024) {
      return round($bytes / 1024 / 1024 / 1024,2) . 'GB';
    } elseif ($bytes >= 1024 * 1024) {
      return round($bytes / 1024 / 1024,2) . 'MB';
    } elseif($bytes >= 1024) {
      return round($bytes / 1024,1) . 'KB';
    } else {
      return $bytes . ' bytes';
    }
  }

}

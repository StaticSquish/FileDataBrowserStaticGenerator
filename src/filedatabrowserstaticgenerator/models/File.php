<?php


namespace filedatabrowserstaticgenerator\models;

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
 
}

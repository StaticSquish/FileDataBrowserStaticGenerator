<?php

namespace filedatabrowserstaticgenerator;


/**
*  @license 3-clause BSD
*/
class TemporaryFolder
{

  protected $folder;

  public function get() {
    if (!$this->folder) {
      $this->folder = '/tmp/openacalendarstaticweb'.rand();
      while(file_exists($this->folder)) {
        $this->folder = '/tmp/openacalendarstaticweb'.rand();
      }
      mkdir($this->folder);
    }
    return $this->folder;
  }

}

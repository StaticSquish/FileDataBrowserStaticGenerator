<?php

namespace filedatabrowserstaticgenerator;


/**
*  @license 3-clause BSD
*/
class FileLoaderTxt {


  protected $data = array();

  public function __construct($filename) {

    $data = file_get_contents($filename);

    $infield = null;
    foreach(explode("\n", $data) as $line) {

      $trimmedLine = trim($line);
      if (substr($trimmedLine,0,1) == '[' && substr($trimmedLine, -1) == ']') {
        $infield = trim(substr($trimmedLine, 1, -1));
      } else if ($infield) {
        if (!isset($this->data[$infield])) {
          $this->data[$infield] = '';
        }
        $this->data[$infield] .= $trimmedLine."\n";
      }

    }

  }
  
  public function getAsList($key) {
    if (isset($this->data[$key])) {
      $out = array();
      foreach(explode("\n", $this->data[$key]) as $line) {
        if (trim($line)) {
          $out[] = trim($line);
        }
      }
      return $out;
    } else {
      return false;
    }
    return array();
  }

  public function getAsValue($key) {
    return isset($this->data[$key]) ? trim($this->data[$key]) : '';
  }

  public function hasKey($key) {
    return isset($this->data[$key]);
  }

  public function getKeys() {
    return array_keys($this->data);
  }

}

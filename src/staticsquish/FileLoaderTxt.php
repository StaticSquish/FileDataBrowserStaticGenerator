<?php

namespace staticsquish;


/**
*  @license 3-clause BSD
*/
class FileLoaderTxt {


  protected $dataValue = array();

  protected $dataList = array();

  protected $fieldConfigs;

  public function __construct($filename, $fieldConfigs = array()) {
    $this->fieldConfigs = $fieldConfigs;

    $data = file_get_contents($filename);

    $infield = null;
    $fieldData = '';
    foreach(explode("\n", $data) as $line) {

      $trimmedLine = trim($line);
      if (substr($trimmedLine,0,1) == '[' && substr($trimmedLine, -1) == ']') {
        if ($infield) {
          $this->setValue($infield, $fieldData);
        }
        $infield = trim(substr($trimmedLine, 1, -1));
        $fieldData = '';
      } else if ($infield) {
        $fieldData .= $trimmedLine."\n";
      }

    }
    if ($infield) {
      $this->setValue($infield, $fieldData);
    }

  }

  protected function setValue($field, $value) {
      if (isset($this->fieldConfigs[$field]) && isset($this->fieldConfigs[$field]->isList)) {
        $out = array();
        foreach(explode("\n", $value) as $line) {
          if (trim($line)) {
            $out[] = trim($line);
          }
        }
        $this->dataList[$field] = $out;
      } else {
        $this->dataValue[$field] = trim($value);
      }
  }

  public function getAsList($key) {
    return isset($this->dataList[$key]) ? $this->dataList[$key] : array();
  }

  public function getAsValue($key) {
    return isset($this->dataValue[$key]) ? trim($this->dataValue[$key]) : '';
  }

  public function hasAsValue($key) {
    return isset($this->dataValue[$key]) && trim($this->dataValue[$key]);
  }

  public function hasKey($key) {
    return isset($this->dataValue[$key]) || isset($this->dataList[$key]);
  }

  public function getKeys() {
    $out = array_merge(array_keys($this->dataValue), array_keys($this->dataList));
    asort($out);
    return $out;
  }

}

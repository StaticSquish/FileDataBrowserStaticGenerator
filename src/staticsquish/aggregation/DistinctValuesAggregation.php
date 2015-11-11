<?php

namespace staticsquish\aggregation;

use staticsquish\filters\RootDataObjectFilter;

/**
 *  @license 3-clause BSD
 */
class DistinctValuesAggregation {

  /** @var  RootDataObjectFilter  **/
  protected $rootDataObjectFilter;

  protected $fieldName;

  public function __construct(RootDataObjectFilter $rootDataObjectFilter, $fieldName) {
    $this->rootDataObjectFilter = $rootDataObjectFilter;
    $this->fieldName = $fieldName;
  }

  protected $data = array();

  protected function checkValue($value) {
    if (!in_array($value, $this->data)) {
      $this->data[] = $value;
    }
  }

  public function getValues() {

    $this->data = array();

    foreach($this->rootDataObjectFilter->getRootDataObjects() as $rootDataObject) {
      $field = $rootDataObject->getField($this->fieldName);
      if ($field) {

        if (is_a($field, 'staticsquish\models\FieldValue')) {
          $this->checkValue($field->getValue());
        } else if (is_a($field, 'staticsquish\models\FieldListValue')) {
          foreach($field->getValues() as $fieldValueScalar) {
            $this->checkValue($fieldValueScalar->getValue());
          }
        };

      }
    }

    return $this->data;


  }



}

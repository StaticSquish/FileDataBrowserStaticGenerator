<?php

namespace staticsquish\aggregation;

use staticsquish\filters\RootDataObjectFilter;
use staticsquish\models\BaseFieldScalarValue;

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

  protected $data = null;

  protected function checkValue(BaseFieldScalarValue $value) {
    if (!isset($this->data[$value->getValueKey()])) {
      $this->data[$value->getValueKey()] = $value;
    }
  }

  public function getValues() {

    if (!is_array($this->data)) {
      $this->data = array();

      foreach($this->rootDataObjectFilter->getRootDataObjects() as $rootDataObject) {
        $field = $rootDataObject->getField($this->fieldName);
        if ($field) {

          if (is_a($field, 'staticsquish\models\BaseFieldScalarValue')) {
            $this->checkValue($field);
          } else if (is_a($field, 'staticsquish\models\FieldListValue')) {
            foreach($field->getValues() as $fieldValueScalar) {
              $this->checkValue($fieldValueScalar);
            }
          };

        }
      }
    }

    return $this->data;

  }



}

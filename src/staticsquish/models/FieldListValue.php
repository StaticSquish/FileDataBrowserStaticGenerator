<?php


namespace staticsquish\models;

/**
 *  @license 3-clause BSD
 */
class FieldListValue extends BaseFieldValue {

  protected $values = array();

  /**
   * Get the value of Values
   *
   * @return mixed
   */
  public function getValues()
  {
      return $this->values;
  }

  public function addValue(BaseFieldScalarValue $fieldValue) {
    $this->values[] = $fieldValue;
  }

  public function hasValue() {
    foreach($this->values as $value) {
      if ($value->hasValue()) {
        return true;
      }
    }
    return false;
  }

}

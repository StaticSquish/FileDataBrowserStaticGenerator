<?php


namespace staticsquish\models;

/**
 *  @license 3-clause BSD
 */
class FieldScalarValueText extends BaseFieldScalarValue  {

  protected $value;

  public function __construct($value) {
    $this->value = $value;
  }

  /**
   * Get the value of Value
   *
   * @return mixed
   */
  public function getValue()
  {
      return $this->value;
  }

  public function getValueAsString() {
        return $this->value;
  }

  public function getValueKey() {
        return $this->value;
  }

  public function getValueKeyForWeb() {
        return md5($this->value);
  }

  /**
   * Set the value of Value
   *
   * @param mixed value
   *
   * @return self
   */
  public function setValue($value)
  {
      $this->value = $value;

      return $this;
  }


  public function hasValue() {
      return (boolean)$this->value;
  }

}

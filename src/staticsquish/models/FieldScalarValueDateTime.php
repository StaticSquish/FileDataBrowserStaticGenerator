<?php


namespace staticsquish\models;

/**
 *  @license 3-clause BSD
 */
class FieldScalarValueDateTime extends BaseFieldScalarValue  {

  protected $value;

  public function __construct($value) {
    $this->setValue($value);
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
        return $this->value->format("c");
  }

  public function getValueKey() {
        return $this->value->format("c");
  }

  public function getValueKeyForWeb() {
      return md5($this->value->format("c"));
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
      $this->value = new \DateTime( $value );

      return $this;
  }


  public function hasValue() {
      return (boolean)$this->value;
  }

}

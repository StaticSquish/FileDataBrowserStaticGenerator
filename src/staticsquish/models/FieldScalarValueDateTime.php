<?php


namespace staticsquish\models;

use staticsquish\config\FieldConfig;

/**
 *  @license 3-clause BSD
 */
class FieldScalarValueDateTime extends BaseFieldScalarValue  {

  protected $value;
  protected $timezone;

  public function __construct($value, FieldConfig $fieldConfig = null) {
    $this->timezone = $fieldConfig ? $fieldConfig->timezone : 'UTC';
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
      $this->value = new \DateTime( $value , new \DateTimeZone($this->timezone));

      return $this;
  }


  public function hasValue() {
      return (boolean)$this->value;
  }

}

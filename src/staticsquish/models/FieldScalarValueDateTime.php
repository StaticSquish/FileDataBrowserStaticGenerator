<?php


namespace staticsquish\models;

use staticsquish\config\FieldConfig;
use staticsquish\BadValueException;

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

    public function isValueEqualTo(BaseFieldValue $compare) {
        return $this->value == $compare->getValue();
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
      try {
          $this->value = new \DateTime( $value , new \DateTimeZone($this->timezone));
      } catch (\Exception $e) {
          throw new BadValueException("DateTime could not parse ". $value);
      }
      return $this;
  }


  public function hasValue() {
      return (boolean)$this->value;
  }

}

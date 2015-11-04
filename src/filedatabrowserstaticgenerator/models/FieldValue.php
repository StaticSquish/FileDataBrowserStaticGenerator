<?php


namespace filedatabrowserstaticgenerator\models;

/**
 *  @license 3-clause BSD
 */
class FieldValue extends BaseField  {

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

}

<?php


namespace filedatabrowserstaticgenerator\models;

/**
 *  @license 3-clause BSD
 */
class FieldValue extends BaseField {

  protected $values = array();

    public function __construct($values = array()) {
      $this->values = $values;
    }

  /**
   * Get the value of Values
   *
   * @return mixed
   */
  public function getValues()
  {
      return $this->values;
  }

}

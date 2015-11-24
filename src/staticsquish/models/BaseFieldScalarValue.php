<?php


namespace staticsquish\models;

/**
 *  @license 3-clause BSD
 */
abstract class BaseFieldScalarValue extends BaseFieldValue {

  public abstract function getValueAsString();

  public abstract function getValueKey();

  public abstract function getValueKeyForWeb();

    public abstract function isValueEqualTo(BaseFieldValue $compare);

}

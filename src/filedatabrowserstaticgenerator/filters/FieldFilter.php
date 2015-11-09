<?php


namespace filedatabrowserstaticgenerator\filters;

use filedatabrowserstaticgenerator\Site;
use filedatabrowserstaticgenerator\models\RootDataObject;
use filedatabrowserstaticgenerator\models\FieldListValue;
use filedatabrowserstaticgenerator\models\FieldValue;

/**
 *  @license 3-clause BSD
 */
class FieldFilter {

    /** @var Site **/
    protected $site;

    protected $fieldName;

    protected $fieldValue;

    public function __construct(Site $site, $fieldName, $fieldValue) {
      $this->site = $site;
      $this->fieldName = $fieldName;
      $this->fieldValue = $fieldValue;
    }


    public function doesRootObjectPass(RootDataObject $rootDataObject) {

        $field = $rootDataObject->getField($this->fieldName);

        if (!$field) {
          return false;
        } else if (is_a($field, 'filedatabrowserstaticgenerator\models\FieldListValue')) {
          return $this->doesFieldListValuePass($field);
        } else if (is_a($field, 'filedatabrowserstaticgenerator\models\FieldValue')) {
          return $this->doesFieldValuePass($field);
        }

    }

    protected function doesFieldValuePass(FieldValue $fieldValue) {
      return ($fieldValue->getValue() == $this->fieldValue);
    }

    protected function doesFieldListValuePass(FieldListValue $fieldListValue) {
      foreach($fieldListValue->getValues() as $fieldValue) {
        if ($this->doesFieldValuePass($fieldValue)) {
          return true;
        }
      }
      return false;
    }


}

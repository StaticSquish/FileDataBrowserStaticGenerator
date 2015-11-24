<?php


namespace staticsquish\filters;

use staticsquish\Site;
use staticsquish\models\RootDataObject;
use staticsquish\models\FieldListValue;
use staticsquish\models\BaseFieldScalarValue;

/**
 *  @license 3-clause BSD
 */
class FieldFilter implements InterfaceFieldFilter {

    /** @var Site **/
    protected $site;

    protected $fieldName;

    protected $fieldValue;

    public function __construct(Site $site, $fieldName, BaseFieldScalarValue $fieldValue) {
      $this->site = $site;
      $this->fieldName = $fieldName;
      $this->fieldValue = $fieldValue;
    }


    public function doesRootObjectPass(RootDataObject $rootDataObject) {

        $field = $rootDataObject->getField($this->fieldName);

        if (!$field) {
          return false;
        } else if (is_a($field, 'staticsquish\models\FieldListValue')) {
          return $this->doesFieldListValuePass($field);
        } else if (is_a($field, 'staticsquish\models\BaseFieldScalarValue')) {
          return $this->doesFieldValuePass($field);
        }

    }

    protected function doesFieldValuePass(BaseFieldScalarValue $fieldValue) {
        return $fieldValue->isValueEqualTo($this->fieldValue);
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

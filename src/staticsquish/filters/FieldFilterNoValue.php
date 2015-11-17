<?php


namespace staticsquish\filters;

use staticsquish\Site;
use staticsquish\models\RootDataObject;
use staticsquish\models\FieldListValue;
use staticsquish\models\FieldValue;

/**
 *  @license 3-clause BSD
 */
class FieldFilterNoValue implements InterfaceFieldFilter {

    /** @var Site **/
    protected $site;

    protected $fieldName;


    public function __construct(Site $site, $fieldName) {
      $this->site = $site;
      $this->fieldName = $fieldName;
    }


    public function doesRootObjectPass(RootDataObject $rootDataObject) {

        $field = $rootDataObject->getField($this->fieldName);

        if (!$field) {
          return true;
        } else if (is_a($field, 'staticsquish\models\FieldListValue')) {
          return !$field->hasValue();
        } else if (is_a($field, 'staticsquish\models\FieldValue')) {
          return !$field->hasValue();
        }

    }




}

<?php

namespace staticsquish\data;

use staticsquish\Site;
use staticsquish\errors\BaseError;
use staticsquish\warnings\BaseWarning;
use staticsquish\models\RootDataObject;

/**
*  @license 3-clause BSD
*/
class DataLoadResult  {

    protected $rootDataObjects = array();

    protected $errors = array();

    protected $warnings = array();

    public function addRootDataObject(RootDataObject $rootDataObject) {
        $this->rootDataObjects[] = $rootDataObject;
    }

    public function addError(BaseError $error) {
        $this->errors[] = $error;
    }

    public function addWarning(BaseWarning $warning) {
        $this->warnings[] = $warning;
    }


    /**
    * @return array
    */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
    * @return array
    */
    public function getWarnings()
    {
        return $this->warnings;
    }




    /**
    * Get the value of Root Data Objects
    *
    * @return mixed
    */
    public function getRootDataObjects()
    {
        return $this->rootDataObjects;
    }

}

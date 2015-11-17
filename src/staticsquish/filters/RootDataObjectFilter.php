<?php


namespace staticsquish\filters;

use staticsquish\Site;
use staticsquish\models\RootDataObject;

/**
 *  @license 3-clause BSD
 */
class RootDataObjectFilter {

  /** @var Site **/
  protected $site;

  public function __construct(Site $site) {
    $this->site = $site;
  }


  protected $fieldFilters = array();

  public function addFieldFilter(InterfaceFieldFilter $fieldFilter) {
    $this->fieldFilters[] = $fieldFilter;
  }


  protected function doesRootObjectPass(RootDataObject $rootObject) {
    foreach($this->fieldFilters as $fieldFilter) {
      if (!$fieldFilter->doesRootObjectPass($rootObject)) {
        return false;
      }
    }

    return true;
  }

  public function getRootDataObjects() {
    $out = array();
    foreach($this->site->getRootDataObjects() as $rootObject) {
        if ($this->doesRootObjectPass($rootObject)) {
          $out[] = $rootObject;
        }
    }
    return $out;
  }

  public function getRootDataObjectCount() {
    $out = 0;
    foreach($this->site->getRootDataObjects() as $rootObject) {
        if ($this->doesRootObjectPass($rootObject)) {
          $out++;
        }
    }
    return $out;
  }



}

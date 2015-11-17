<?php


namespace staticsquish\filters;

use staticsquish\Site;

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


  public function getRootDataObjects() {
    $out = array();
    foreach($this->site->getRootDataObjects() as $rootObject) {
        $include = true;

        foreach($this->fieldFilters as $fieldFilter) {
          if (!$fieldFilter->doesRootObjectPass($rootObject)) {
            $include = false;
          }
        }

        if ($include) {
          $out[] = $rootObject;
        }
    }
    return $out;
  }

}

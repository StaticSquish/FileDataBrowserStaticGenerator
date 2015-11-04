<?php


namespace filedatabrowserstaticgenerator\filters;

use filedatabrowserstaticgenerator\Site;

/**
 *  @license 3-clause BSD
 */
class RootDataObjectFilter {

  /** @var Site **/
  protected $site;

  public function __construct(Site $site) {
    $this->site = $site;
  }



  public function getRootDataObjects() {
    return $this->site->getRootDataObjects();
  }

}

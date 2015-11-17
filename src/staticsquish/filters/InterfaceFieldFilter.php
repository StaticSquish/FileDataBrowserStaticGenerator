<?php


namespace staticsquish\filters;

use staticsquish\Site;
use staticsquish\models\RootDataObject;

/**
 *  @license 3-clause BSD
 */
interface InterfaceFieldFilter {

  public function doesRootObjectPass(RootDataObject $rootDataObject);

}

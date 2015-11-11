<?php

namespace staticsquish\data;

use staticsquish\Site;

/**
 *  @license 3-clause BSD
 */
abstract class BaseRootDataLoader {

	abstract function  isLoadableDataInSite(Site $site, $filename);

	abstract function loadRootDataInSite(Site $site, $filename);

}

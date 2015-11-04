<?php

namespace filedatabrowserstaticgenerator\data;

use filedatabrowserstaticgenerator\Site;

/**
 *  @license 3-clause BSD
 */
abstract class BaseRootDataLoader {

	abstract function  isLoadableDataInSite(Site $site, $filename);

	abstract function loadRootDataInSite(Site $site, $filename);

}

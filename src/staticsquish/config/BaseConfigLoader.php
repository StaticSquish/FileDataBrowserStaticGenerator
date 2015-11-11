<?php

namespace staticsquish\config;

use staticsquish\Site;

/**
 *  @license 3-clause BSD
 */
abstract class  BaseConfigLoader {

	abstract function isLoadableConfigInSite(Site $site);

	abstract function loadConfigInSite(Config $config, Site $site);

}

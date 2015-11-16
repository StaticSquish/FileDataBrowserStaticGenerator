<?php

namespace staticsquish\themes;


/**
*  @license 3-clause BSD
*/
use staticsquish\Site;
use staticsquish\themes\BaseTheme;

abstract class BaseTheme
{


	protected $app;

	function __construct($app)
	{
		$this->app = $app;
	}


	abstract function write(Site $site, $dir);

}

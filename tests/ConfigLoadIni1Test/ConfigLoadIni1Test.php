<?php

/**
 *  @license 3-clause BSD
 */
class ConfigLoadIni1Test extends PHPUnit_Framework_TestCase {

	function testEmptyConfig() {
		global $app;

		$site = new \filedatabrowserstaticgenerator\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteEmpty');

		$defaultConfig = new \filedatabrowserstaticgenerator\config\Config();

		$this->assertEquals($defaultConfig->title, $site->getConfig()->title);
		$this->assertEquals($defaultConfig->theme, $site->getConfig()->theme);

	}

	function testTitle() {
		global $app;

		$site = new \filedatabrowserstaticgenerator\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteTitle');

		$defaultConfig = new \filedatabrowserstaticgenerator\config\Config();

		$this->assertEquals('TEST', $site->getConfig()->title);
		$this->assertEquals($defaultConfig->theme, $site->getConfig()->theme);

	}

}

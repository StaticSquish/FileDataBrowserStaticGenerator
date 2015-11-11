<?php

/**
 *  @license 3-clause BSD
 */
class ConfigLoadIni1Test extends PHPUnit_Framework_TestCase {

	function testEmptyConfig() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteEmpty');

		$defaultConfig = new \staticsquish\config\Config();

		$this->assertEquals($defaultConfig->title, $site->getConfig()->title);
		$this->assertEquals($defaultConfig->theme, $site->getConfig()->theme);
		$this->assertEquals($defaultConfig->baseURL, $site->getConfig()->baseURL);

	}

	function testTitle() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteTitle');

		$defaultConfig = new \staticsquish\config\Config();

		$this->assertEquals('TEST', $site->getConfig()->title);
		$this->assertEquals($defaultConfig->theme, $site->getConfig()->theme);
		$this->assertEquals($defaultConfig->baseURL, $site->getConfig()->baseURL);

	}

	function testBaseURL() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteBaseURL');

		$defaultConfig = new \staticsquish\config\Config();

		$this->assertEquals($defaultConfig->title, $site->getConfig()->title);
		$this->assertEquals($defaultConfig->theme, $site->getConfig()->theme);
		$this->assertEquals('/data', $site->getConfig()->baseURL);

	}

	function testFields() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteFields');

		$this->assertNotNull($site->getConfig()->fields['test1']);
		$field = $site->getConfig()->fields['test1'];
		$this->assertEquals(true, $field->isList);
		$this->assertEquals("test1", $field->label);

		$this->assertNotNull($site->getConfig()->fields['test2']);
		$field = $site->getConfig()->fields['test2'];
		$this->assertEquals(false, $field->isList);
		$this->assertEquals("TESTTWO", $field->label);

	}

}

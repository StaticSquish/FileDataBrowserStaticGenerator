<?php

/**
 *  @license 3-clause BSD
 */
class DataLoadIni1Test extends PHPUnit_Framework_TestCase {

	function testDefaults() {
		global $app;

		$site = new \filedatabrowserstaticgenerator\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteDefaults');

		$this->assertEquals(0, count($site->getDataWarnings()));
		$this->assertEquals(0, count($site->getDataErrors()));

		$rootDataObjects = $site->getRootDataObjects();
		$this->assertEquals(1, count($rootDataObjects));

		$rootDataObject = $rootDataObjects[0];

		$this->assertEquals('test1', $rootDataObject->getTitle());
		$this->assertEquals('test1', $rootDataObject->getSlug());

	}

	function testData() {
		global $app;

		$site = new \filedatabrowserstaticgenerator\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteData');

		$this->assertEquals(0, count($site->getDataWarnings()));
		$this->assertEquals(0, count($site->getDataErrors()));

		$rootDataObjects = $site->getRootDataObjects();
		$this->assertEquals(1, count($rootDataObjects));

		$rootDataObject = $rootDataObjects[0];

		$this->assertEquals('Test 1', $rootDataObject->getTitle());
		$this->assertEquals('testone', $rootDataObject->getSlug());

	}



}

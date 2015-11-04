<?php


use filedatabrowserstaticgenerator\filters\RootDataObjectFilter;
use filedatabrowserstaticgenerator\aggregation\DistinctValuesAggregation;

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
		$this->assertEquals(2, count($rootDataObjects));


		// FIRST OBJECT
		$rootDataObject = $rootDataObjects[0];

		$this->assertEquals('Test 1', $rootDataObject->getTitle());
		$this->assertEquals('testone', $rootDataObject->getSlug());

		$fields = $rootDataObject->getFields();
		$this->assertNotNull($fields['colours']);
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldListValue', get_class( $fields['colours']));
		$fieldScalars = $fields['colours']->getValues();
		$this->assertEquals(2, count($fieldScalars));

		$fieldScalar = $fieldScalars[0];
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldValue', get_class($fieldScalar));
		$this->assertEquals('red', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[1];
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldValue', get_class($fieldScalar));
		$this->assertEquals('orange', $fieldScalar->getValue());

		// SECOND OBJECT
		$rootDataObject = $rootDataObjects[1];

		$this->assertEquals('Test 2', $rootDataObject->getTitle());
		$this->assertEquals('testtwo', $rootDataObject->getSlug());

		$fields = $rootDataObject->getFields();
		$this->assertNotNull($fields['colours']);
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldListValue', get_class( $fields['colours']));
		$fieldScalars = $fields['colours']->getValues();
		$this->assertEquals(3, count($fieldScalars));

		$fieldScalar = $fieldScalars[0];
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldValue', get_class($fieldScalar));
		$this->assertEquals('red', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[1];
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldValue', get_class($fieldScalar));
		$this->assertEquals('green', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[2];
		$this->assertEquals('filedatabrowserstaticgenerator\models\FieldValue', get_class($fieldScalar));
		$this->assertEquals('blue', $fieldScalar->getValue());

		// Site Data
		$aggregation = new DistinctValuesAggregation(new RootDataObjectFilter($site),'colours');

		$values = $aggregation->getValues();
		$this->assertEquals(4, count($values));

		$this->assertEquals('red', $values[0]);
		$this->assertEquals('orange', $values[1]);
		$this->assertEquals('green', $values[2]);
		$this->assertEquals('blue', $values[3]);
	}



}

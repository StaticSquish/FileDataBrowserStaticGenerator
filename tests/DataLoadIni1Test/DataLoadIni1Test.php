<?php


use staticsquish\filters\RootDataObjectFilter;
use staticsquish\aggregation\DistinctValuesAggregation;

/**
 *  @license 3-clause BSD
 */
class DataLoadIni1Test extends PHPUnit_Framework_TestCase {

	function testDefaults() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteDefaults');

		$this->assertEquals(0, count($site->getWarnings()));
		$this->assertEquals(0, count($site->getErrors()));

		$rootDataObjects = $site->getRootDataObjects();
		$this->assertEquals(1, count($rootDataObjects));

		$rootDataObject = $rootDataObjects[0];

		$this->assertEquals('test1', $rootDataObject->getTitle());
		$this->assertEquals('test1', $rootDataObject->getSlug());

	}

	function testData() {
		global $app;

		$site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteData');

		$this->assertEquals(0, count($site->getWarnings()));
		$this->assertEquals(0, count($site->getErrors()));

		$rootDataObjects = $site->getRootDataObjects();
		$this->assertEquals(2, count($rootDataObjects));


		// FIRST OBJECT
		$rootDataObject = $rootDataObjects[0];

		$this->assertEquals('Test 1', $rootDataObject->getTitle());
		$this->assertEquals('testone', $rootDataObject->getSlug());

		$fields = $rootDataObject->getFields();

		$this->assertNotNull($fields['colours']);
		$this->assertEquals('staticsquish\models\FieldListValue', get_class( $fields['colours']));
		$fieldScalars = $fields['colours']->getValues();
		$this->assertEquals(2, count($fieldScalars));

		$fieldScalar = $fieldScalars[0];
		$this->assertEquals('staticsquish\models\FieldScalarValueText', get_class($fieldScalar));
		$this->assertEquals('red', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[1];
		$this->assertEquals('staticsquish\models\FieldScalarValueText', get_class($fieldScalar));
		$this->assertEquals('orange', $fieldScalar->getValue());

    $this->assertTrue($rootDataObject->hasField('started'));
    $this->assertNotNull($fields['started']);
    $this->assertEquals('staticsquish\models\FieldScalarValueDateTime', get_class( $fields['started']));
    $this->assertTrue($fields['started']->hasValue());
    $this->assertEquals('2015-05-05T17:30:00+01:00', $fields['started']->getValueAsString());


		// SECOND OBJECT
		$rootDataObject = $rootDataObjects[1];

		$this->assertEquals('Test 2', $rootDataObject->getTitle());
		$this->assertEquals('testtwo', $rootDataObject->getSlug());

		$fields = $rootDataObject->getFields();

		$this->assertNotNull($fields['colours']);
		$this->assertEquals('staticsquish\models\FieldListValue', get_class( $fields['colours']));
		$fieldScalars = $fields['colours']->getValues();
		$this->assertEquals(3, count($fieldScalars));

		$fieldScalar = $fieldScalars[0];
		$this->assertEquals('staticsquish\models\FieldScalarValueText', get_class($fieldScalar));
		$this->assertEquals('red', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[1];
		$this->assertEquals('staticsquish\models\FieldScalarValueText', get_class($fieldScalar));
		$this->assertEquals('green', $fieldScalar->getValue());

		$fieldScalar = $fieldScalars[2];
		$this->assertEquals('staticsquish\models\FieldScalarValueText', get_class($fieldScalar));
		$this->assertEquals('blue', $fieldScalar->getValue());

    $this->assertFalse($rootDataObject->hasField('started'));

		// Site Data
		$aggregation = new DistinctValuesAggregation(new RootDataObjectFilter($site),'colours');

		$values = $aggregation->getValues();
		$this->assertEquals(4, count($values));

		$this->assertTrue(isset($values['red']));
		$this->assertEquals('red', $values['red']->getValue());

		$this->assertTrue(isset($values['orange']));
		$this->assertEquals('orange', $values['orange']->getValue());

		$this->assertTrue(isset($values['green']));
		$this->assertEquals('green', $values['green']->getValue());

		$this->assertTrue(isset($values['blue']));
		$this->assertEquals('blue', $values['blue']->getValue());
	}



}

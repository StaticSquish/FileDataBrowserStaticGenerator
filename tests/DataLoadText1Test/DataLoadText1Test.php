<?php


use staticsquish\filters\RootDataObjectFilter;
use staticsquish\aggregation\DistinctValuesAggregation;

/**
*  @license 3-clause BSD
*/
class DataLoadText1Test extends PHPUnit_Framework_TestCase {

  public function testData1() {

    global $app;

    $site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteData1');

    $this->assertEquals(0, count($site->getWarnings()));
    $this->assertEquals(0, count($site->getErrors()));

    $rootDataObjects = $site->getRootDataObjects();
    $this->assertEquals(2, count($rootDataObjects));

    // FIRST OBJECT
    $rootDataObject = $rootDataObjects[0];

    $this->assertEquals('test1', $rootDataObject->getTitle());
    $this->assertEquals('test1', $rootDataObject->getSlug());

    $fields = $rootDataObject->getFields();

    $this->assertTrue($rootDataObject->hasField('colour'));
    $this->assertNotNull($fields['colour']);
    $this->assertEquals('staticsquish\models\FieldValue', get_class( $fields['colour']));
    $this->assertTrue($fields['colour']->hasValue());
    $this->assertEquals('red', $fields['colour']->getValue());

    $this->assertTrue($rootDataObject->hasField('shape'));
    $this->assertNotNull($fields['shape']);
    $this->assertEquals('staticsquish\models\FieldValue', get_class( $fields['shape']));
    $this->assertTrue($fields['shape']->hasValue());
    $this->assertEquals('box', $fields['shape']->getValue());



    // SECOND OBJECT
    $rootDataObject = $rootDataObjects[1];

    $this->assertEquals('test2', $rootDataObject->getTitle());
    $this->assertEquals('test2', $rootDataObject->getSlug());

    $fields = $rootDataObject->getFields();

    $this->assertFalse($rootDataObject->hasField('colour'));


    $this->assertTrue($rootDataObject->hasField('shape'));
    $this->assertNotNull($fields['shape']);
    $this->assertEquals('staticsquish\models\FieldValue', get_class( $fields['shape']));
    $this->assertTrue($fields['shape']->hasValue());
    $this->assertEquals('square', $fields['shape']->getValue());

  }


}

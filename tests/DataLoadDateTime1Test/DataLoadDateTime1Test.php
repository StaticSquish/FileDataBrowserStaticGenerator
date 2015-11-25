<?php

use staticsquish\FileLoaderTxt;
use staticsquish\config\FieldConfig;

/**
*  @license 3-clause BSD
*/
class DataLoadDateTime1Test extends PHPUnit_Framework_TestCase {


    function test1() {


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

        $this->assertNotNull($fields['started']);
        $this->assertEquals('staticsquish\models\FieldScalarValueDateTime', get_class( $fields['started']));
        $this->assertEquals('2015-02-02T10:01:23+00:00', $fields['started']->getValueAsString() );

        // SECOND OBJECT
        $rootDataObject = $rootDataObjects[1];

        $this->assertEquals('test2', $rootDataObject->getTitle());
        $this->assertEquals('test2', $rootDataObject->getSlug());

        $fields = $rootDataObject->getFields();

        $this->assertNotNull($fields['started']);
        $this->assertEquals('staticsquish\models\FieldScalarValueDateTime', get_class( $fields['started']));
        $this->assertEquals('2015-07-04T10:01:23+01:00', $fields['started']->getValueAsString() );

    }

    function testBad1() {
        global $app;

        $site = new \staticsquish\Site($app, __DIR__.DIRECTORY_SEPARATOR.'siteBadData1');

        $this->assertEquals(1, count($site->getWarnings()));
        $warning = array_pop($site->getWarnings());
        $this->assertEquals('staticsquish\warnings\DataWarningBadValue', get_class( $warning ));

        $this->assertEquals(0, count($site->getErrors()));




    }
}

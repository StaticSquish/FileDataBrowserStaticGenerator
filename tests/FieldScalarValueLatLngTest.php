<?php

use staticsquish\FileLoaderTxt;
use staticsquish\models\FieldScalarValueLatLng;

/**
*  @license 3-clause BSD
*/
class FieldScalarValueLatLngTest extends PHPUnit_Framework_TestCase {

    function dataProvider() {
        return array(
            array('https://www.google.co.uk/maps/place/Falkirk/@56.0036614,-3.814554,13z/data=xxxxx', 56.0036614, 7, -3.814554, 6),
            array('https://www.google.co.uk/maps/@51.753924,-0.4431272,14.25z', 51.753924, 6, -0.4431272, 7),
            array('http://www.openstreetmap.org/#map=18/55.94833/-3.19029', 55.94833, 5, -3.19029, 5),
            array('https://www.openstreetmap.org/#map=18/55.94833/-3.19029', 55.94833, 5, -3.19029, 5),
        );
    }

    /**
    * @dataProvider dataProvider
    */
    function test1($in, $lat, $latPlaces, $lng, $lngPlaces) {
        $field = new FieldScalarValueLatLng($in);
        $this->assertTrue($field->hasValue());
        $this->assertEquals(round($lat, $latPlaces), round($field->getLat(), $latPlaces));
        $this->assertEquals(round($lng, $lngPlaces), round($field->getLng(), $lngPlaces));
    }

}

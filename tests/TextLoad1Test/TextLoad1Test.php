<?php

use filedatabrowserstaticgenerator\FileLoaderTxt;

/**
*  @license 3-clause BSD
*/
class TextLoad1Test extends PHPUnit_Framework_TestCase {


  function test1() {
    $fileLoader = new FileLoaderTxt(__DIR__. DIRECTORY_SEPARATOR.'test1.txt');

    $keys = $fileLoader->getKeys();
    $this->assertEquals(2, count($keys));
    $this->assertEquals('title', $keys[0]);
    $this->assertEquals('tags', $keys[1]);

    $this->assertTrue($fileLoader->hasKey('title'));
    $this->assertEquals('Bobby',$fileLoader->getAsValue('title'));

    $this->assertTrue($fileLoader->hasKey('tags'));
    $tags = $fileLoader->getAsList('tags');

    $this->assertEquals(3, count($tags));
    $this->assertEquals('shiny', $tags[0]);
    $this->assertEquals('fun', $tags[1]);
    $this->assertEquals('exciting', $tags[2]);
  }
}

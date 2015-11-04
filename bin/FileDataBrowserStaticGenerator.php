<?php

/**
 *  @license 3-clause BSD
 */
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php';


$opts = getopt('',array('help','build','out','site'));


if (isset($opts['help'])) {
  print "HELP PAGE\n";
  die();
}

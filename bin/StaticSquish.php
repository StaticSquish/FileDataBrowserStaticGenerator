<?php

/**
 *  @license 3-clause BSD
 */
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php';


$opts = getopt('',array('help','build','out:','site:','baseurl:'));


function setConfig(\staticsquish\Site $site, $opts) {
	if (isset($opts['baseurl']) && $opts['baseurl']) {
		$site->getConfig()->baseURL = $opts['baseurl'];
	}
}

if (isset($opts['help'])) {
  print "HELP PAGE\n";
  die();
}

if (isset($opts['build'])) {
  if (!isset($opts['out']) || !$opts['out']) {
    print "Build but no out set?\n";
    die();
  }
  if (!isset($opts['site']) || !$opts['site']) {
    print "Build but no site set?\n";
    die();
  }

  $site = new \staticsquish\Site($app, $opts['site']);
	setConfig($site, $opts);

  if ($site->getDataWarnings()) {
    print "Warnings:\n\n";
    foreach($site->getDataWarnings() as $warning) {
    	print get_class($warning)."\n\n";
    }
  }

  if ($site->getDataErrors()) {
    print "ERRORS:\n\n";
    foreach($site->getDataErrors() as $error) {
    	print get_class($error)."\n\n";
    }
  } else {

  print "\n";

  $site->write($opts['out']);

  }


}

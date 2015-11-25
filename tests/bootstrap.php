<?php

/**
 *  @license 3-clause BSD
 */
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

error_reporting( E_STRICT );

use Pimple\Container;

date_default_timezone_set('UTC');

define ('APP_ROOT_DIR', realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);

function autoload($class) {
    // This is not the same as the main app autoload ... but PhpUnit tries to see if several extensions are there by loading them,
    // and then this code errors because the file is not found. So we have to check if the file exists here.
    $filename = APP_ROOT_DIR.'src' .DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
}
spl_autoload_register('autoload');

$app = new Container();

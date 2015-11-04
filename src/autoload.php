<?php
/**
 *  @license 3-clause BSD
 */
define ('APP_ROOT_DIR', realpath(__DIR__.DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR);

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use Pimple\Container;

date_default_timezone_set('UTC');

function autoload($class) {
	require_once __DIR__.DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $class).'.php';
}
spl_autoload_register('autoload');

$app = new Container();

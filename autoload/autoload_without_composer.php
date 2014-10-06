<?php
(!defined('DS')) ? define('DS', DIRECTORY_SEPARATOR) : null;
(!defined('LIBS')) ? define('LIBS', __DIR__ . DS . '..' . DS . 'libs') : null;
(!defined('ATTW')) ? define('ATTW', LIBS . DS . 'Attw') : null;

if (!defined('APP')) {
    throw new Exception('Define the application directory');
}

require_once ATTW . DS . 'Autoloader' . DS . 'Autoloader.php';
require_once ATTW . DS . 'Autoloader' . DS . 'Autoloadable'. DS . 'AutoloadableInterface.php';
require_once ATTW . DS . 'Autoloader' . DS . 'Autoloadable'. DS . 'DefaultAutoloadable.php';

$autoloader = new Attw\Autoloader\Autoloader();
$application = new Attw\Autoloader\Autoloadable\DefaultAutoloadable(APP);
$libs = new Attw\Autoloader\Autoloadable\DefaultAutoloadable(LIBS);
$autoloader->attach($application);
$autoloader->attach($libs);
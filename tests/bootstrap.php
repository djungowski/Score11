<?php
require_once '../bootstrap.php';
define('TESTPATH', BASEPATH . DIRECTORY_SEPARATOR . 'tests');

// Application Enviroment ist phpunit
$_SERVER['APPLICATION_ENV'] = 'phpunit';

// Config setzen
require_once LIBPATH . '/Zend/Registry.php';
require_once LIBPATH . '/Zend/Config.php';

// Nyan Cat phpunit Printer
require_once 'vendor/whatthejeff/fab/src/Fab/Factory.php';
require_once 'vendor/whatthejeff/fab/src/Fab/Fab.php';
require_once 'vendor/whatthejeff/fab/src/Fab/SuperFab.php';

$config = new Zend_Config(
    array(
        'general' => array(
        )
    ),
    true // allowModifications
);
Zend_Registry::set('config', $config);

// Api Config
$api = new Zend_Config(
    array(
        'api' => array(
            'host' => 'http://localhost',
            'user' => '',
            'key' => ''
        )
    )
);
Zend_Registry::set('api', $api);

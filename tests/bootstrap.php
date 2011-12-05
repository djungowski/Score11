<?php
require_once '../bootstrap.php';
define('TESTPATH', BASEPATH . DIRECTORY_SEPARATOR . 'tests');

// Application Enviroment ist phpunit
$_SERVER['APPLICATION_ENV'] = 'phpunit';

// Config setzen
require_once LIBPATH . '/Zend/Registry.php';
require_once LIBPATH . '/Zend/Config.php';

$config = new Zend_Config(
    array(
        'general' => array(
        )
    ),
    true // allowModifications
);
Zend_Registry::set('config', $config);
<?php
require_once '../bootstrap.php';
require_once LIBPATH . '/Zend/Config/Ini.php';
require_once LIBPATH . '/Zend/Registry.php';
require_once LIBPATH . '/Zend/Controller/Front.php';
require_once LIBPATH . '/Zend/Controller/Router/Route.php';
require_once LIBPATH . '/Zend/Controller/Router/Rewrite.php';
require_once LIBPATH . '/Score11/Environment.php';

$config = new Zend_Config_Ini(BASEPATH . '/config/config.ini');
$api = new Zend_Config_Ini(BASEPATH . '/config/api.ini');
Zend_Registry::set('config', $config);
Zend_Registry::set('api', $api);

$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(BASEPATH . '/controllers', 'default');
$front->setBaseUrl($config->general->urlbase);

$env = new Score11\Environment();
if ($_SERVER['APPLICATION_ENV'] === 'development') {
    $front->throwExceptions(true);
    ini_set('display_errors', true);
}

$router = new Zend_Controller_Router_Rewrite();
$router->addRoute(
    'movies',
    new Zend_Controller_Router_Route(
        ':movieid/:name.html',
        array(
            'module' => 'default',
            'controller' => 'movie',
            'action' => 'index'
        ),
        array(
            'movieid' => '\d+'
        )
    )
);
$front->setRouter($router);

$front->dispatch();
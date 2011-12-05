<?php
var_dump($_SERVER);
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

if ($_SERVER['APPLICATION_ENV'] === 'development') {
    
}

$router = new Zend_Controller_Router_Rewrite();
$router->addRoute(
    'me_products',
    new Zend_Controller_Router_Route(
        ':productid/:name.html',
        array(
            'module' => 'me',
            'controller' => 'product',
            'action' => 'index'
        ),
        array(
            'id' => '\d+'
        )
    )
);
$front->setRouter($router);

$front->dispatch();
<?php
require_once '../bootstrap.php';
require_once LIBPATH . '/Zend/Config/Ini.php';
require_once LIBPATH . '/Zend/Registry.php';
require_once LIBPATH . '/Zend/Controller/Front.php';
require_once LIBPATH . '/Zend/Controller/Exception.php';
require_once LIBPATH . '/Zend/Controller/Router/Route.php';
require_once LIBPATH . '/Zend/Controller/Router/Rewrite.php';
require_once LIBPATH . '/Zend/Layout.php';
require_once LIBPATH . '/Score11/Environment.php';


$config = new Zend_Config_Ini(BASEPATH . '/config/config.ini');
$api = new Zend_Config_Ini(BASEPATH . '/config/api.ini');
Zend_Registry::set('config', $config);
Zend_Registry::set('api', $api);

// Set timezone and locale
date_default_timezone_set($config->general->timezone);
$locale = setlocale(LC_ALL, $config->general->locale->toArray());

$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(BASEPATH . '/controllers', 'default');
$front->setBaseUrl($config->general->urlbase);

// Zend_Layout verwenden
Zend_Layout::startMvc();
$layout = Zend_Layout::getMvcInstance();
$layout->urlbase = $config->general->urlbase;
$layout->imgpath = $config->general->urlbase . $config->general->imgpath;
// Kann jederzeit ueberschrieben werden, hier den Standardtitel setzen
$layout->title = $config->general->title;

$env = new Score11\Environment();
if ($_SERVER['APPLICATION_ENV'] === 'development') {
    $front->throwExceptions(true);
    ini_set('display_errors', true);
}

$router = new Zend_Controller_Router_Rewrite();
$router->addRoute(
    'moviepage',
    new Zend_Controller_Router_Route(
        'movie/:movieid/:name',
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

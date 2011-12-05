<?php
// Basispfad ermitteln
$path = explode('/', __FILE__);
// Eine Ebene entfernen, damit faellt /public weg
$path = array_slice($path, 0, count($path) - 1);

define('BASEPATH', implode(DIRECTORY_SEPARATOR, $path));
define('APPPATH', BASEPATH);
define('MODELSPATH', BASEPATH . DIRECTORY_SEPARATOR . 'models');
define('LIBPATH', BASEPATH . DIRECTORY_SEPARATOR . 'library');
define('ZENDPATH', BASEPATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Zend');

// Als letztes: Librarypfad fuer ZF zum include path hinzufuegen
$iniPath = ini_get('include_path');
$iniPath = $iniPath . ':' . LIBPATH;
ini_set('include_path', $iniPath);
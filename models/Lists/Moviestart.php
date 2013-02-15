<?php
namespace Score11\Models\Lists;

use Score11\Api;
use Score11\Models;

class Moviestart extends Models\OnTv
{
    // Genau gleiche Transformation wie bei den TV Tipps, von daher keine weitere Implementierung notwendig    
    
    public function getShowTitle($movie) {
        $config = \Zend_Registry::get('config');
	$timestamp = strtotime($movie['date']);
	$day = strftime($config->dates->listbox->date, $timestamp);
	return sprintf('%s', $day);
    }

}

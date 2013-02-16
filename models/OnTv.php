<?php
namespace Score11\Models;
use Score11\Api;

class OnTv extends Api\Transformator
{
    private $_tvMovies = array();
    
    public function transform($params = array())
    {
        $onTv = $this->getApi()->get(array('limit' => 8));
        $config = \Zend_Registry::get('config');
        $router = $this->getFrontController()->getRouter();
        
        foreach($onTv as $key => $movie) {
        	$timestamp = strtotime($movie['day']);
        	$movie['movielink'] = $router->assemble(
        			array(
        					'movieid' => $movie['movieID'],
        					'name' => $movie['movietitle']
        			),
        			'moviepage'
        	);
        	$timestamp = strtotime($movie['date']);
        	// Verwendete Datumsformate erstellen
        	$movie['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
        	// Anzeigetitel
        	$movie['show-title'] = $this->getShowTitle($movie);
        	// Bild
        	$movie['image'] = $this->getImageLink($movie);

        	$this->_tvMovies[] = $movie;
        }
        return $this->_tvMovies;
    }

    public function getShowTitle($movie)
    {
    	return sprintf('%s<br />%s', $movie['timestamp-time'], $movie['sender']);
    }
}

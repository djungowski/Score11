<?php
require_once MODELSPATH . '/Movie.php';

use Score11\Models\Movie;

require_once LIBPATH . '/Score11/Api/Call.php';

use Score11\Api;

class MovieController extends Zend_Controller_Action
{
	/**
	 * Maximale Laenge des Cast bevor abgeschnitten wird in der Standardansicht.
	 * 
	 * @var Integer
	 */
	private $_maxCast = 7;
	
	public function indexAction()
	{
		$movieId = (int)$this->_getParam('movieid');
		
		$api = new Api\Call('movie/' . $movieId);
		$transformator = new Movie();
		$transformator->setFrontController($this->getFrontController());
		$transformator->setApi($api);
		
		$this->view->movie = $transformator->transform();
		$this->view->maxCast = $this->_maxCast;
	}
}

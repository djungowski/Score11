<?php
use Score11\Api;
use Score11\Models\Movie;
use Score11\Models\Movie\Comments;

require_once LIBPATH . '/Score11/Api/Call.php';
require_once MODELSPATH . '/Movie.php';
require_once MODELSPATH . '/Movie/Comments.php';

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
	
	public function commentsAction()
	{
		$movieId = (int)$this->_getParam('movieid');
		$api = new Api\Call('movie/' . $movieId . '/comments');
		$transformator = new Comments();
		$transformator->setFrontController($this->getFrontController());
		$transformator->setApi($api);
	}
}

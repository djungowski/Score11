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
	
	private $_defaultOffset = 0;
	private $_defaultLimit = 25;
	
	public function indexAction()
	{
		$movieId = (int)$this->_getParam('movieid');
		
		$api = new Api\Call('movie/' . $movieId);
		$transformator = new Movie();
		$transformator->setFrontController($this->getFrontController());
		$transformator->setApi($api);
		
		$this->view->movie = $transformator->transform();
		$this->view->maxCast = $this->_maxCast;
		$this->view->commentsLink = $this->generateCommentsLink();
		$this->view->stepSize = $this->_defaultLimit;
		$this->view->offset = $this->_defaultOffset;
		
		// Titel setzen
		$config = Zend_Registry::get('config');
		$title = sprintf($config->general->title->template, $this->view->movie['ori-title']['show-title']);
		$this->view->layout()->title = $title;
	}
	
	public function commentsAction()
	{
		$movieId = (int)$this->_getParam('movieid');
		$offset = (int)$this->_getParam('offset', $this->_defaultOffset);
		$limit = (int)$this->_getParam('limit', $this->_defaultLimit);
		
		$api = new Api\Call('movie/' . $movieId . '/comments');
		$transformator = new Comments();
		$transformator->setFrontController($this->getFrontController());
		$transformator->setApi($api);
		
		$params = array(
			'offset' => $offset,
			'limit' => $limit
		);
		$this->view->comments = $transformator->transform($params);
	}
	
	private function generateCommentsLink()
	{
		$movieId = (int)$this->_getParam('movieid');
		$movieName = (int)$this->_getParam('name');
		$router = $this->getFrontController()->getRouter();
		return $router->assemble(
			array(
					'movieid' => $movieId,
					'name' => $movieName
			),
			'moviecomments'
		) . '?ajax=1';
	}
}

<?php
require_once LIBPATH . '/Score11/Api/Call.php';
require_once MODELSPATH . '/Comment/Latest.php';
require_once MODELSPATH . '/OnTv.php';
require_once MODELSPATH . '/Rating/Latest.php';
require_once MODELSPATH . '/Lists/Moviestart.php';

use Score11\Api;
use Score11\Models;
use Score11\Models\Comment;
use Score11\Models\Rating;
use Score11\Models\Lists;

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->miniPreviewMovie = array();
        $this->loadLatestComments();
        $this->loadOnTv();
        $this->loadLatestRatings();
        $this->loadMoviestarts();
    }
    
    private function loadLatestComments()
    {
        $api = new Api\Call('comment/latest');
        $transformator = new Comment\Latest();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        
        $this->view->latestComments = $transformator->transform();
        $this->view->miniPreviewMovie['latest-comments'] = $transformator->getMiniPreviewMovie();
    }
    
    private function loadOnTv()
    {
        $api = new Api\Call('ontv/list');
        $transformator = new Models\OnTv();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        
        $this->view->onTv = $transformator->transform();
        $this->view->miniPreviewMovie['ontv-home'] = $transformator->getMiniPreviewMovie();
    }
    
    private function loadLatestRatings()
    {
        $api = new Api\Call('rating/latest');
        $transformator = new Rating\Latest();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        
        $this->view->latestRatings = $transformator->transform();
        $this->view->miniPreviewMovie['rating-latest'] = $transformator->getMiniPreviewMovie();
    }
    
    private function loadMoviestarts()
    {
        $api = new Api\Call('list/moviestart');
        $transformator = new Lists\Moviestart();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        
        $this->view->movieStartlist = $transformator->transform();
        $this->view->miniPreviewMovie['list-moviestart'] = $transformator->getMiniPreviewMovie();
    }
}
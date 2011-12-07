<?php
require_once LIBPATH . '/Score11/Api/Call.php';
require_once MODELSPATH . '/Comment/Latest.php';
require_once MODELSPATH . '/OnTv.php';

use Score11\Api;
use Score11\Models;
use Score11\Models\Comment;

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->loadLatestComments();
        $this->loadOnTv();
    }
    
    private function loadLatestComments()
    {
        $api = new Api\Call('comment/latest');
        $transformator = new Comment\Latest();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        $latestComments = $transformator->transform();
        $miniPreviewMovie = $transformator->getMiniPreviewMovie();
        
        $this->view->miniPreviewMovie = $miniPreviewMovie;
        $this->view->latestComments = $latestComments;
    }
    
    private function loadOnTv()
    {
        $api = new Api\Call('ontv/list');
        $transformator = new Models\OnTv();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        $this->view->onTv = $transformator->transform();
    }
}
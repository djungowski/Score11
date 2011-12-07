<?php
require_once LIBPATH . '/Score11/Api/Call.php';
require_once MODELSPATH . '/Comment/Latest.php';

use Score11\Models\Comment;

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $api = new Score11\Api\Call('comment/latest');
        $transformator = new Comment\Latest();
        $transformator->setFrontController($this->getFrontController());
        $transformator->setApi($api);
        $latestComments = $transformator->transform();
        $miniPreviewMovie = $transformator->getMiniPreviewMovie();
        
        $this->view->miniPreviewMovie = $miniPreviewMovie;
        $this->view->latestComments = $latestComments;
    }
}
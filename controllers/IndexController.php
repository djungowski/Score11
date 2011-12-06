<?php
require_once LIBPATH . '/Score11/Api/Call.php';

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $api = new Score11\Api\Call('comment/latest');
        $json = $api->get();
        $this->view->latestComments = $json;
    }
}
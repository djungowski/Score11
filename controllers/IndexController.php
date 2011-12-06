<?php
require_once LIBPATH . '/Score11/Api/Call.php';

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $api = new Score11\Api\Call('comment/latest');
        $latestComments = $api->get();
        
        $miniPreviewMovie = null;
        foreach ($latestComments as $key => $comment) {
            $shortenedText = substr($comment['text'], 0, 450);
            if (strlen($comment['text']) > 450) {
                $shortenedText .= ' &raquo;&raquo;&raquo;';
            }
            $latestComments[$key]['text_shortened'] = $shortenedText;
            
            if ($comment['image'] == 'y' && !is_null($miniPreviewMovie)) {
                $miniPreviewMovie = $key;
            }
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($miniPreviewMovie)) {
            $miniPreviewMovie = 0;
        }
        $this->view->miniPreviewMovie = $latestComments[$miniPreviewMovie];
        $this->view->latestComments = $latestComments;
    }
}
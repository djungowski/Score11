<?php
require_once LIBPATH . '/Score11/Api/Call.php';

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $api = new Score11\Api\Call('comment/latest');
        $latestComments = $api->get();
        
        $miniPreviewMovie = null;
        $router = $this->getFrontController()->getRouter();
        foreach ($latestComments as $key => $comment) {
            // Text kuerzen
            $shortenedText = substr($comment['text'], 0, 450);
            if (strlen($comment['text']) > 450) {
                $shortenedText .= ' &raquo;&raquo;&raquo;';
            }
            $latestComments[$key]['text_shortened'] = $shortenedText;
            
            $timestamp = strtotime($comment['timestamp']);
            // Verwendete Datumsformate erstellen
            $latestComments[$key]['timestamp-day'] = strftime('%A, %d. %B %Y', $timestamp);
            $latestComments[$key]['timestamp-time'] = date('H:i', $timestamp);
            
            // Links zum Film generieren
            $latestComments[$key]['movielink'] = $router->assemble(
                array(
                    'movieid' => $comment['refID'],
                    'name' => $comment['movietitle']
                ),
                'moviepage'
            );
            
            // Mini Preview feststellen
            if ($comment['hasimage'] == 'y' && !is_null($miniPreviewMovie)) {
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
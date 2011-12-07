<?php
namespace Score11\Models\Comment;
use Score11\Api;

require_once LIBPATH . '/Score11/Api/Transformator.php';

class Latest extends Api\Transformator
{
    private $_latestComments;
    
    private $_miniPreviewMovie;
    
    public function transform()
    {
        $this->_latestComments = $this->getApi()->get();
        $router = $this->getFrontController()->getRouter();
        $config = \Zend_Registry::get('config');
        
        foreach ($this->_latestComments as $key => $comment) {
            // Text kuerzen
            $shortenedText = substr($comment['text'], 0, 450);
            if (strlen($comment['text']) > 450) {
                $shortenedText .= ' &raquo;&raquo;&raquo;';
            }
            $this->_latestComments[$key]['text_shortened'] = $shortenedText;
            
            $timestamp = strtotime($comment['timestamp']);
            // Verwendete Datumsformate erstellen
            $this->_latestComments[$key]['timestamp-day'] = strftime($config->dates->listbox->title, $timestamp);
            $this->_latestComments[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
            
            // Links zum Film generieren
            $this->_latestComments[$key]['movielink'] = $router->assemble(
                array(
                    'movieid' => $comment['refID'],
                    'name' => $comment['movietitle']
                ),
                'moviepage'
            );
            
            // Mini Preview feststellen
            if ($comment['hasimage'] == 'y' && !isset($this->_miniPreviewMovie)) {
                $this->_miniPreviewMovie = $key;
            }
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($this->_miniPreviewMovie)) {
            $this->_miniPreviewMovie = 0;
        }
        return $this->_latestComments;
    }
    
    public function getMiniPreviewMovie()
    {
        return $this->_latestComments[$this->_miniPreviewMovie];
    }
}
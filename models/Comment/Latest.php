<?php
namespace Score11\Models\Comment;
use Score11\Api;

require_once LIBPATH . '/Score11/Api/Transformator.php';

class Latest extends Api\Transformator
{
    const MAX_COMMENT_LENGTH = 450;
    
    private $_latestComments;
    
    private $_miniPreviewMovie;
    
    /**
     * Neueste Kommentare transformiert zurueckgeben
     *
     * @param $params Parameter fuer den API Call
     * @return Array
     */
    public function transform($params = array())
    {
        $this->_latestComments = $this->getApi()->get();
        $router = $this->getFrontController()->getRouter();
        $config = \Zend_Registry::get('config');
        
        foreach ($this->_latestComments as $key => $comment) {
            // Link zum Film generieren
            $movieLink = $router->assemble(
                array(
                    'movieid' => $comment['refID'],
                    'name' => $comment['movietitle']
                ),
                'moviepage'
            );
            $this->_latestComments[$key]['movielink'] = $movieLink;
            
            // Text kuerzen
            $this->_latestComments[$key]['text_shortened'] = $this->shortenText($comment['text'], $movieLink);
            
            $timestamp = strtotime($comment['timestamp']);
            // Verwendete Datumsformate erstellen
            $this->_latestComments[$key]['timestamp-day'] = strftime($config->dates->listbox->title, $timestamp);
            $this->_latestComments[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
            
            // Mini Preview feststellen
            $this->checkForMiniPreview($comment['hasimage'], $key);
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($this->_miniPreviewMovie)) {
            $this->_miniPreviewMovie = 0;
        }
        return $this->_latestComments;
    }

    /**
     * Pruefen, ob sich dieser Film fuer die Mini-Preview eignet
     * (= hat der Film ein Bild?)
     * 
     * @param String $movieHasImage
     * @param Integer $key
     */
    private function checkForMiniPreview($movieHasImage, $key)
    {
        if ($movieHasImage == 'y' && !isset($this->_miniPreviewMovie)) {
            $this->_miniPreviewMovie = $key;
        }
    }    
    
    /**
     * Text kuerzen und Kuerzungshinweis mit Link versehen
     * 
     * @param String $text
     * @param String $movieLink
     */
    private function shortenText($text, $movieLink)
    {
        // Ist der Text kuerzer als das maximum, Originaltext zurueckgeben und nix tun
        if (strlen($text) <= self::MAX_COMMENT_LENGTH) {
            return $text;
        }
        $shortenedText = substr($text, 0, self::MAX_COMMENT_LENGTH);
        // >> >> >> mit Link hinzufuegen, wenn der Text gekuerzt wurde
        $shortenedText .= sprintf(' <a href="%s">&raquo;&raquo;&raquo;</a>', $movieLink);
        return $shortenedText;
    }
    
    /**
     * Den Film fuer die Mini Preview zurueckgeben
     * transform() muss vorher ausgefuehrt worden sein!
     * 
     * @return Array
     */
    public function getMiniPreviewMovie()
    {
        return $this->_latestComments[$this->_miniPreviewMovie];
    }
}
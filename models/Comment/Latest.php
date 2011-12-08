<?php
namespace Score11\Models\Comment;
use Score11\Api;

require_once LIBPATH . '/Score11/Api/Transformator.php';

class Latest extends Api\Transformator
{
    /**
     * Maximale Textlaenge fuer alle Kommentare zusammen
     * 
     * @var Integer
     */
    const MAX_COMMENT_LENGTH = 520;
    
    /**
     * Neueste Kommentare transformiert zurueckgeben
     *
     * @param $params Parameter fuer den API Call
     * @return Array
     */
    public function transform($params = array())
    {
        $latestCommentsOriginal = $this->getApi()->get();
        $latestComments = array();
        $router = $this->getFrontController()->getRouter();
        $config = \Zend_Registry::get('config');
        
        $commentsLengthSum = 0;
        foreach ($latestCommentsOriginal as $key => $comment) {
            // In neues Array uebernehmen
            $latestComments[$key] = $comment;
            // Link zum Film generieren
            $movieLink = $router->assemble(
                array(
                    'movieid' => $comment['refID'],
                    'name' => $comment['movietitle']
                ),
                'moviepage'
            );
            $latestComments[$key]['movielink'] = $movieLink;
            
            $timestamp = strtotime($comment['timestamp']);
            // Verwendete Datumsformate erstellen
            $latestComments[$key]['timestamp-day'] = strftime($config->dates->listbox->title, $timestamp);
            $latestComments[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
            
            // Mini Preview feststellen
            $this->checkForMiniPreview($latestComments[$key]);
            
            $commentLength = strlen($comment['text']);
            if ($commentsLengthSum + $commentLength >= self::MAX_COMMENT_LENGTH) {
                $textMaxLength = $commentLength - $commentsLengthSum;
                // Text kuerzen
                $latestComments[$key]['text_shortened'] = $this->shortenText($comment['text'], $movieLink, $textMaxLength);
                // Ist die Maximallaenge der Text erreicht, keine weiteren Filme mehr bearbeiten
                break;
            }
            // Ist die maximale Anzahl noch nicht erreicht, Text ungekuerzt uebernehmen
            $latestComments[$key]['text_shortened'] = $comment['text'];
            $commentsLengthSum += $commentLength;
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($this->_miniPreviewMovie)) {
            $this->_miniPreviewMovie = $latestComments[0];
        }
        return $latestComments;
    }
    
    /**
     * Text kuerzen und Kuerzungshinweis mit Link versehen
     * 
     * @param String $text
     * @param String $movieLink
     */
    private function shortenText($text, $movieLink, $length)
    {
        $shortenedText = substr($text, 0, $length);
        // >> >> >> mit Link hinzufuegen, wenn der Text gekuerzt wurde
        $shortenedText .= sprintf(' <a href="%s">&raquo;&raquo;&raquo;</a>', $movieLink);
        return $shortenedText;
    }
}
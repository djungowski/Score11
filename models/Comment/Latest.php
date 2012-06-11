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
    const MAX_COMMENT_LENGTH_SUM = 400;

    /**
     * Maximale Textlaenge fuer einen einzelnen Kommentar
     *
     * @var Integer
     */
    const MAX_COMMENT_LENGTH_SINGLE = 230;

    /**
     * Maximale Anzahl an Kommentaren
     *
     * @var Integer
     */
     const MAX_COMMENTS = 3;
    
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
	    // Erstmal grundsaetzlich jeden Kommentar kuerzen, falls er laenger ist als das Einzelmaximum
	    if ($commentLength > self::MAX_COMMENT_LENGTH_SINGLE) {
                $latestComments[$key]['text_shortened'] = $this->shortenText($comment['text'], $movieLink, self::MAX_COMMENT_LENGTH_SINGLE);
		$commentLength = self::MAX_COMMENT_LENGTH_SINGLE;
	    } else {
	    	$latestComments[$key]['text_shortened'] = $comment['text'];
            	$commentLength = strlen($comment['text']);
	    }

            // Ist das Gesamtmaximum erreicht, Text nochmal kuerzen
	    if ($commentsLengthSum + $commentLength > self::MAX_COMMENT_LENGTH_SUM) {
		$textMaxLength = self::MAX_COMMENT_LENGTH_SUM - $commentsLengthSum;
		$latestComments[$key]['text_shortened'] = $this->shortenText($comment['text'], $movieLink, $textMaxLength);
            	$commentLength = $textMaxLength;
	    }
            $commentsLengthSum += $commentLength;

	    // Ist das Gesamtmaximum erreicht, keine weiteren Kommentare mehr aufnehmen
            // Auch: Nicht mehr als 3 Kommentare anzeigen
	    if ($commentsLengthSum === self::MAX_COMMENT_LENGTH_SUM || ($key +1 ) === self::MAX_COMMENTS) {
	    	break;
	    }
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

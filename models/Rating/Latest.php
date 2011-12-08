<?php
namespace Score11\Models\Rating;
use Score11\Api;

class Latest extends Api\Transformator
{
    public function transform($params = array())
    {
        $this->_latestRatings = $this->getApi()->get($params);
        $router = $this->getFrontController()->getRouter();
        $config = \Zend_Registry::get('config');
        
        foreach($this->_latestRatings as $key => $movie) {
            // Link zum Film generieren
            $movieLink = $router->assemble(
                array(
                    'movieid' => $movie['movieID'],
                    'name' => $movie['movietitle']
                ),
                'moviepage'
            );
            $this->_latestRatings[$key]['movielink'] = $movieLink;
            
            $timestamp = strtotime($movie['timestamp']);
            // Verwendete Datumsformate erstellen
            $this->_latestRatings[$key]['timestamp-day'] = strftime($config->dates->listbox->title, $timestamp);
            $this->_latestRatings[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
            
            // Mini Preview feststellen
            $this->checkForMiniPreview($this->_latestRatings[$key]);
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($this->_miniPreviewMovie)) {
            $this->_miniPreviewMovie = $this->_latestRatings[0];
        }
        return $this->_latestRatings;
    }
}
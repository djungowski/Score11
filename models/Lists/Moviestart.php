<?php
namespace Score11\Models\Lists;
use Score11\Api;

class Moviestart extends Api\Transformator
{
    private $_movies = array();
    
    public function transform($params = array())
    {
        $movies = $this->getApi()->get();
        $config = \Zend_Registry::get('config');
        $router = $this->getFrontController()->getRouter();
        
        foreach ($movies as $date => $movies) {
            $timestamp = strtotime($date);            
            foreach($movies as $key => $movie) {
                $movies[$key]['movielink'] = $router->assemble(
                    array(
                        'movieid' => $movie['ID'],
                        'name' => $movie['movietitle']
                    ),
                    'moviepage'
                );
                $timestamp = strtotime($movie['date']);
                // Verwendete Datumsformate erstellen
                $movies[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);

                $this->checkForMiniPreview($movies[$key]);
            }
            $this->_movies[] = array(
                'date' => strftime($config->dates->listbox->title, $timestamp),
                'movies' => $movies
            );
        }
        // Wenn kein Film ein Bild hat: Den ersten Film nehmen
        if (is_null($this->_miniPreviewMovie) && !empty($movies)) {
            $this->_miniPreviewMovie = $this->_movies[0]['movies'][0];
        }
        return $this->_movies;
    }
}
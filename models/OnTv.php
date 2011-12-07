<?php
namespace Score11\Models;
use Score11\Api;

class OnTv extends Api\Transformator
{
    public function transform($params = array())
    {
        $onTv = $this->getApi()->get();
        $config = \Zend_Registry::get('config');
        $router = $this->getFrontController()->getRouter();
        $tvMovies = array();
        
        foreach ($onTv as $date => $movies) {
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
            }
            $tvMovies[] = array(
                'date' => strftime($config->dates->listbox->title, $timestamp),
                'movies' => $movies
            );
        }
        return $tvMovies;
    }
}
<?php
namespace Score11\Models;
use Score11\Api;

class OnTv extends Api\Transformator
{
    public function transform($params = array())
    {
        $onTv = $this->getApi()->get();
        $config = \Zend_Registry::get('config');
        foreach ($onTv as $key => $movie) {
            $timestamp = strtotime($movie['date']);
            // Verwendete Datumsformate erstellen
            $onTv[$key]['timestamp-day'] = strftime($config->dates->listbox->title, $timestamp);
            $onTv[$key]['timestamp-time'] = strftime($config->dates->listbox->time, $timestamp);
        }
    }
}
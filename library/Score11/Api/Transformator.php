<?php
namespace Score11\Api;

abstract class Transformator
{
    /**
     * Front Controller Instanz
     * 
     * @var \Zend_Controller_Front
     */
    private $_frontController;
    
    /**
     * API Call Instanz, die uns die Daten zum transformieren liefert
     * 
     * @var Call
     */
    private $_api;
    
    /**
     * Front Controller setzen
     * 
     * @param \Zend_Controller_Front $front
     */
    public function setFrontController(\Zend_Controller_Front $front)
    {
        $this->_frontController = $front;
    }
    
    /**
     * Gib mir den Front Controller!
     * 
     * @return \Zend_Controller_Front
     */
    public function getFrontController()
    {
        return $this->_frontController;
    }
    
    /**
     * API Call setzen
     * 
     * @param Call $api
     */
    public function setApi(Call $api)
    {
        $this->_api = $api;
    }
    
    /**
     * Gib mir den API Call!
     * 
     * @return Call
     */
    public function getApi()
    {
        return $this->_api;
    }
    
    /**
     * Die tatsaechliche Transformation durchfuehren
     * Muss in Kind-Klasse implementiert werden
     * 
     */
    public abstract function transform();
}
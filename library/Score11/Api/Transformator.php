<?php
namespace Score11\Api;
use Score11\Models\Movie\Image;

require_once MODELSPATH . '/Movie/Image.php';

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
     * Mini Preview Movie
     * 
     * @var Array
     */
    protected $_miniPreviewMovie;
    
    /**
     * Konstruktor
     * 
     */
    public function __construct()
    {
    	$this->init();
    }
    
    /**
     * Diese Methode in Ableitung ueberladen,
     * wenn Initialisierungen vorgenommen werden muessen
     * 
     */
    protected function init()
    {
    	
    }
    
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
     * Pruefen, ob sich dieser Film fuer die Mini-Preview eignet
     * (= hat der Film ein Bild?)
     * 
     * @param String $movieHasImage
     * @param Integer $key
     */
    protected function checkForMiniPreview($movie)
    {
        $canBeUsed = ($movie['hasimage'] == 'y' && !isset($this->_miniPreviewMovie));
        if ($canBeUsed) {
            $this->_miniPreviewMovie = $movie;
        }
        return $canBeUsed;
    }
    
    /**
     * Den Film fuer die Mini Preview zurueckgeben
     * transform() muss vorher ausgefuehrt worden sein!
     * 
     * @return Array
     */
    public function getMiniPreviewMovie()
    {
        return $this->_miniPreviewMovie;
    }
    
    /**
     * Bildlink fuer den Film zurueckgeben. Nimmt das Standardbild, falls der Film
     * kein eigenes Bild hat
     * 
     * @param Array $movie
     * @return String
     */
    protected function getImageLink($movie)
    {
    	$image = new Image();
    	return $image->getLink($movie);
    }
    
    /**
     * Die tatsaechliche Transformation durchfuehren
     * Muss in Kind-Klasse implementiert werden
     * 
     * @param Array Parameter fuer den API Call
     * @return Array
     * 
     */
    public abstract function transform($params = array());
}
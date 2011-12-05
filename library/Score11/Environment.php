<?php
namespace Score11;

class Environment
{
    /**
     * Die Anwendungs-Umgebung
     * Standardmaessig befinden wir uns in der Produktiv-Umgebung
     * 
     * @var String
     */
    private $_environment = 'production';
    
    /**
     * Konstruktor
     * 
     */
    public function __construct()
    {
        if (isset($_SERVER['APPLICATION_ENV'])) {
            $this->_environment = $_SERVER['APPLICATION_ENV'];
        }
    }
    
    /**
     * Aktuelle Umgebung zurueckgeben
     * 
     * @return String
     */
    public function get()
    {
        return $this->_environment;
    }
    
    /**
     * Zurueckgeben, ob die aktuelle Umgebung Entwicklungsumgebung ist
     * 
     * @return Boolean
     */
    public function isDev()
    {
        return ($this->_environment === 'development');
    }
}
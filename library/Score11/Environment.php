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
    
    public function __construct()
    {
        if (isset($_SERVER['APPLICATION_ENV'])) {
            $this->_environment = $_SERVER['APPLICATION_ENV'];
        }
    }
    
    public function get()
    {
        return $this->_environment;
    }
}
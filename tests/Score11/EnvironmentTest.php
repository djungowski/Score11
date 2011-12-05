<?php
namespace Score11;

require_once LIBPATH . '/Score11/Environment.php';

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{   
    public function testGet()
    {
        $env = new Environment();
        $this->assertEquals('phpunit', $env->get());
    }
    
    public function testGetDefault()
    {
        // Bisherigen Wert speichern
        $currentEnv = $_SERVER['APPLICATION_ENV'];
        // Wert loeschen
        unset($_SERVER['APPLICATION_ENV']);
        // Standardwert ist "production"
        $env = new Environment();
        $this->assertEquals('production', $env->get());
    }
}
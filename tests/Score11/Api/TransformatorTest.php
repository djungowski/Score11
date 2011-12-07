<?php
namespace Score11\Api;

require_once LIBPATH . '/Score11/Api/Transformator.php';
require_once LIBPATH . '/Score11/Api/Call.php';
require_once LIBPATH . '/Zend/Controller/Front.php';

class TransformatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Der Transformator selber ist eine abstrakte Klasse,
     * deswegen testen wir gegen eine Mock-Klasse
     * 
     * @return Transformator
     */
    private function getTransformator()
    {
        return $this->getMockForAbstractClass('Score11\Api\Transformator');
    }
    
    public function testSetAndGetFrontController()
    {
        $front = \Zend_Controller_Front::getInstance();
        $transformator = $this->getTransformator();
        $transformator->setFrontController($front);
        // Der Getter muss jetzt genau den gleichen Front Controller zurueckgeben
        $this->assertSame($front, $transformator->getFrontController());
    }
    
    public function testSetAndGetApi()
    {
        $api = new Call('comment/latest');
        $transformator = $this->getTransformator();
        $transformator->setApi($api);
        // Der Getter muss jetzt das gleiche API Call Objekt zurueckgeben
        $this->assertSame($api, $transformator->getApi());
    }
    
    /**
     * Es gibt eine transform() Methode
     * 
     */
    public function testAbstractTransform()
    {
        $transformator = $this->getTransformator();
        $this->assertTrue(method_exists($transformator, 'transform'));
    }
}
<?php
require_once TESTPATH . '/Score11/Api/TransformatorTest.php';
require_once TESTPATH . '/Score11/EnvironmentTest.php';

class Score11_Suite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        $this->setName('Score11 Test Suite');
    }
    
    public static function suite()
    {
        return new self();
    }
}
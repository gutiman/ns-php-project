<?php
require_once("../../config/config.php");  
require_once(MODEL_PATH . "/lookup.php");
 
class CalculatorTests extends PHPUnit_Framework_TestCase
{
    private $lookup;
 
    protected function setUp()
    {
        $this->lookup = new LookUp();
    }
 
    protected function tearDown()
    {
        $this->lookup = NULL;
    }

    public function addDataProvider($function) {
        return array(
            array('nacion.com', $this->lookup->$function('nacion.com')),
            array('cnn.com', $this->lookup->$function('cnn.com')),
            array('123', $this->lookup->$function('123'))
        );
    }
 
    public function testLookUpResults($dns, $function, $expected)
    {
        $result = $this->lookup->$function($dns);
        $this->assertEqualsCanonicalizing($expected, $result);
    }
}
<?php
namespace SEM;

require('..\Application_Handler.php');

class Application_HandlerTest extends \PHPUnit_Framework_TestCase
{
    // contains the object of the Application_Handler class
    var $abc;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function setUp() {
        // create a new instance of String with the
        // string 'abc'
        $this->abc = new Application_Handler();
    }

    // called after the test functions are executed
    // this function is defined in PHPUnit_TestCase and overwritten
    // here
    function tearDown() {
        // delete the instance
        unset($this->abc);
    }

    public function testinitial()
    {
        $result = $this->abc->initial('Sameera Sampath Nandasiri');
        $expected='SS';
        $this->assertTrue($result == $expected);
    }

    public function testinitialnot()
    {
        $result = $this->abc->initial('Sameera Sampath Nandasiri');
        $expected='SSN';
        $this->assertFalse($result == $expected);
    }

    /**
     * @depends testinitialnot
     */

    public function testinitialcontain()
    {
        $result = $this->abc->initial('Sameera Sampath Nandasiri');
        $expected='SSN';
        $this->assertContains($result, $expected, '', true);
    }

    public function testLastName()
    {
        $result = $this->abc->LastName('Sameera Sampath Nandasiri');
        $expected='Nandasiri';
        $this->assertTrue($result == $expected);
    }

    /**
     * @param string $original String to be cleaned
     * @param string $expected What we expect our result to be
     *
     * @dataProvider cleanProvider
     */
    public function testclean($expected,$origional)
    {
        $result = $this->abc->clean($origional);
        $this->assertEquals($expected, $result);
    }

    public function cleanProvider()
    {
        return array(
            array('sameera.nandasiri@gmail.com' , 'sameera.nandasiri@gmail.com'),
            array('sameera&amp;sampathn str' , 'sameera&sampath\n \\str'),
            array('abc n b&quot;&quot;sfed n t /f' , 'abc n b""sfed \n \t /f'),
            array('Sameera Sampath' , 'Sameera Sampath'),
        );
    }

    /**
     * @dataProvider religionProvider
     */
    public function testreligion($expected,$origional)
    {
        $result = $this->abc->religion($origional);
        $this->assertEquals($expected, $result);
    }

    public function religionProvider()
    {
        return array(
            array("Buddhism" , "1"),
            array("Hindu" , "2"),
            array("Catholic" , "3"),
            array("Christian" , "4"),
        );
    }

}
?>
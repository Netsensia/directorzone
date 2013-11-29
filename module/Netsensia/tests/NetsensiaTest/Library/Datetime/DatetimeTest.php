<?php
namespace NetsensiaTest\Library\Datetime;

use Netsensia\Library\Datetime\Datetime;

/**
 * Netsensia\Library\Datetime\Datetime test case.
 */
class DatetimeTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }
    
    public function testUkDateToGenericDateWorksWithValidDates()
    {
        $this->assertEquals(
            '1972-01-01',
            Datetime::ukDateToGenericDate('01/01/1972')
        );
        
        $this->assertEquals(
            '1972-01-31',
            Datetime::ukDateToGenericDate('31/01/1972')
        );
    }
    
    public function testUkDateToGenericDateThrowsExceptionWithInvalidDate()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        $this->assertEquals(
            '1972-01-01',
            Datetime::ukDateToGenericDate('01/21/1972')
        );
    }
}

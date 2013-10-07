<?php
namespace Tests\Application\Controller;

use PHPUnit_Framework_TestCase;
use Application\Controller\IndexController;
use Netsensia\Test\NetsensiaControllerTest;

class IndexControllerTest extends NetsensiaControllerTest
{
    public function setup()
    {
        $this->setController(new IndexController(), 'index');
        parent::setup();
    }
    
    public function testRoutesAreAvailable()
    {
        $this->isRouteAvailable('index');
    }
}

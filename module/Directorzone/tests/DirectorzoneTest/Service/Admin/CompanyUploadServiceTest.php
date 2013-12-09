<?php
namespace DirectorzoneTest\Service\Admin;

use Directorzone\Service\Admin\CompanyUploadService;
use Zend\Db\ResultSet\ResultSet;

class CompanyUploadServiceTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    
    public function setup()
    {
        $tableGatewayMock = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $resultSet = new ResultSet();
        
        $tableGatewayMock->shouldReceive('select')
            ->once()
            ->andReturn($resultSet);
        
        $tableGatewayMock->shouldReceive('insert')
            ->once()
            ->andReturn(1);
        
        $this->service = new CompanyUploadService(
            $tableGatewayMock
        );
        
        parent::setup();
    }
    
    public function testRejectsNonCsvFile()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->ingest('hello.xls');
    }
    
    public function testRejectsEmptyFile()
    {
        $contents = '';
        
        file_put_contents('tests/workspace/test.csv', $contents);
        
        $this->setExpectedException('InvalidArgumentException');
        $this->service->ingest('tests/workspace/test.csv');
    }
    
    public function testAcceptsOneLineFile()
    {
        $contents = 'name';
    
        file_put_contents('tests/workspace/test.csv', $contents);
    
        $companies = $this->service->ingest('tests/workspace/test.csv');
        
        $this->assertEquals(1, count($companies));
        
        $this->assertEquals('name', $companies[0]['name']);
    }
    
    public function testAcceptsOneLineFileWithOneCarriageReturn()
    {
        $contents = 'name' . PHP_EOL;
    
        file_put_contents('tests/workspace/test.csv', $contents);
    
        $companies = $this->service->ingest('tests/workspace/test.csv');
        
        $this->assertEquals(1, count($companies));
        
        $this->assertEquals('name', $companies[0]['name']);
    }
    
    public function testAcceptsOneLineFileWithTwoCarriageReturns()
    {
        $contents = 'name' . PHP_EOL . PHP_EOL;
    
        file_put_contents('tests/workspace/test.csv', $contents);
    
        $companies = $this->service->ingest('tests/workspace/test.csv');
        
        $this->assertEquals(1, count($companies));
        
        $this->assertEquals('name', $companies[0]['name']);
    }
    
    public function testAcceptsMultipleLineFile()
    {
        $contents = 'name1,' . PHP_EOL;
        $contents .= 'name2' . PHP_EOL;
        $contents .= 'name3,' . PHP_EOL;
        $contents .= PHP_EOL . PHP_EOL;
    
        file_put_contents('tests/workspace/test.csv', $contents);
    
        $companies = $this->service->ingest('tests/workspace/test.csv');
    
        $this->assertEquals(3, count($companies));
    
        $this->assertEquals('name1', $companies[0]['name']);
        $this->assertEquals('name2', $companies[1]['name']);
        $this->assertEquals('name3', $companies[2]['name']);
    }
}

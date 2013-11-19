<?php
namespace DirectorzoneTest\Service\Admin;

use Netsensia\Test\NetsensiaTest;
use Directorzone\Service\Admin\CompanyUploadService;
use Zend\Db\ResultSet\ResultSet;
use Directorzone\Service\CompanyService;

class CompanyServiceTest extends NetsensiaTest
{
    private $tableMock;
    
    public function setup()
    {
        $this->tableMock = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        
        parent::setup();
    }
    
    public function testIsCompanyNameTaken()
    {
        $resultSet = new ResultSet();
        $resultSet->initialize([['count' => 1]]);
        
        $directoryMock = $this->tableMock;
        
        $directoryMock->shouldReceive('select')
            ->once()
            ->andReturn($resultSet);
                
        $service = new CompanyService(
            $this->tableMock,
            $this->tableMock,
            $directoryMock
        );
        
        $this->assertTrue($service->isCompanyNumberTaken(1));
    }
    
    public function testIsCompanyNameNotTaken()
    {
        
        $resultSet = new ResultSet();
        $resultSet->initialize([['count' => 0]]);

        $directoryMock = $this->tableMock;
    
        $directoryMock->shouldReceive('select')
            ->once()
            ->andReturn($resultSet);
    
        $service = new CompanyService(
            $this->tableMock,
            $this->tableMock,
            $directoryMock
        );
    
        $this->assertFalse($service->isCompanyNumberTaken(1));
    }
    
 
}

<?php
namespace DirectorzoneTest\Service\Admin;

use Zend\Db\ResultSet\ResultSet;
use Directorzone\Service\CompanyService;

class CompanyServiceTest extends \PHPUnit_Framework_TestCase
{
    private $tableMock;
    
    private $appointmentsMock;
    
    public function setup()
    {
        $this->tableMock = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $this->appointmentsMock = \Mockery::mock('NetsensiaCompanies\Request\CompanyAppointmentsRequest');
        
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
            $directoryMock,
            $this->tableMock,
            $this->tableMock,
            $this->appointmentsMock
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
            $directoryMock,
            $this->tableMock,
            $this->tableMock,
            $this->appointmentsMock
        );
    
        $this->assertFalse($service->isCompanyNumberTaken(1));
    }
}

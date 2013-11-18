<?php
namespace DirectorzoneTest\Service\Admin;

use Netsensia\Test\NetsensiaTest;
use Directorzone\Service\Admin\CompanyUploadService;

class CompanyUploadServiceTest extends NetsensiaTest
{
    private $service;
    
    public function setup()
    {
        $this->service = new CompanyUploadService(
            $this->getAdapterMock()
        );
        
        parent::setup();
    }
    
    public function testRejectsNonCsvFile()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->ingest('hello.xls');
    }
}

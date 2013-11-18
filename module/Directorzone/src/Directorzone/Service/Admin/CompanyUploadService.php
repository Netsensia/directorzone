<?php
namespace Directorzone\Service\Admin;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CompanyUploadService extends NetsensiaService
{
    private $dbAdapter;
    
    private $companyUploadTableGateway;
    
    public function __construct(
        Adapter $adapter
    ) {
        $this->dbAdapter = $adapter;
        
        $this->companyUploadTableGateway = new TableGateway(
            'companyupload',
            $this->dbAdapter
        );
    }

    public function ingest($filename)
    {
        $companies = $this->parseCompaniesUploadCsv($filename);

        if (count($companies) == 0) {
            throw new \InvalidArgumentException(
                'No new companies found to upload'
            );
        }
        
        $this->addCompaniesToUploadTable($companies);
    }
    
    private function parseCompaniesUploadCsv(
        $filename
    ) {
        $file = new \SplFileInfo($filename);
        
        if ($file->getExtension() != 'csv') {
            throw new \InvalidArgumentException(
                'File type must be CSV'
            );
        }
        
        $fileHandle = $file->openFile();
        
        $lineNumber = 0;
        
        $companies = [];
        
        while (!$fileHandle->eof()) {
            $lineNumber ++;
        
            $line = $fileHandle->fgets();
        
            if (trim($line) != '') {
        
                if (strlen($line) > 500) {
                    throw new \InvalidArgumentException(
                        'CSV row too long on line ' . $lineNumber
                    );
                }
        
                $array = str_getcsv($array);
        
                if (count($array) < 2) {
                    throw new \InvalidArgumentException(
                        'CSV file expects at least two ' .
                        'elements on line ' . $lineNumber
                    );
                }
        
                $companyNumber = $array[0];
                $companyName = $array[1];
        
                $resultSet = $this->companyUploadTableGateway->select(
                    function (Select $select) {
                        $select->where->equalTo('companynumber', $companyNumber);
                        $select->where->OR->equalTo('name', $companyName);
                    }
                );
        
                if ($resultSet->count() == 0) {
                    $companies[] = [
                        'name' => $companyName,
                        'number' => $companyNumber
                    ];
                }
            }
        }
        
        return $companies;    
    }
    
    private function addCompaniesToUploadTable(
	   array $companies
    ) {

        foreach ($companies as $company) {
            $this->companyUploadTableGateway->insert(
                [
                    'companynumber' => $company['number'],
                    'name' => $company['name']
                ]
            );
        }
    }
}
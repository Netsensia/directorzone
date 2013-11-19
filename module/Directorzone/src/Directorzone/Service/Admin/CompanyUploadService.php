<?php
namespace Directorzone\Service\Admin;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CompanyUploadService extends NetsensiaService
{

    private $companyUploadTableGateway;
    
    public function __construct(
        TableGateway $companyUploadTableGateway
    ) {
        $this->companyUploadTableGateway = $companyUploadTableGateway;
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
        
        return $companies;
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
        
        ini_set("auto_detect_line_endings", true);
        
        $fileHandle = $file->openFile();
        
        $lineNumber = 0;
        
        $companies = [];

        while (!$fileHandle->eof()) {
            $lineNumber ++;
        
            $array = $fileHandle->fgetcsv();
            
            if (count($array) < 2) {
                throw new \InvalidArgumentException(
                    'CSV file expects at least two ' .
                    'elements on line ' . $lineNumber
                );
            }
    
            $companyName = iconv("UTF-8", "UTF-8//IGNORE", $array[0]);
            $companyNumber = iconv("UTF-8", "UTF-8//IGNORE", $array[1]);
            
            if (trim($companyName) != '') {
                
                $resultSet = $this->companyUploadTableGateway->select(
                    function (Select $select) use ($companyName, $companyNumber) {
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
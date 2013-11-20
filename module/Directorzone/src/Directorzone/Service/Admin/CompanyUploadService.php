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
        ini_set("auto_detect_line_endings", true);
        
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
        
            $array = $fileHandle->fgetcsv();
            
            if (count($array) >= 2) {
                $companyName = $this->sanitize($array[0]);
                $companyNumber = $this->sanitize($array[1]);
                
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
        }
        
        //fclose($fileHandle);

        return $companies;    
    }
    
    private function addCompaniesToUploadTable(
	   array $companies
    ) {

        foreach ($companies as $company) {
            
            $this->companyUploadTableGateway->insert(
                [
                    'companynumber' => $company['number'],
                    'name' => $company['name'],
                    'recordstatus' => 'P'
                ]
            );
        }
    }
    
    private function sanitize($str)
    {
        $str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $str = iconv("UTF-8", "UTF-8//IGNORE",$str);
        
        return $str;
    }
}
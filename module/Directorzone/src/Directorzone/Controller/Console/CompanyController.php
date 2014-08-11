<?php
namespace Directorzone\Controller\Console;

use Netsensia\Controller\NetsensiaActionController;
use Netsensia\Library\Csv\Csv;
use Netsensia\Library\Datetime\Datetime;

class CompanyController extends NetsensiaActionController
{
    public function companyAction()
    {
        $companyNumber = $this->params('companyNumber');
        
        $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\CompanyDetailsRequest');
        $companyModel = $request->loadCompanyDetails($companyNumber);

        $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\CompanyAppointmentsRequest');
        $companyAppointmentsModel = $request->loadCompanyAppointments(
            $companyNumber,
            $companyModel->getCompanyName(),
            true,
            true
        );
        
        return [
            'company' => $companyModel,
            'appointments' => $companyAppointmentsModel,
        ];
                
    }

    public function ingestFromCsvAction()
    {
        $companyService = $this->getServiceLocator()->get('CompanyService');
        
        $dir = new \DirectoryIterator('/var/www/chdata');
        
        $count = 0;
        
        $request =
            $this->getServiceLocator()
                ->get('NetsensiaCompanies\Request\CompanyDetailsRequest');
        
        foreach ($dir as $file) {
            if ($file->isFile()) {
                
                $file = new \SplFileInfo($file->getPathname());
                 
                $fileHandle = $file->openFile();
                
                $headers = $fileHandle->fgetcsv();
                
                $rows = [];
                
                $rowCount = 0;
                
                while (!$fileHandle->eof()) {
                    
                    $fields = [];
                    $fieldNumber = 0;
                
                    $array = $fileHandle->fgetcsv();
                                    
                    if (count($array) > 5) {
                        foreach ($array as $dataItem) {
                            $fieldName = trim($headers[$fieldNumber++]);
                            $fields[$fieldName] = $dataItem;
                        }
    
                        $data = [];
                        
                        $data['name'] = $fields['CompanyName'];
                        $data['addressline1'] = $fields['RegAddress.AddressLine1'];
                        $data['addressline2'] = $fields['RegAddress.AddressLine2'];
                        $data['town'] = $fields['RegAddress.PostTown'];
                        $data['county'] = $fields['RegAddress.County'];
                        $data['country'] = $fields['RegAddress.Country'];
                        $data['postcode'] = $fields['RegAddress.PostCode'];
                        $data['number'] = $fields['CompanyNumber'];
                        
                        try {
                            $incorporationDate =
                                Datetime::ukDateToGenericDate($fields['IncorporationDate']);
                        } catch (\InvalidArgumentException $e) {
                            $incorporateDate = null;
                        }
                        
                        $data['incorporationdate'] = $incorporationDate;
                        
                        $data['category'] = $fields['CompanyCategory'];
                        $data['detailstatus'] = $fields['CompanyStatus'];
                                                
                        for ($i=1; $i<=4; $i++) {
                            $sicCode = $fields['SICCode.SicText_' . $i];
                            if (trim($sicCode) != '') {
                                $data['siccodes'][] = $sicCode;
                            }
                            $data['siccode' . $i] = $fields['SICCode.SicText_' . $i];
                        }
                        
                        $companyService->addToCompaniesHouseDirectory($data);
                        
                        if ($rowCount++ % 10000 == 0) {
                            echo '.';
                        }
                    }
                }
            }
        }
    }
    
    public function ingestCompanyDetailsAction()
    {
        $companyService = $this->getServiceLocator()->get('CompanyService');
        
        $lastCompanyId = '0';
        
        while (true) {
            
            try {
                $lastCompanyId = file_get_contents('lastcompanyid.txt');
                
                $rowset = $companyService->getCompaniesHouseList($lastCompanyId, 10);
                
                foreach ($rowset as $row) {
                    $request =
                        $this->getServiceLocator()
                             ->get('NetsensiaCompanies\Request\CompanyDetailsRequest');
                    
                    $companyModel = $request->loadCompanyDetails($row['number']);
                                
                    $addressLines = $companyModel->getAddressLines();
                    
                    for ($i=0; $i<count($addressLines) && $i<5; $i++) {
                        $data['addressline' . ($i+1)] = $addressLines[$i];
                    }
                    
                    $data['incorporationdate'] = $companyModel->getIncorporationDate();
                    $data['category'] = $companyModel->getCategory();
                    $data['country'] = $companyModel->getCountry();
                    $data['detailstatus'] = $companyModel->getStatus();
                    
                    $data['siccodes'] = $companyModel->getSicCodes();
                    $data['number'] = $row['number'];
                    
                    $companyService->updateCompaniesHouseDirectory($data);
                    
                    echo '.';
                }
            } catch (\Exception $e) {
                file_put_contents(
                    'exceptions.txt',
                    time() . ' ' . $lastCompanyId . ' ' . $e->getMessage() . PHP_EOL,
                    FILE_APPEND
                );
                echo 'x';
            }
                
            file_put_contents('lastcompanyid.txt', $row['companyid']);
        }
    }
    
    public function ingestOfficersAction()
    { 
    }
    
    public function ingestAction()
    {
        $previousNames = [];
        
        while (true) {
            try {
                $partialName = file_get_contents('lastname.txt');
                
                $partialName = preg_replace("/[^\.\-&\/A-Za-z0-9 ]/", '', $partialName);
                                
                $companyService = $this->getServiceLocator()->get('CompanyService');
                
                $done = false;
                
                while (!$done) {
                    $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\NameSearchRequest');
                    
                    $pagesize = 500;
                    $pagecount = 25;
                    echo $partialName . ' ' . $pagesize . ' ' . $pagecount . PHP_EOL;

                    $nameSearchResults = $request->loadResults(
                        $partialName,
                        $pagesize,
                        $pagecount
                    );

                    foreach ($nameSearchResults->getMatches() as $match) {
                        
                        if (!$companyService->isCompanyNumberTaken($match['number'])) {
                            $companyService->addToCompaniesHouseDirectory($match);
                        }
                        $partialName = $match['name'];
                        
                    }
                    exec('cp lastname.txt lastgoodname.txt');
                    file_put_contents('lastname.txt', $partialName);
                }
            } catch (\Exception $e) {
                echo PHP_EOL . "Exception: " . $e->getMessage() . PHP_EOL . PHP_EOL;

                exec('cp lastgoodname.txt lastname.txt');
                
                if ($partialName == null) {
                    echo "I give up." . PHP_EOL;
                    die;
                }

            }
        }
        
        echo 'Done.' . PHP_EOL;
    }
    
    public function indexCompanyOfficersAction()
    {
        $elasticService = $this->getServiceLocator()->get('ElasticService');
        $elasticService->indexCompanyOfficers();
    }
    
    public function indexCompanyDirectoryAction()
    {
        $elasticService = $this->getServiceLocator()->get('ElasticService');
        $elasticService->indexCompanyDirectory();
    }
    
    public function indexCompaniesAction()
    {
        $elasticService = $this->getServiceLocator()->get('ElasticService');
        $elasticService->indexCompanies();
    }
    
    public function indexArticlesAction()
    {
        $elasticService = $this->getServiceLocator()->get('ElasticService');
        $elasticService->indexArticles();
    }
}

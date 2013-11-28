<?php
namespace Directorzone\Controller\Console;

use Netsensia\Controller\NetsensiaActionController;

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
    
    public function ingestCompanyDetailsAction()
    {
        $companyService = $this->getServiceLocator()->get('CompanyService');
        
        $lastCompanyId = '0';
        
        while (true) {
            
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
                
                file_put_contents('lastcompanyid.txt', $row['companyid']);
                
                echo '.';
            }
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
                    
                    $pagesize = 500; // rand(10, 500);
                    $pagecount = 25; // rand(0, 10);
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
    
    public function searchIndexAction()
    {
        $elasticService = $this->getServiceLocator()->get('ElasticService');
        $elasticService->indexCompanies();
    }
}

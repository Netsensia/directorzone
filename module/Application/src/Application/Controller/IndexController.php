<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {

        return [
            'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
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
    
    public function ingestAction()
    {
        $previousNames = [];
        
        while (true) {
            try {
                $partialName = file_get_contents('lastname.txt');
                
                $partialName = preg_replace("/[^A-Za-z0-9 ]/", '', $partialName);
                
                $companyService = $this->getServiceLocator()->get('CompanyService');
                
                $done = false;
                
                while (!$done) {
                    $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\NameSearchRequest');
                    
                    $pagesize = rand(10, 500);
                    $pagecount = rand(0, 10);
                    echo $partialName . ' ' . $pagesize . ' ' . $pagecount . PHP_EOL;

                    $nameSearchResults = $request->loadResults(
                        $partialName,
                        $pagesize,
                        $pagecount
                    );

                    foreach ($nameSearchResults->getMatches() as $match) {
                        if (!$companyService->isCompanyNumberTaken($match['number'])) {
                            $companyModel = $this->newModel('Company');
                            $companyModel->setData($match);
                            $companyModel->create();
                        }
                        $partialName = $match['name'];
                    }
                    file_put_contents('lastname.txt', $partialName);
                    
                    //sleep(5);
                }
            } catch (\Exception $e) {
                echo PHP_EOL . "Exception: " . $e->getMessage() . PHP_EOL . PHP_EOL;

                if ($partialName == null) {
                    echo "I give up." . PHP_EOL;
                    die;
                }
                
                sleep(5);
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

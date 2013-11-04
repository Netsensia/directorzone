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
    
    public function companySearchAction()
    {
        $partialName = $this->params('partialName');
    
        $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\NameSearchRequest');
        $nameSearchResults = $request->loadResults(
            $partialName,
            10
        );
        
        $companyService = $this->getServiceLocator()->get('CompanyService');
        
        foreach ($nameSearchResults->getMatches() as $match) {
            if (!$companyService->isCompanyNumberTaken($match['number'])) {
                $companyModel = $this->newModel('Company');
                var_dump($match);
                $companyModel->setData($match);
                $companyModel->create();
            }
        }
    
        return [
            'results' => $nameSearchResults->getMatches(),
        ];
    }
}

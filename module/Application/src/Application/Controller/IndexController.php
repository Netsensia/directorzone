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
        
        $c = $this->getServiceLocator()->get('NetsensiaCompanies\Loader\CompanyDetailsLoader');
        
        $companyModel = $c->loadCompanyDetails($companyNumber);
        
        return [
            'company' => $companyModel
        ];
                
    }
}

<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;
use NetsensiaCompanies\Search\Companies;

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
        
        $c = $this->getServiceLocator()->get('NetsensiaCompanies\Search\CompanyDetails');
        
        $xml = $c->getCompanyDetails($companyNumber);
        
        return [
            'xml' => $xml
        ];
                
    }
}

<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;
use NetsensiaCompanies\Search\Companies;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {
        $c = $this->getServiceLocator()->get('NetsensiaCompanies\Search\Companies');
        
        echo ($c->getCompanyDetails('06236637'));
        
        return [ 
            'flashMessages' => $this->getFlashMessages(),
        ];
    }
}

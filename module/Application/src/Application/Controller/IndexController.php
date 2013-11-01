<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;
use NetsensiaCompanies\Search\Companies;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {
        $c = $this->getServiceLocator()->get('NetsensiaCompanies\Search\Companies');
        
        echo($c->test());
        die;
        
       return [
            'flashMessages' => $this->getFlashMessages(),
       ];
    }
}

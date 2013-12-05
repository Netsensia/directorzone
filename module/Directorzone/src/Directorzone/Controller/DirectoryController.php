<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;

class DirectoryController extends NetsensiaActionController
{
    public function indexAction()
    {
        $this->redirect()->toRoute('directories/company-directory');
    }
    
    public function companyAction()
    {
        
    }
    
    public function peopleAction()
    {
        
    }
}

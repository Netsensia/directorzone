<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;

class AjaxController extends NetsensiaActionController
{
    
	public function onDispatch(MvcEvent $e) 
	{
		parent::onDispatch($e);
	}

    public function companySearchAction()
    {
    }

}

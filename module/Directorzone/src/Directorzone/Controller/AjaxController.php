<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class AjaxController extends NetsensiaActionController
{
    
	public function onDispatch(MvcEvent $e) 
	{
		parent::onDispatch($e);
	}

    public function companySearchAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size;
        
        $companies = [
            'results' => [],
            'total' => 100,	
        ];
        
        for ($i=$start; $i<=$end; $i++) {
            $companies['results'][] = [
	           'number' => $i,
	           'name' => 'Company number ' . $i,
	           'ceo' => 'Barry Jones',
	           'sector' => 'Electricals'
            ];
        }
        
        return new JsonModel(
	        $companies
        );
    }

}

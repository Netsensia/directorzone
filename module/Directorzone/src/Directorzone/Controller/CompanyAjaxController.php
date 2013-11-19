<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\CompanyService;

class CompanyAjaxController extends NetsensiaActionController
{
    /**
     * @var CompanyService $companyService
     */
    private $companyService;
    
    public function __construct(
	    CompanyService $companyService
    ) {
        $this->companyService = $companyService;
    }
    
	public function onDispatch(MvcEvent $e) 
	{
		parent::onDispatch($e);
	}

    public function companySearchAction()
    {        
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
                
        $results = $this->companyService->getPendingCompanies(
            $start,
            $end
        );
        
        $companies = [
            'results' => [],
        ];
        
        foreach ($results as $result) {
            $companies['results'][] = [
                'number' => $result['companynumber'],
                'name' => $result['name'],
                'ceo' => '',
                'sector' => ''
           ];
        }

        return new JsonModel(
	        $companies
        );
    }

}

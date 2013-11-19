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
        $type = $this->params()->fromQuery('type', null);
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
                
        $this->getServiceLocator()->get('Zend\Log')->info($type);
        $results = $this->companyService->getCompanies(
            $type,
            $start,
            $end
        );
        
        $companies = [
            'results' => [],
        ];
        
        foreach ($results as $result) {
            if (isset($result['companynumber'])) {
                $companyNumber = $result['companynumber'];
            } else
            if (isset($result['reference'])) {
                $companyNumber = $result['reference'];
            } else
            if (isset($result['number'])) {
                $companyNumber = $result['number'];
            }
            
            $companies['results'][] = [
                'number' => $companyNumber,
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

<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\CompanyService;
use Directorzone\Service\ElasticService;

class CompanyController extends NetsensiaActionController
{
    /**
     * @var CompanyService $companyService
     */
    private $companyService;
    
    /**
     * @var ElasticService $elasticService
     */
    private $elasticService;
    
    public function __construct(
        CompanyService $companyService,
        ElasticService $elasticService
    ) {
        $this->companyService = $companyService;
        $this->elasticService = $elasticService;
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
                
        $results = $this->companyService->getCompanies(
            $type,
            $start,
            $end
        );
        
        
        $companies = [
            'results' => [],
        ];
        
        foreach ($results as $result) {
            
            $name = $result['name'];
                        
            if (isset($result['companynumber'])) {
                $companyNumber = $result['companynumber'];
            } elseif (isset($result['reference'])) {
                $companyNumber = $result['reference'];
            } elseif (isset($result['number'])) {
                $companyNumber = $result['number'];
            }
            
            $companies['results'][] = [
                'number' => $companyNumber,
                'name' => $name,
                'ceo' => '',
                'sector' => ''
            ];
        }

        return new JsonModel(
            $companies
        );
    }
}

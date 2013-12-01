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
        $name = $this->params()->fromQuery('name', null);
        
        $result = $this->elasticService->search($name);
        
        return new JsonModel(
            $result
        );
    }
    
    public function updateUploadStatusAction()
    {
        $uploadId = $this->params()->fromQuery('uploadid', null);
        $number = $this->params()->fromQuery('number', null);
        $name = $this->params()->fromQuery('name', null);
        $status = $this->params()->fromQuery('recordstatus', null);
                
        $result = $this->companyService->updateUploadStatus(
            $uploadId,
            $number,
            $name,
            $status
        );
        
        return new JsonModel(
            [$result]
        );
    }

    public function companyListAction()
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
            
            if (isset($result['companyuploadid'])) {
                $internalId = $result['companyuploadid'];
            } else {
                $internalId = '';
            }
            
            $companies['results'][] = [
                'internalId' => $internalId,
                'number' => $companyNumber,
                'name' => $name,
                'details' => '',
            ];
        }

        return new JsonModel(
            $companies
        );
    }
}

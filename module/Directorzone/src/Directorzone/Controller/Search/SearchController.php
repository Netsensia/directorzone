<?php

namespace Directorzone\Controller\Search;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\ElasticService;

class SearchController extends NetsensiaActionController
{

    /**
     * @var ElasticService $elasticService
     */
    private $elasticService;
    
    public function __construct(
        ElasticService $elasticService
    ) {
        $this->elasticService = $elasticService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function searchAction()
    {
        $name = $this->params()->fromQuery('name', null);
        
        $result = $this->elasticService->searchCompanies($name);
        
        return new JsonModel(
            $result
        );
    }
}

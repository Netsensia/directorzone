<?php

namespace Directorzone\Controller\Ajax;

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
    )
    {
        $this->elasticService = $elasticService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function searchAction()
    {
        $name = $this->params()->fromQuery('keywords', null);
        
        //$result = $this->elasticService->searchCompanies($name);
        
        $result = ['results' => []];
        for ($i=0; $i<20; $i++) {
            $result['results'][] = [
               'url' => 'http://www.google.com',
	           'title' => 'Hello',
	           'description' => 'Goodbye',
	           'type' => 'Company',
            ];
        }
        
        return new JsonModel(
            $result
        );
    }
}

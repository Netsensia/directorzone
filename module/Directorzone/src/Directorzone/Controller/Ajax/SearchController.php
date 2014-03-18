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
        $keywords = $this->params()->fromQuery('keywords', null);
        
        $result = $this->elasticService->searchSite($keywords);
        
        $hits = $result['hits'];
        $return = ['results' => []];
        foreach ($hits['hits'] as $hit) {
            
            $source = $hit['_source'];
            $type = $hit['_type'];
            if (isset($source['title'])) {
                $title = $source['title'];
            } elseif (isset($source['name'])) {
                $title = $source['name'];
            } elseif (isset($source['surname'])) {
                $title = trim($source['forename'] . ' ' . $source['surname']);
            } else {
                $title = '';
            }
            
            switch ($type) {
            	case 'company' :
            	    $internalId = $source['companydirectoryid'];
            	    $url = '/directories/company/' . $internalId;
            	    break;
            	case 'article' :
            	    $internalId = $source['articleid'];
            	    $url = '/article/' . $internalId;
            	    break;
        	    case 'officer' :
        	        $internalId = $source['officerid'];
        	        $url = '/directories/people/' . $internalId;
        	        break;            
            }
            
            $return['results'][] = [
                'url' => $url,
                'type' => $type,
                'title' => $title,
                'description' => '',
                'type' => '',
            ];
        }
        
        return new JsonModel(
            $return
        );
    }
}

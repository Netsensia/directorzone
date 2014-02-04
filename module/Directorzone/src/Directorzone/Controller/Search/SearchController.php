<?php

namespace Directorzone\Controller\Search;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\ElasticService;

class SearchController extends NetsensiaActionController
{
    
    public function __construct() 
    {
    	
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function searchAction()
    {
        $keywords = $this->params()->fromQuery('keywords', null);
        
        return [ 'keywords' => $keywords ];
    }
}

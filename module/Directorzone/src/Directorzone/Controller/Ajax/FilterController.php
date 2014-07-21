<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\PeopleService;
use Directorzone\Service\FilterService;

class FilterController extends NetsensiaActionController
{

    private $filterService;
    
    public function __construct(
        FilterService $filterService
    )
    {
        $this->filterService = $filterService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function searchAction()
    {
        $filterType = $this->params()->fromRoute('type', null);
        $searchText = $this->params()->fromRoute('searchtext', null);
        
        $results = $this->filterService->search(
            $filterType,
            $searchText
        );
        
        return new JsonModel(
            $results
        );
    }
}

<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\PeopleService;

class PeopleController extends NetsensiaActionController
{
    /**
     * @var PeopleService $peopleService
     */
    private $peopleService;
    
    public function __construct(
        PeopleService $peopleService
    ) {
        $this->peopleService = $peopleService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function peopleListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
                
        $results = $this->peopleService->getDirectoryPeople(
            $start,
            $end,
            $order
        );
                
        return new JsonModel(
            $results
        );
    }
}

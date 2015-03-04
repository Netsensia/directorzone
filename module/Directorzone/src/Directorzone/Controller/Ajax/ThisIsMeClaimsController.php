<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\CompanyOwnersService;
use Directorzone\Service\PeopleThisIsMeService;

class ThisIsMeClaimsController extends NetsensiaActionController
{
    /**
     * @var PeopleThisIsMeService 
     */
    private $thisIsMeService;
    
    public function __construct(
        PeopleThisIsMeService $thisIsMeService
    )
    {
        $this->thisIsMeService = $thisIsMeService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function switchAction()
    {
        $requestId = $this->params('requestid');
        
        $status = $this->thisIsMeService->switchGrantStatus($requestId);        
        
        return new JsonModel(
            [
                'requestid' => $requestId,
                'status' => $status,
            ]
        );
    }
    
    public function thisIsMeClaimsListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->thisIsMeService->getThisIsMeClaims(
            $start,
            $end,
            $order
        );
                
        return new JsonModel(
            $results
        );
    }
    

}

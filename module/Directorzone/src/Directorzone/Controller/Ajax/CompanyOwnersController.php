<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\CompanyOwnersService;

class CompanyOwnersController extends NetsensiaActionController
{
    /**
     * @var CompanyOwnersService $companyOwnersService
     */
    private $companyOwnersService;
    
    public function __construct(
        CompanyOwnersService $companyOwnersService
    )
    {
        $this->companyOwnersService = $companyOwnersService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function switchAction()
    {
        $requestId = $this->params('requestid');
        
        $status = $this->companyOwnersService->switchGrantStatus($requestId);        
        
        return new JsonModel(
            [
                'requestid' => $requestId,
                'status' => $status,
            ]
        );
    }
    
    public function companyOwnersListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->companyOwnersService->getCompanyOwners(
            $start,
            $end,
            $order
        );
                
        return new JsonModel(
            $results
        );
    }
    

}

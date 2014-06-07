<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\TalentPoolService;

class TalentPoolController extends NetsensiaActionController
{
    /**
     * @var TalentPoolService $talentPoolService
     */
    private $talentPoolService;
    
    public function __construct(
        TalentPoolService $talentPoolService
    ) {
        $this->talentPoolService = $talentPoolService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function talentPoolListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->talentPoolService->getTalentPoolList(
            $start,
            $end,
            $order
        );
                
        return new JsonModel(
            $results
        );
    }
}

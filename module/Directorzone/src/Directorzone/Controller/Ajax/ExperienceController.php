<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Directorzone\Service\ExperienceService;
use Zend\View\Model\JsonModel;

class ExperienceController extends NetsensiaActionController
{
    private $experienceService;
    
    public function __construct(
        ExperienceService $experienceService
    )
    {
        $this->experienceService = $experienceService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function setHistoryAction()
    {
        $body = $this->getRequest()->getContent();
        $userId = $this->getUserId();
        
        $companies = json_decode($body, true);
        
        $this->experienceService->setHistory($userId, $companies);

        return new JsonModel([]);
    }
    
}

<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\MessagingService;

class MessagingController extends NetsensiaActionController
{
    /**
     * @var MessagingService $messagingService
     */
    private $messagingService;
    
    public function __construct(
        MessagingService $messagingService
    ) {
        $this->messagingService = $messagingService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function sendMessageAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $type = $this->params()->fromRoute('type', null);
        $content = $this->params()->fromPost('content', null);

        $result = $this->messagingService->sendMessage(
            $id,
            $type,
            $content
        );
        
        return new JsonModel(
            $result
        );
    }
}

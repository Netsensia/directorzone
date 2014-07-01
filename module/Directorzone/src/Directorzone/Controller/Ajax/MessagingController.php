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
        $title = $this->params()->fromPost('title', null);
        
        $result = $this->messagingService->sendMessage(
            $id,
            $type,
            $title,
            $content
        );
        
        return new JsonModel(
            $result
        );
    }
    
    public function inboxAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->messagingService->getInboxList(
            $start,
            $end,
            $order
        );
        
        return new JsonModel(
            $results
        );
    }

}

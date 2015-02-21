<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Netsensia\Service\MessagingService;

class MessagingController extends NetsensiaActionController
{
    /**
     * @var MessagingService $messagingService
     */
    private $messagingService;
    
    public function __construct(
        MessagingService $messagingService
    )
    {
        $this->messagingService = $messagingService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function archiveMessageAction()
    {
        $messageId = $this->params()->fromRoute('id', null);
        $result = $this->messagingService->archiveMessage($messageId);
    
        return new JsonModel(
            $result
        );
    }
    
    public function unarchiveMessageAction()
    {
        $messageId = $this->params()->fromRoute('id', null);
        $result = $this->messagingService->archiveMessage($messageId, true);
    
        return new JsonModel(
            $result
        );
    }
    
    public function deleteMessageAction()
    {
        $messageId = $this->params()->fromRoute('id', null);
        $result = $this->messagingService->deleteMessage($messageId);    
        
        return new JsonModel(
            $result
        );
    }
    
    public function sendMessageAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $type = $this->params()->fromRoute('type', null);
        $content = $this->params()->fromPost('content', null);
        $title = $this->params()->fromPost('title', null);
        $receiverName = $this->params()->fromPost('receiverName', null);
        
        $result = $this->messagingService->sendMessage(
            $id,
            $type,
            $title,
            $content,
            $receiverName
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
        $isArchive = $this->params()->fromQuery('isArchive', 'N') == 'Y';
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->messagingService->getInboxList(
            $start,
            $end,
            $order,
            $isArchive
        );
        
        return new JsonModel(
            $results
        );
    }

}

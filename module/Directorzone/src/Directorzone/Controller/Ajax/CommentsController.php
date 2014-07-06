<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Netsensia\Service\CommentsService;

class CommentsController extends NetsensiaActionController
{
    /**
     * @var CommentsService $commentsService
     */
    private $commentsService;
    
    public function __construct(
        CommentsService $CommentsService
    )
    {
        $this->commentsService = $CommentsService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function addCommentAction()
    {
        $articleId = $this->params()->fromRoute('id', null);
        $content = $this->params()->fromPost('content', null);
        
        $result = $this->commentsService->addComment(
            $this->getUserId(),
            $articleId,
            $content
        );
        
        return new JsonModel(
            $result
        );
    }
}

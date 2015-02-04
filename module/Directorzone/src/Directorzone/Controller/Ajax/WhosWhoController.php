<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class WhosWhoController extends NetsensiaActionController
{
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    public function whosWhoListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;

        $results = $this->getServiceLocator()->get('WhosWhoService')->getWhosWhoList(
            $start,
            $end,
            $order
        );
                
        return new JsonModel(
            $results
        );
    }
}

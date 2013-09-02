<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {
       return [
            'flashMessages' => $this->getFlashMessages(),
       ];
    }
}

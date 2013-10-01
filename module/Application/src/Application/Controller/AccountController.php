<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class AccountController extends NetsensiaActionController
{
    public function indexAction()
    {
       return [
            'flashMessages' => $this->getFlashMessages(),
       ];
    }
}

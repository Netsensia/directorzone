<?php

namespace Directorzone\Controller\Directory;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PeopleDirectoryController extends NetsensiaActionController
{
    /**
     * @var PeopleService
     */
    private $peopleService;
    
    public function __construct(
        PeopleService $peopleService
    ) {
        $this->peopleService = $peopleService;
    }
      
    public function indexAction()
    {
        $this->redirect()->toRoute('directories/people-directory');
    }
    
    public function peopleListAction()
    {
        
    }
}

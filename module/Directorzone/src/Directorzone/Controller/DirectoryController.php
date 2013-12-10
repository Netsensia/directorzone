<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DirectoryController extends NetsensiaActionController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    
    /**
     * @var PeopleService
     */
    private $peopleService;
    
    public function __construct(
        CompanyService $companyService,
        PeopleService $peopleService
    ) {
        $this->companyService = $companyService;
        $this->peopleService = $peopleService;
    }
      
    public function indexAction()
    {
        $this->redirect()->toRoute('directories/company-directory');
    }
    
    public function companyDetailsAction()
    {
        $companyDirectoryId = $this->params('id');
                
        try {
            
            $companyDetails = $this->companyService->getCompanyDetails(
                $companyDirectoryId
            );
            
            return $companyDetails;
            
        } catch (NotFoundResourceException $e) {
            
            $this->getResponse()->setStatusCode(404);
            
        }
    }
    
    public function companyListAction()
    {
        
    }
    
    public function peopleListAction()
    {
        
    }
}

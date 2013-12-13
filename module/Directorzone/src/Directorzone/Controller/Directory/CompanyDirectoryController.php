<?php

namespace Directorzone\Controller\Directory;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CompanyDirectoryController extends NetsensiaActionController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    
    public function __construct(
        CompanyService $companyService
    ) {
        $this->companyService = $companyService;
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
    
    public function companyEditAction()
    {
        $companyDirectoryId = $this->params()->fromRoute('id');
    
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

}

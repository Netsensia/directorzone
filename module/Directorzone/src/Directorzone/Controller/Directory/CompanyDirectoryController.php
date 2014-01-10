<?php

namespace Directorzone\Controller\Directory;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
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
    
    public function genericForm($formName, $modelName)
    {
        $companyDetails = $this->companyService->getCompanyDetails(
            $this->params('id')
        );
        
        return array(
            "companyDetails" => $companyDetails,
            "form" => $this->processForm(
                $formName,
                $modelName,
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );        
    }
    
    public function contactAction()
    {
        return $this->genericForm('CompanyContactForm', 'CompanyDirectory');
    }
    
    public function overviewAction()
    {
        return $this->genericForm('CompanyOverviewForm', 'CompanyDirectory');
    }
    
    public function feedsAction()
    {
        return $this->genericForm('CompanyFeedsForm', 'CompanyDirectory');
    }
    
    public function financialsAction()
    {
        return $this->genericForm('CompanyFinancialsForm', 'CompanyDirectory');
    }
    
    public function officersAction()
    {
        return $this->genericForm('CompanyOfficersForm', 'CompanyDirectory');
    }
    
    public function ownersAction()
    {
        return $this->genericForm('CompanyOwnersForm', 'CompanyDirectory');
    }
    
    public function relationshipsAction()
    {
        return $this->genericForm('CompanyRelationshipsForm', 'CompanyDirectory');
    }
    
    public function sectorsAction()
    {
        return $this->genericForm('CompanySectorsForm', 'CompanyDirectory');
    }
    
    public function companyListAction()
    {
        
    }

}

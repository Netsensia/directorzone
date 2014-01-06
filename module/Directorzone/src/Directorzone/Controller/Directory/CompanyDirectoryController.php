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
    
    /**
     * @var string
     */
    private $companyId;
    
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
    
    public function contactAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyContactForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function overviewAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyOverviewForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function feedsAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyFeedsForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function financialsAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyFinancialsForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function officersAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyOfficersForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function ownersAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyOwnersForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function relationshipsAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanyRelationshipsForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function sectorsAction()
    {
        return array(
            "companyId" => $this->companyId,
            "form" => $this->processForm(
                'CompanySectorsForm',
                'Company',
                $this->companyId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function companyListAction()
    {
        
    }

}

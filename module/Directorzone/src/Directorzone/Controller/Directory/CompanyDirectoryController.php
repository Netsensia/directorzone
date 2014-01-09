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
    
    public function contactAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyContactForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function overviewAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyOverviewForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function feedsAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyFeedsForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function financialsAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyFinancialsForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function officersAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyOfficersForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function ownersAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyOwnersForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function relationshipsAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanyRelationshipsForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function sectorsAction()
    {
        return array(
            "companyDirectoryId" => $this->params('id'),
            "form" => $this->processForm(
                'CompanySectorsForm',
                'CompanyDirectory',
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function companyListAction()
    {
        
    }

}

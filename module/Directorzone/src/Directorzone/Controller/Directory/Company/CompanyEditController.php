<?php

namespace Directorzone\Controller\Directory\Company;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\CompanyOwnersService;

class CompanyEditController extends NetsensiaActionController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    
    public function __construct(
        CompanyService $companyService
    )
    {
        $this->companyService = $companyService;
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
    
    public function relationshipsAction()
    {
        return $this->genericForm('CompanyRelationshipsForm', 'CompanyDirectory');
    }
    
    public function sectorsAction()
    {
        return $this->genericForm('CompanySectorsForm', 'CompanyDirectory');
    }
    
    public function newCompanyAction()
    {
        return array(
            "form" => $this->processForm(
                'CompanyNewCompanyForm',
                'CompanyDirectory',
                0
            ),
            'flashMessages' => $this->getFlashMessages(),
        );    
    }
    
    private function genericForm($formName, $modelName)
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
}

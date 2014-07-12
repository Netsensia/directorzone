<?php

namespace Directorzone\Controller\Directory\TalentPool;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;

class TalentPoolEditController extends NetsensiaActionController
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
    
    public function ownersAction()
    {
        if (!$this->isLoggedOn()) {
            $return['ownershipRole'] = false;
        } else {
            
            $hiddenValues['companydirectoryid'] = $this->params('id');
            $hiddenValues['userid'] = $this->getUserId();
            
            $companyDetails = $this->companyService->getCompanyDetails(
                $this->params('id')
            );
            
            $userCompanyId = $this->companyService->getUserCompanyId(
	            $this->getUserId(),
                $this->params('id')
            );
            
            $return = [
                "companyDetails" => $companyDetails,
                "form" => $this->processForm(
                    'CompanyOwnersForm',
                    'UserCompany',
                    $userCompanyId
                ),
                'flashMessages' => $this->getFlashMessages(),
            ];
            
            $return['ownershipRole'] = $this->companyService->getOwnershipRole(
                $this->params('id'),
                $this->getUserId()
            );
        }
        
        return $return;
    }
    
    public function relationshipsAction()
    {
        return $this->genericForm('CompanyRelationshipsForm', 'CompanyDirectory');
    }
    
    public function sectorsAction()
    {
        return $this->genericForm('CompanySectorsForm', 'CompanyDirectory');
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

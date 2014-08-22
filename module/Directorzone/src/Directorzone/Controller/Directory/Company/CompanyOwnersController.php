<?php

namespace Directorzone\Controller\Directory\Company;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyOwnersService;
use Directorzone\Service\CompanyService;

class CompanyOwnersController extends NetsensiaActionController
{
    /**
     * @var CompanyOwnersService
     */
    private $companyOwnersService;
    
    private $companyService;
    
    public function __construct(
        CompanyOwnersService $companyOwnersService,
        CompanyService $companyService
    )
    {
        $this->companyOwnersService = $companyOwnersService;
        $this->companyService = $companyService;
    }
      
    public function ownersAction()
    {
        $return = [
            'hasOwner' => false,
            'companyId' => $this->params('id'),
            'companyDetails' => $this->companyService->getCompanyDetails($this->params('id')),
        ];
    
        if (!$this->isLoggedOn()) {
            $return['ownershipRole'] = false;
        } else {
    
            $hiddenValues['companydirectoryid'] = $this->params('id');
            $hiddenValues['userid'] = $this->getUserId();
    
            $userCompanyId = $this->companyOwnersService->getUserCompanyId(
                $this->getUserId(),
                $this->params('id')
            );
    
            $return['form'] = $this->processForm(
                    'CompanyOwnersForm',
                    'UserCompany',
                    $userCompanyId
                );
           
            $return['flashMessages'] = $this->getFlashMessages();
            
            $return['ownershipRole'] = $this->companyOwnersService->getOwnershipRole(
                $this->params('id'),
                $this->getUserId()
            );
            
        }
        
        return $return;
    }
}

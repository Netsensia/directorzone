<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;
use Directorzone\Service\CompanyService;

class CompanyOwnersForm extends NetsensiaForm
{
    private $userModel;
    private $companyModel;
    private $companyService;
    
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function setUserModel($userModel)
    {
        $this->userModel = $userModel;
    }
    
    public function setCompanyModel($companyModel)
    {
        $this->companyModel = $companyModel;
    }
    
    public function setCompanyService(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-owners-');
        $this->setDefaultIcon('user');
        
        $ownershipRole = $this->companyService->getOwnershipRole(
            $this->companyModel->getId(),
            $this->userModel->getUserId()
        );
        
        if ($ownershipRole == null) {
            $this->addTextArea([
                'name' => 'relationshiptext',
                'label' => 'My relationship to this company',
            ]);
        } else {
            
        }
        
        $this->addHidden('userid', $this->userModel->getUserId());
        $this->addHidden('companydirectoryid', $this->companyModel->getId());
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

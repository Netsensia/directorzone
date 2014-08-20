<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyOwnersForm extends NetsensiaForm
{
    private $userModel;
    private $companyModel;
    
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
    
    public function prepare()
    {
        $this->setFieldPrefix('company-owners-');
        $this->setDefaultIcon('user');
        
        $this->addTextArea([
            'name' => 'relationshiptext',
            'label' => 'My relationship to this company',
        ]);
        
        $this->addHidden('userid', $this->userModel->getUserId());
        $this->addHidden('companydirectoryid', $this->companyModel->getId());
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

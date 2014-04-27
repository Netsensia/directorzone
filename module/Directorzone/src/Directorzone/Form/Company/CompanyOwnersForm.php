<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyOwnersForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-owners-');
        $this->setDefaultIcon('user');
        
        $this->addText('email');
        $this->addText('alternative-email');
        
        $this->addAddress('addressid');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

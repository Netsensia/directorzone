<?php
namespace Directorzone\Form;

use Netsensia\Form\NetsensiaForm;

class AccountCompanyForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-account-');
        $this->setDefaultIcon('user');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

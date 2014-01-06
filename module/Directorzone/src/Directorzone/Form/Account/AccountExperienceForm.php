<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountExperienceForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-experience-');
        $this->setDefaultIcon('user');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

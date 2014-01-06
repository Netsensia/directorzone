<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountContactForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-contact-');
        $this->setDefaultIcon('user');
        
        $this->addText('email');
        $this->addText('alternative-email');
        
        $this->addAddress('addressid');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

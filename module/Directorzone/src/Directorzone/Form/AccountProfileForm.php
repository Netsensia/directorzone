<?php
namespace Directorzone\Form;

use Netsensia\Form\NetsensiaForm;

class AccountProfileForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-profile-');
        $this->setDefaultIcon('user');
        
        $this->addSelect('title');
        
        $this->addText('forenames');
        $this->addText('surname');
        $this->addText('suffix');
        
        $this->addSelect('gender');
        $this->addSelect('nationality');
        
        $this->addText('pseudonym');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountPersonalForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-personal-');
        $this->setDefaultIcon('user');
        
        $this->addSection(['title' => 'Login information', 'description' => '']);
        $this->addText('email');
        
        $this->addPasswordPair();
        
        $this->addSection(['title' => 'Personal Information', 'description' => '']);
        
        $this->addSelectWithInvisibleOther('title');
        
        $this->addText('forenames');
        $this->addText('surname');
        $this->addSelectWithInvisibleOther('suffix');
        
        $this->addText(
            [
                0 => 1,
                'name' => 'pseudonym',
                'label' => 'Pseudonym (will appear as the author on your published articles)'
            ]
        );
        
        $this->addDate(['name'=>'dob', 'label'=>'Date of birth']);
        
        $this->addSelect('gender');
        $this->addSelect('nationality');
                
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

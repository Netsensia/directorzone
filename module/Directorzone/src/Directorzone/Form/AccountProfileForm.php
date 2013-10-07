<?php
namespace Directorzone\Form;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
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
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

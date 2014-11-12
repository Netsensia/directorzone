<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyContactForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-contact-');
        $this->setDefaultIcon('user');
        
        
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

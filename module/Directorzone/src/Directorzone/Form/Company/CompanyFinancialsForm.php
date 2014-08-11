<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyFinancialsForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-contact-');
        $this->setDefaultIcon('user');
        
        $this->addDate('incorporationdate');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

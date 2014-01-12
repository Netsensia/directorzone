<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyOverviewForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-overview-');
        $this->setDefaultIcon('user');
        
        $this->addTextArea('business-description');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}
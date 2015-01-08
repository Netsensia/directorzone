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
        
        $this->addText('telephone');
        $this->addText('fax');
        $this->addText('webaddress');
        
        $this->addText('name');
        
        $this->addText(['name' => 'reference', 'label' => 'Company Number']);
        
        $this->addSection(['title' => 'Registered Address', 'description' => '']);
        $this->addAddress('registeredaddressid');
        
        $this->addSection(['title' => 'Trading Address', 'description' => '']);
        $this->addAddress('tradingaddressid');
                
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

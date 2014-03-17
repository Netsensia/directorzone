<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class NewCompanyForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-overview-');
        $this->setDefaultIcon('user');
        
        $this->addText('name');
        
        $this->addText(['name' => 'reference', 'label' => 'Registration Number']);
        
        $this->addSelect([
            'name' => 'companytype',
            'label' => 'Company Type',
            ]);
        
        $this->addTextArea('business-description');
        
        $this->addHidden('recordstatus', 'L');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

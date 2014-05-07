<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyOwnersForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-owners-');
        $this->setDefaultIcon('user');
        
        $this->addTextArea([
            'name' => 'relationshiptext',
            'title' => 'My relationship to this company',
        ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

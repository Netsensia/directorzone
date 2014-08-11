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
        
        $this->addSelect([
            'name' => 'companytype',
            'label' => 'Company Type',
            ]);
        
        $this->addTextArea('business-description');
        
        $this->addSelectWithInvisibleOther(
            [
                'name' => 'companyranking',
                'label' => 'Company Ranking',
            ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

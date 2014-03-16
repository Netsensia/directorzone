<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyFeedsForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('company-feeds-');
        $this->setDefaultIcon('user');
        
        $this->addText('twitter-user-name');
        $this->addTextArea('twitter-search-terms');
        $this->addTextArea([
            'name' => 'rsssearchterms',
            'label' => 'Web search terms'
        ]);
        
        $this->addHidden(
            'canusefeedcache',
            'N'
        );
                
        $this->addSubmit('Submit');

        parent::prepare();
    }
}

<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountPublishForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-publish-');
        $this->setDefaultIcon('envelope');
        
        $this->addSelect(['name' => 'articlecategory', 'label' => 'Category']);
        
        $this->addText('title');
        $this->addTextArea('content');
        
        $this->addDate('start-date');
        $this->addDate('end-date');
        
        $this->addImage('image');
        
        $this->addAutoDateOnCreate('publishdate');
        
        $this->addSubmit('Publish');
        
        parent::prepare();
    }
}

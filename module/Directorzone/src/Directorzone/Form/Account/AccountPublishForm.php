<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountPublishForm extends NetsensiaForm
{
    private $userId;
    
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function setUserId($userId)
    {
        $this->userId = $userId;    
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-publish-');
        $this->setDefaultIcon('envelope');
        
        $this->addSelect(['name' => 'approvestatus', 'label' => 'Approved Status', 'admin' => true]);

        $this->addSelect(['name' => 'articlecategory', 'label' => 'Category']);
        
        $this->addCheckbox(['name' => 'isanonymous', 'label' => 'Publish anonymously?']);
        
        $this->addText('title');
        $this->addTextArea('content');

        $this->addText('location');
        
        $this->addDate('start-date');
        $this->addDate('end-date');
        
        $this->addHidden('userid', $this->userId);
        
        $this->addImage('image');
        
        $this->addAutoDateOnCreate('publishdate');
        
        $this->addSubmit('Publish');
        
        parent::prepare();
    }
}

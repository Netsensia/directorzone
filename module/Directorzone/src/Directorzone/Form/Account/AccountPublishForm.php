<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountPublishForm extends NetsensiaForm
{
    private $userModel;
    
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function setUserModel($userModel)
    {
        $this->userModel = $userModel;
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-publish-');
        $this->setDefaultIcon('envelope');
        
        if ($this->userModel->isAdmin()) {
            $this->addSelect(['name' => 'approvestatus', 'label' => 'Approved Status']);
        }

        $this->addSelect(['name' => 'articlecategory', 'label' => 'Category']);
        
        $this->addCheckbox(['name' => 'isanonymous', 'label' => 'Publish anonymously?']);
        
        $this->addText('title');
        $this->addTextArea('content');

        $this->addText('location');
        
        $this->addDate('start-date');
        $this->addDate('end-date');
        
        $this->addHidden('userid', $this->userModel->getUserId());
        
        $this->addImage('image');
        
        $this->addAutoDateOnCreate('publishdate');
        
        $this->addMultiTable([
            'callouttext' => 'Please list the sectors in which you are available',
            'groupname' => 'Sectors',
            'jointablemodel' => 'ArticleSector',
            'fields' => [
                [
                    'type' => 'select',
                    'subtype' => 'tiered',
                    'name' => 'sector',
                    'label' => 'Sector',
                ],
            ],
        ]);
        
        $this->addSubmit('Publish');
        
        parent::prepare();
    }
}

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
        
        $this->addMultiTable([
            'groupname' => 'Geography',
            'jointablemodel' => 'ArticleGeography',
            'fields' => [
                [
                    'type' => 'select',
                    'subtype' => 'tiered',
                    'tiers' => 4,
                    'name' => 'geography',
                    'label' => 'Geography',
                ],
            ],
        ]);
        
        $this->addMultiTable([
            'groupname' => 'Key Event',
            'jointablemodel' => 'ArticleKeyEvent',
            'fields' => [
                [
                'type' => 'select',
                'name' => 'keyevent',
                'label' => 'Key Event',
                ],
            ],
        ]);
        
        $this->addMultiTable([
            'groupname' => 'Functional Area',
            'jointablemodel' => 'ArticleJobArea',
            'fields' => [
            [
            'type' => 'select',
            'name' => 'jobarea',
            'label' => 'Functional Area',
            ],
            ],
            ]);
        
        $this->addSubmit('Publish');
        
        parent::prepare();
    }
}

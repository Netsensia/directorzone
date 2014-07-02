<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountDirectoryForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-whoswho-');
        $this->setDefaultIcon('user');
        
        $this->addSelect(['name' => 'whoswhodisplay', 'label' => 'Display']);
        
        $this->addTextArea(
            [
                'name' => 'whoswhosummary',
                'label' => "Who's Who Summary",
            ]
        );

        $this->addTextArea(
            [
                'name' => 'whoswhoexperience',
                'label' => "Experience Summary",
            ]
        );

        $this->addTextArea(
            [
                'name' => 'skills',
                'label' => "Skills Summary",
            ]
        );

        $this->addTextArea(
            [
            'name' => 'speakertopics',
            'label' => "Please add search words, lists or sentences to describe the topics and areas for your media and/or speaker availability.",
            ]
        );

        $this->addSection(['title' => 'Availability', 'description' => '']);
        
        $this->addCheckbox(['name' => 'availableasspokesperson', 'label' => 'Spokesperson', 'icon' => '']);
        $this->addCheckbox(['name' => 'availableasspeaker', 'label' => 'Speaker', 'icon' => '']);
        $this->addCheckbox(['name' => 'availableasexpertwitness', 'label' => 'Expert Witness', 'icon' => '']);
        
        $this->addMultiTable([
            'callouttext' => 'Please list the sectors in which you are available',
            'groupname' => 'Sectors',
            'jointablemodel' => 'UserWhosWhoSector',
            'fields' => [
                [
                'type' => 'select',
                'name' => 'sector',
                'label' => 'Sector',
                ],
            ],
        ]);
        
        $this->addImage(['name' => 'profileimage', 'label' => 'Profile Image']);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

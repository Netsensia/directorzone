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
        
        $this->addSelect(
            [
                'name' => 'availability',
                'label' => 'Media / speaker availability',
            ]
        );
        
        $this->addSelect(['name' => 'whoswhosector', 'label' => 'Sector', 'table' => 'sector']);
        $this->addSelect(['name' => 'availableas', 'label' => 'Available as']);
        $this->addSelect(['name' => 'whoswhodisplay', 'label' => 'Display']);
        
        
        $this->addImage(['name' => 'profileimage', 'label' => 'Profile Image']);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

<?php
namespace Directorzone\Form\Zend\Admin;

use Zend\Form\Form;

class MemberForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('admin-member');
    
        $this->add(array(
            'name' => 'userid',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'forenames',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'surname',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'newpassword',
            'type' => 'Password',
        ));
        $this->add(array(
            'name' => 'confirmnewpassword',
            'type' => 'Password',
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Update',
                'id' => 'submitbutton',
            ),
        ));
        
        $this->prepare();

    }
}

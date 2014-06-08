<?php
namespace Directorzone\Form\Account;

use Netsensia\Form\NetsensiaForm;

class AccountProfileForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-profile-');
        $this->setDefaultIcon('user');

        $this->addTextArea('talent-pool-summary');

        $this->addSelect('profession');
        
        $this->addSelect('jobarea');
        
        $this->addMultiTable([
            'groupname' => 'Target Roles',
            'jointable' => 'useravailableas',
            'jointablekeycolumn' => 'userid',
            'fields' => [
                ['type' => 'select', 'name' => 'jobtype', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'country', 'label' => 'Country'],
                ['type' => 'select', 'name' => 'paylevel', 'label' => 'Pay Level'],
                ['type' => 'select', 'name' => 'sector', 'label' => 'Primary Sector'],
                ['type' => 'select', 'name' => 'sector', 'label' => 'Headline'],
                ['type' => 'select', 'name' => 'sector', 'label' => 'Comment'],
            ],
        ]);
        
        $this->addMultiTable([
               'groupname' => 'Languages',
               'jointable' => 'userlanguage',
               'jointablekeycolumn' => 'userid',
               'fields' => [
                  [
                     'type' => 'select',
                     'name' => 'language',
                     'label' => 'Language',
                  ],
                  [
                     'type' => 'select',
                     'name' => 'languagelevel',
                     'label' => 'Language Level',
                  ]
               ],
        ]);
        
        $this->addMultiTable([
            'groupname' => 'Academic Qualifications',
            'jointable' => 'userqualification',
            'jointablekeycolumn' => 'userid',
            'fields' => [
               [
                 'type' => 'select',
                 'name' => 'qualification',
                 'label' => 'Qualification',
               ],
               [
                 'type' => 'select',
                 'name' => 'subject',
                 'label' => 'Subject',
               ]
            ],
        ]);
        
        $this->addMultiTable([
            'groupname' => 'Professional Qualifications',
            'jointable' => 'userqualification',
            'jointablekeycolumn' => 'userid',
            'fields' => [
            [
                'type' => 'select',
                'name' => 'qualification',
                'label' => 'Qualification',
            ],
            [
                'type' => 'select',
                'name' => 'subject',
                'label' => 'Subject',
            ]
            ],
            ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

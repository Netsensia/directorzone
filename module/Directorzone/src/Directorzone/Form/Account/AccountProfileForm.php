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
            'jointablemodel' => 'UserAvailableAs',
            'jointablekeycolumn' => 'userid',
            'fields' => [
                ['type' => 'select', 'name' => 'jobtype', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'country', 'label' => 'Country'],
                ['type' => 'select', 'name' => 'paylevel', 'label' => 'Pay Level'],
                ['type' => 'select', 'name' => 'sector', 'label' => 'Primary Sector'],
                ['type' => 'text', 'name' => 'sector', 'label' => 'Headline'],
                ['type' => 'textarea', 'name' => 'sector', 'label' => 'Comment'],
            ],
        ]);
        
        $this->addMultiTable([
               'groupname' => 'Languages',
               'jointablemodel' => 'UserLanguage',
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
            'jointablemodel' => 'UserQualification',
            'fields' => [
               [
                 'type' => 'select',
                 'name' => 'qualificationtype',
                 'label' => 'Qualification',
               ],
               [
                 'type' => 'text',
                 'name' => 'subject',
                 'label' => 'Subject',
               ]
            ],
        ]);
        
        $this->addMultiTable([
            'groupname' => 'Professional Qualifications',
            'jointablemodel' => 'UserQualification',
            'fields' => [
            [
                'type' => 'select',
                'name' => 'qualificationtype',
                'label' => 'Qualification',
            ],
            [
                'type' => 'text',
                'name' => 'subject',
                'label' => 'Subject',
            ]
            ],
            ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

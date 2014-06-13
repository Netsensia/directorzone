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
        
        $this->addSection(['title' => 'Target Roles', 'description' => 'It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.']);
        
        $this->addMultiTable([
            'groupname' => 'Target Roles',
            'jointablemodel' => 'UserAvailableAs',
            'jointablekeycolumn' => 'userid',
            'fields' => [
                ['type' => 'select', 'name' => 'jobtype', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'country', 'label' => 'Country'],
                ['type' => 'select', 'name' => 'paylevel', 'label' => 'Pay Level'],
                ['type' => 'select', 'name' => 'sector', 'label' => 'Primary Sector'],
                ['type' => 'textlink', 'name' => 'sector', 'label' => 'Headline'],
                ['type' => 'textarealink', 'name' => 'sector', 'label' => 'Comment'],
            ],
        ]);
        
        $this->addSection(['title' => 'Expertise', 'description' => 'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.']);
        
        $this->addSelect('profession');
        
        $this->addSelect('jobarea');
        
        $this->addMultiTable([
               'callouttext' => 'Please list any languages you know',
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
            'callouttext' => 'Please list your academic qualifications',
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
            'callouttext' => 'Please list your professional qualifications',
            'groupname' => 'Professional Qualifications',
            'jointablemodel' => 'UserProfessionalQualification',
            'fields' => [
            [
                'type' => 'text',
                'name' => 'qualification',
                'label' => 'Qualification',
            ],
            [
                'type' => 'text',
                'name' => 'subject',
                'label' => 'Subject',
            ]
            ],
            ]);
        

        $this->addSection(['title' => 'Summary', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.']);
        
        $this->addTextArea('talent-pool-summary');
        $this->addTextArea('talent-pool-summary-skills');
        $this->addTextArea('talent-pool-summary-experience');
        $this->addTextArea('talent-pool-interests-summary');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

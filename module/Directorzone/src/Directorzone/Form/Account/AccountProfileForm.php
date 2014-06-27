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
        
        $this->addOverview(['description' => 
            'Once completed, this anonymous profile will be published in the Talent Pool directory. This will be visible to all site visitors and allow logged-in members to message you for recruitment or other commercial purposes. Depending on the value of each approach, you may choose to respond and disclose your identity, or not respond.'
        ]);
        
        $this->addSelect(['label' => 'Publish Status', 'name' => 'talentpoolpublishstatus']);
        
        $this->addSection([
            'title' => 'Target Roles',
            'description' => 'Each target role described, up to a maximum of 3, will be published as a separate headline on the Talent Pool listing page.']);
        
        $this->addMultiTable([
            'groupname' => 'Target Roles',
            'jointablemodel' => 'UserTargetRole',
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
        
        $this->addSection(['title' => 'Expertise', 'description' => '']);
        
        $this->addSelect('profession');
        
        $this->addSelect(['label' => 'Job Area', 'name' => 'jobarea']);
        
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
        
        $this->addSection(['title' => 'Summary', 'description' => 'Please feel free to enhance your anonymous profile with further information in these text boxes - Summary, Skills, Experience, Personal Interests - that will apply to each target role that you complete.']);
        
        $this->addTextArea('talent-pool-summary');
        $this->addTextArea('talent-pool-summary-skills');
        $this->addTextArea('talent-pool-summary-experience');
        $this->addTextArea('talent-pool-summary-interests');
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

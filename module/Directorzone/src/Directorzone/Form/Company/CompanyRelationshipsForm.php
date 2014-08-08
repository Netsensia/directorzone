<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyRelationshipsForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-contact-');
        $this->setDefaultIcon('user');
        
        $this->addMultiTable([
        		'groupname' => 'Relationships for this company',
        		'jointablemodel' => 'CompanyRelationship',
        		'jointablekeycolumn' => 'companydirectoryid',
        		'fields' => [
        				['type' => 'select', 'name' => 'relationship', 'label' => 'Relationship Type'],
        				['type' => 'text', 'name' => 'relatedcompany', 'label' => 'Company Name'],
        				['type' => 'textarealink', 'name' => 'comment', 'label' => 'Comment'],
        				],
        		]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

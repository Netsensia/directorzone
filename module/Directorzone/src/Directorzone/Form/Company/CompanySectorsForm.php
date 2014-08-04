<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanySectorsForm extends NetsensiaForm
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
            'groupname' => 'Sectors',
            'jointablemodel' => 'CompanySector',
            'jointablekeycolumn' => 'companydirectoryid',
            'fields' => [
            ['type' => 'select', 'subtype' => 'tiered', 'name' => 'sector', 'label' => 'Please select one or more sectors'],
            ],
        ]);
        
        $this->addText(['name' => 'exportpercent', 'label' => 'Exports (% of revenues)']);
        
        $this->addGeographyPicker([
            'jointablemodel' => 'CompanyImportMarket',
            'label' => 'Import Markets',
        ]);
        
        $this->addGeographyPicker([
            'jointablemodel' => 'CompanyExportMarket',
            'label' => 'Export Markets',
        ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

<?php
namespace Directorzone\Form\Company;

use Netsensia\Form\NetsensiaForm;

class CompanyFinancialsForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('account-contact-');
        $this->setDefaultIcon('user');
        
        $this->addDate('incorporation-date');
        $this->addDate('closure-date');
        $this->addSelect(['name' => 'companystatus', 'label' => 'Company Status']);
        $this->addSelect(['name' => 'countryoforigin', 'label' => 'Country of Origin', 'table' => 'country']);
        $this->addSelect('exchange');
        $this->addSelect(['name' => 'companycategory', 'label' => 'Company Category']);
        $this->addText('trading-symbol');
        $this->addSelect(['name' => 'employeerange', 'label' => 'Number of Employees']);
        $this->addText(['name' => 'actualemployees', 'label' => 'Actual Employees']);
        $this->addDate(['name' => 'employeecountdate', 'label' => 'Date of Employee Count']);
        $this->addSelect(['name' => 'revenuerange', 'label' => 'Company Revenue']);
        $this->addText(['name' => 'actualrevenue', 'label' => 'Actual Revenue']);
        $this->addText(['name' => 'revenueyear', 'label' => 'Year of Reported Revenue']);
        $this->addSelect(['name' => 'revenuegrowthrange', 'table' => 'revenuerange', 'label' => 'Revenue Growth']);
        $this->addText(['name' => 'actualrevenuegrowth', 'label' => 'Actual Revenue Growth']);
        $this->addText(['name' => 'revenuegrowthyear', 'label' => 'Year of Revenue Growth']);
        $this->addSelect(['name' => 'financialyearend', 'table' => 'month', 'label' => 'Financial Year End']);
        $this->addMultiTable([
            'groupname' => 'Past Company Names',
            'jointablemodel' => 'CompanyPastName',
            'jointablekeycolumn' => 'companydirectoryid',
            'fields' => [
                ['type' => 'text', 'name' => 'companypastname', 'label' => 'Previous Name'],
            ],
        ]);
        $this->addSelect(['name' => 'companyphase', 'label' => 'Company Phase/Size']);

        $this->addSelectWithInvisibleOther(
            [
                'name' => 'companyranking',
                'label' => 'Company Ranking',
            ]);
        $this->addSelect(['name' => 'companyprofit', 'label' => 'Company Profit']);
        $this->addSelect(['name' => 'investmentstatus', 'label' => 'Investment Status']);
        
        $this->addMultiTable([
            'groupname' => 'Patents',
            'jointablemodel' => 'CompanyPatent',
            'jointablekeycolumn' => 'companydirectoryid',
            'fields' => [
                ['type' => 'text', 'name' => 'companypatent', 'label' => 'Patent'],
            ],
        ]);
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

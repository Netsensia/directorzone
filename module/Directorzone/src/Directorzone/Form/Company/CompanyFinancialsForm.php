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
        /*

        Trading symbol (if listed)		DD
        Company EMPLOYEES*			DD	Range
        Company EMPLOYEES		FT	Actual
        Company EMPLOYEES (date)		DD	i.e year of reported employees
        Company REVENUES*			DD	Range
        Company REVENUES		FT	Actual
        Company REVENUES (date)		DD	i.e year of reported rev
        Company revenue GROWTH (range) DD
        Company revenue GROWTH (date) DD i.e year of reported growth
        Financial year (end)			CH / FT	Month
        Past company names			CH / FT
        Company PHASE / SIZE			DD	Large, Medium, Small, Micro, Start-up
        Company PROFIT			DD	Range
        Company RANKING			DD	Choose from list of Ranking bodies (Fastrack, Queen’s Award, etc.)
        Company RANKING			DD	Select year(s) that appeared in ranking
        Patents				FT
        Company INVESTMENT status		DD	Vc-backed, Angel-backed, etc.
        */
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

<?php
namespace Directorzone\Form\People;

use Netsensia\Form\NetsensiaForm;

class PeopleOverviewForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('people-overview-');
        $this->setDefaultIcon('user');
        
        $this->addAddress('addressid');
        
        $this->addSubmit('Submit');

        parent::prepare();
    }
}

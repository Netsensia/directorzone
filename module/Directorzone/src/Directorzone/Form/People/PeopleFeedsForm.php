<?php
namespace Directorzone\Form\People;

use Netsensia\Form\NetsensiaForm;

class PeopleFeedsForm extends NetsensiaForm
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('people-feeds-');
        $this->setDefaultIcon('user');
        
        $this->addText('twitter-user-name');
        $this->addTextArea('twitter-search-terms');
        $this->addTextArea([
            'name' => 'rsssearchterms',
            'label' => 'Web search terms'
        ]);
        
        $this->addHidden(
            'canusefeedcache',
            'N'
        );
                
        $this->addSubmit('Submit');

        parent::prepare();
    }
}

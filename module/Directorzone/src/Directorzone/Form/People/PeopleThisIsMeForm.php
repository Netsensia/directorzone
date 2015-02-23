<?php
namespace Directorzone\Form\People;

use Netsensia\Form\NetsensiaForm;
use Directorzone\Service\WhosWhoService;

class PeopleThisIsMeForm extends NetsensiaForm
{
    private $userModel;
    private $whosWhoModel;
    private $whosWhoService;
    
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function setUserModel($userModel)
    {
        $this->userModel = $userModel;
    }
    
    public function setWhosWhoModel($whosWhoModel)
    {
        $this->whosWhoModel = $whosWhoModel;
    }
    
    public function setWhosWhoService(WhosWhoService $whosWhoService)
    {
        $this->whosWhoService = $whosWhoService;
    }
    
    public function prepare()
    {
        $this->setFieldPrefix('people-this-is-me-');
        $this->setDefaultIcon('user');
        
        $isOwner = $this->whosWhoService->isOwner(
            $this->whosWhoModel->getId(),
            $this->userModel->getUserId()
        );
        
        if (!$isOwner) {
            $this->addTextArea([
                'name' => 'relationshiptext',
                'label' => 'About me',
            ]);
        } else {
            
        }
        
        $this->addHidden('userid', $this->userModel->getUserId());
        $this->addHidden('whoswhoid', $this->whosWhoModel->getId());
        
        $this->addSubmit('Submit');
        
        parent::prepare();
    }
}

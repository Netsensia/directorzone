<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Netsensia\Exception\NotFoundResourceException;

class PeopleEditController extends NetsensiaActionController
{
    public function overviewAction()
    {
        return $this->genericForm('PeopleOverviewForm', 'WhosWho');
    }
    
    public function feedsAction()
    {
        return $this->genericForm('PeopleFeedsForm', 'WhosWho');
    }
    
    public function thisIsMeAction()
    {
        return $this->genericForm('PeopleThisIsMeForm', 'WhosWho');
    }
    
    private function genericForm($formName, $modelName)
    {
        $peopleDetails = $this->getServiceLocator()->get('WhosWhoService')->getWhosWhoDetails(
            $this->params('id')
        );
        
        $form = $this->processForm(
                $formName,
                $modelName,
                $this->params('id')
            );
        
        return array(
            "whosWhoDetails" => $peopleDetails,
            "form" => $form,
            'flashMessages' => $this->getFlashMessages(),
        );
    }
}

<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PeopleEditController extends NetsensiaActionController
{
    /**
     * @var PeopleService
     */
    private $peopleService;
    
    public function __construct(
        PeopleService $peopleService
    )
    {
        $this->peopleService = $peopleService;
    }

    public function feedsAction()
    {
        return $this->genericForm('PeopleFeedsForm', 'PeopleDirectory');
    }
    
    private function genericForm($formName, $modelName)
    {
        $peopleDetails = $this->peopleService->getPeopleDetails(
            $this->params('id')
        );
    
        return array(
            "peopleDetails" => $peopleDetails,
            "form" => $this->processForm(
                $formName,
                $modelName,
                $this->params('id')
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }    
}

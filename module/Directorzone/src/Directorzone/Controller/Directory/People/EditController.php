<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class EditController extends NetsensiaActionController
{
    /**
     * @var PeopleService
     */
    private $peopleService;
    
    public function __construct(
        PeopleService $peopleService
    ) {
        $this->peopleService = $peopleService;
    }

}

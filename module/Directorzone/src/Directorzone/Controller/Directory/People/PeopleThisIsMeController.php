<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyOwnersService;
use Directorzone\Service\WhosWhoService;
use Directorzone\Service\PeopleThisIsMeService;

class PeopleThisIsMeController extends NetsensiaActionController
{
    /**
     * @var PeopleThisIsMeService
     */
    private $peopleThisIsMeService;
    
    private $whosWhoService;
    
    public function __construct(
        PeopleThisIsMeService $peopleThisIsMeService,
        WhosWhoService $whosWhoService
    )
    {
        $this->peopleThisIsMeService = $peopleThisIsMeService;
        $this->whosWhoService = $whosWhoService;
    }
      
    public function thisIsMeAction()
    {  
        $whosWhoId = $this->params('id');
        $return = [
            'hasOwner' => $this->peopleThisIsMeService->hasOwner($whosWhoId),
            'userIsOwner' => $this->peopleThisIsMeService->userIsOwner($whosWhoId),
            'whosWhoId' => $whosWhoId,
            'whosWhoDetails' => $this->whosWhoService->getWhosWhoDetails($whosWhoId)
        ];
    
        if (!$this->isLoggedOn()) {
            return $this->redirect()->toRoute('login');
        }

        $hiddenValues['whoswhoid'] = $whosWhoId;
        $hiddenValues['userid'] = $this->getUserId();

        $userWhosWhoId = $this->peopleThisIsMeService->getUserWhosWhoId(
            $this->getUserId(),
            $whosWhoId
        );

        $return['form'] = $this->processForm(
                'PeopleThisIsMeForm',
                'UserWhosWho',
                $userWhosWhoId
            );
        
        $return['flashMessages'] = $this->getFlashMessages();
        
        return $return;
    }
}

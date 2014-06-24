<?php

namespace Directorzone\Controller\Directory\TalentPool;

use Netsensia\Controller\NetsensiaActionController;
use Netsensia\Exception\NotFoundResourceException;
use Directorzone\Service\TalentPoolService;

class TalentPoolViewController extends NetsensiaActionController
{
    /**
     * @var TalentPoolService
     */
    private $talentPoolService;
    
    public function __construct(
        TalentPoolService $talentPoolService
    )
    {
        $this->talentPoolService = $talentPoolService;
    }

    public function talentPoolDetailsAction()
    {
        $talentPoolDirectoryId = $this->params('id');
        
        try {
        
            $talentPoolDetails = $this->talentPoolService->getTalentPoolDetails(
                $talentPoolDirectoryId
            );
            
            return $talentPoolDetails;
            
        } catch (NotFoundResourceException $e) {
            
            $this->getResponse()->setStatusCode(404);
            
        }
    }
}

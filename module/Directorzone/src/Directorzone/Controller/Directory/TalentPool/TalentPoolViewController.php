<?php

namespace Directorzone\Controller\Directory\TalentPool;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;
use Directorzone\Service\TalentPoolService;

class TalentPoolViewController extends NetsensiaActionController
{
    /**
     * @var TalentPoolService¤
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
    }
}

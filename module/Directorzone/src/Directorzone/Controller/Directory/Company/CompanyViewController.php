<?php

namespace Directorzone\Controller\Directory\Company;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;

class CompanyViewController extends NetsensiaActionController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    
    /**
     * @var TwitterService
     */
    private $twitterService;
    
    public function __construct(
        CompanyService $companyService,
        TwitterService $twitterService
    ) {
        $this->companyService = $companyService;
        $this->twitterServuce = $twitterService;
    }
    
    public function companyDetailsAction()
    {
        $companyDirectoryId = $this->params('id');
                
        try {
            
            $twitterResults = $this->twitterService->search('Microsoft');
            
            var_dump($twitterResults);
            $companyDetails = $this->companyService->getCompanyDetails(
                $companyDirectoryId
            );
            
            $returnArray = array_merge(
	            $twitterResults,
                $companyDetails
            );
            
            return $returnArray;
            
        } catch (NotFoundResourceException $e) {
            
            $this->getResponse()->setStatusCode(404);
            
        }
    }
}

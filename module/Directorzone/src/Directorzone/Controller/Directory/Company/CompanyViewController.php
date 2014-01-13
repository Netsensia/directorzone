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
        $this->twitterService = $twitterService;
    }
    
    public function companyDetailsAction()
    {
        $companyDirectoryId = $this->params('id');
                
        try {
            
            $companyDetails = $this->companyService->getCompanyDetails(
                $companyDirectoryId
            );
            
            $twitterSearchTerm = str_replace('limited', '', strtolower($companyDetails['name']));
            $twitterSearchTerm = str_replace('ltd', '', $twitterSearchTerm);
            $twitterSearchTerm = str_replace('holdings', '', $twitterSearchTerm);
            $twitterSearchTerm = str_replace('plc', '', $twitterSearchTerm);
            $twitterSearchTerm = str_replace('&', 'and', $twitterSearchTerm);
            
            $twitterSearchTerm = trim($twitterSearchTerm);
            
            $twitterResults = $this->twitterService->search(
                $twitterSearchTerm,
                5
            );
            
            $returnArray = array_merge(
                $companyDetails,
                $twitterResults
            );
                        
            return $returnArray;
            
        } catch (NotFoundResourceException $e) {
            
            $this->getResponse()->setStatusCode(404);
            
        }
    }
}

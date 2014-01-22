<?php

namespace Directorzone\Controller\Directory\Company;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;

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
    
    /**
     * @var BingService
     */
    private $bingService;
    
    public function __construct(
        CompanyService $companyService,
        TwitterService $twitterService,
        BingService $bingService
    ) {
        $this->companyService = $companyService;
        $this->twitterService = $twitterService;
        $this->bingService = $bingService;
    }
    
    public function companyDetailsAction()
    {
        $companyDirectoryId = $this->params('id');
                
        try {
            
            $companyDetails = $this->companyService->getCompanyDetails(
                $companyDirectoryId
            );
            
            $zendCache = $this->getServiceLocator()->get('ZendCache');

            $cacheKey = 'companyDetailsActionFeedResults' . $companyDirectoryId;
            
            $success = false;
            $result = $zendCache->getItem($cacheKey, $success);
            
            if ($success) {
                $feedResults = $result;
            } else {
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
                
                $bingSearchTerm = $twitterSearchTerm;
                
                $searchResults = [];
                
                $searchResults = $this->bingService->search(
                    $bingSearchTerm,
                    4
                );
                
                $returnArray = array_merge(
                    $companyDetails,
                    $twitterResults
                );
                
                if (isset($searchResults['d']['results'])) {
                    $bingResults = ['bing' => $searchResults['d']['results']];
                } else {
                    $bingResults = ['bing' => []];
                }
                
                $feedResults = array_merge(
                    $twitterResults,
                    $bingResults
                );
                
                $zendCache->setItem($cacheKey, $feedResults);
            }
               
            $returnArray = array_merge(
                $companyDetails,
                $feedResults
            );
            
            return $returnArray;
            
        } catch (NotFoundResourceException $e) {
            
            $this->getResponse()->setStatusCode(404);
            
        }
    }
}

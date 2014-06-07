<?php

namespace Directorzone\Controller\Directory\Company;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;

class TalentPoolViewController extends NetsensiaActionController
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
    )
    {
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
            
            $cacheSuccess = false;
            $zendCache = $this->getServiceLocator()->get('ZendCache');
            $cacheKey = 'companyDetailsActionFeedResults' . $companyDirectoryId;
            
            if ($companyDetails['canusefeedcache'] == 'Y') {
                $result = $zendCache->getItem($cacheKey, $cacheSuccess);
            }
            
            if ($cacheSuccess) {
                $feedResults = $result;
            } else {
                
                if (isset($companyDetails['twittersearchterms'])) {
                    $twitterSearchTerm = $companyDetails['twittersearchterms'];
                } else {
                    $twitterSearchTerm = str_replace('limited', '', strtolower($companyDetails['name']));
                    $twitterSearchTerm = str_replace('ltd', '', $twitterSearchTerm);
                    $twitterSearchTerm = str_replace('holdings', '', $twitterSearchTerm);
                    $twitterSearchTerm = str_replace('plc', '', $twitterSearchTerm);
                    $twitterSearchTerm = str_replace('&', 'and', $twitterSearchTerm);
                }
                
                $twitterSearchTerm = trim($twitterSearchTerm);
                
                $twitterResults = $this->twitterService->search(
                    $twitterSearchTerm,
                    5
                );
                
                if (isset($companyDetails['rsssearchterms'])) {
                    $bingSearchTerm = $companyDetails['rsssearchterms'];
                } else {
                    $bingSearchTerm  = $twitterSearchTerm;
                }
                
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
                
                $this->companyService->updateCanUseFeedCache(
                    $companyDirectoryId,
                    true
                );
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
    
    public function deleteAction()
    {
        $this->companyService->deleteCompanyFromCompanyDirectory($this->params('id'));
        $this->redirect()->toRoute('directories/company-directory');
    }
}

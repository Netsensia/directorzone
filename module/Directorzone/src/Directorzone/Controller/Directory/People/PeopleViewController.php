<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;
use Directorzone\Service\PeopleService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;

class PeopleViewController extends NetsensiaActionController
{
    /**
     * @var PeopleService
     */
    private $peopleService;
    
    /**
     * @var TwitterService
     */
    private $twitterService;
    
    /**
     * @var BingService
     */
    private $bingService;
    
    public function __construct(
        PeopleService $peopleService,
        TwitterService $twitterService,
        BingService $bingService
    )
    {
        $this->peopleService = $peopleService;
        $this->twitterService = $twitterService;
        $this->bingService = $bingService;
    }
    
    public function peopleDetailsAction()
    {
        $peopleDirectoryId = $this->params('id');
        
        try {
        
            $peopleDetails = $this->peopleService->getPeopleDetails(
                $peopleDirectoryId
            );
        
            $zendCache = $this->getServiceLocator()->get('ZendCache');
        
            $cacheKey = 'peopleDetailsActionFeedResults' . $peopleDirectoryId;
        
            $success = false;
            $result = $zendCache->getItem($cacheKey, $success);
        
            if ($success) {
                $feedResults = $result;
            } else {
                $twitterSearchTerm = str_replace('limited', '', strtolower($peopleDetails['forename'] . ' ' . $peopleDetails['surname']));
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
                    $peopleDetails,
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
                $peopleDetails,
                $feedResults
            );
        
            return $returnArray;
        
        } catch (NotFoundResourceException $e) {
        
            $this->getResponse()->setStatusCode(404);
        
        }
    }

}

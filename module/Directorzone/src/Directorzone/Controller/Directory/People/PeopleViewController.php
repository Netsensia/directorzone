<?php

namespace Directorzone\Controller\Directory\People;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\PeopleService;
use Netsensia\Exception\NotFoundResourceException;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;

class PeopleViewController extends NetsensiaActionController
{
    /**
     * @var TwitterService
     */
    private $twitterService;
    
    /**
     * @var BingService
     */
    private $bingService;
    
    public function __construct(
        TwitterService $twitterService,
        BingService $bingService
    )
    {
        $this->twitterService = $twitterService;
        $this->bingService = $bingService;
    }
    
    public function peopleDetailsAction()
    {
        $peopleDirectoryId = $this->params('id');
        
        try {
        
            $peopleDetails = $this->getServiceLocator()->get('WhosWhoService')->getWhosWhoDetails(
                $peopleDirectoryId
            );
        
            if (isset($peopleDetails['twittersearchterms'])) {
                $twitterSearchTerm = $peopleDetails['twittersearchterms'];
            } else {
                $twitterSearchTerm = strtolower($peopleDetails['forename'] . ' ' . $peopleDetails['surname']);
            }
            
            $twitterSearchTerm = trim($twitterSearchTerm);
    
            $twitterResults = $this->twitterService->search(
                $twitterSearchTerm,
                5
            );
    
            if (isset($peopleDetails['rsssearchterms'])) {
                $bingSearchTerm = $peopleDetails['rsssearchterms'];
            } else {
                $bingSearchTerm  = $twitterSearchTerm;
            }
                    
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

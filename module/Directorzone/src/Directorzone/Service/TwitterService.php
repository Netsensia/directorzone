<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;

class TwitterService extends NetsensiaService
{
 
    /**
     * @var \TwitterAPIExchange
     */
    private $twitterApiExchange;
    
    public function __construct(
        \TwitterAPIExchange $twitterApiExchange
    ) {
        $this->twitterApiExchange = $twitterApiExchange;
    }
    
    public function search($searchTerm)
    {
        
        $results = $this->twitterApiExchange->buildOauth(
            'https://api.twitter.com/1.1/search/tweets.json',
            'POST'
        )->setPostfields([
            'q' => $searchTerm,
            'count' => 10
        ])
         ->performRequest();

        return $results;
    }

}

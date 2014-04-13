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
    
    public function search($searchTerm, $count)
    {
        
        $a = $this->twitterApiExchange->setGetfield('?q=' . urlencode($searchTerm) . '&count=' . $count);

        $b = $a->buildOauth(
            'https://api.twitter.com/1.1/search/tweets.json',
            'GET'
        );
        
        $c = $b->performRequest();
        
        $results['tweets'] = [];
        
        if ($c) {
            $json = json_decode($c);
            
            foreach ($json->statuses as $tweet) {
                $results['tweets'][] = [
                    'text' => $tweet->text,
                    'created' => $tweet->created_at,
                    'username' => $tweet->user->name,
                    'userimage' => $tweet->user->profile_image_url,	
                ];   
            }
        }
                
        return $results;
    }

}

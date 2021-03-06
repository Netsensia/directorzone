<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;

class BingService extends NetsensiaService
{
 
    /**
     * @var \Bing\Client
     */
    private $client;
    
    public function __construct(
        \Bing\Client $client
    )
    {
        $this->client = $client;
    }
    
    public function search($searchTerm, $count)
    {
        $searchTerm = str_replace(' ', '+', $searchTerm);
        
        $res = $this->client->get('News', [
                'Query' => $searchTerm,
            ]
        );
        
        $res = json_decode($res, true);

        return $res;
    }
}

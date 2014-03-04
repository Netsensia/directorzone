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
        $res = $this->client->get('News', ['Query' => $searchTerm, '$top' => '3']);
        
        $res = json_decode($res, true);

        return $res;
    }
}

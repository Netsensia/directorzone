<?php

namespace Directorzone\Controller\Api;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use GuzzleHttp\Client;
use Zend\View\Model\JsonModel;

class ApiController extends NetsensiaActionController
{
    public function __construct() 
    {
    }
   
    public function onDispatch(MvcEvent $e)
    {
        if (!$this->isLoggedOn()) {
            return $this->redirect()->toRoute('login');
        }

        parent::onDispatch($e);
    }

    public function lookupAction()
    {
        $baseUri = $this->getRequest()->getRequestUri();
        
        $parts = explode('/', $baseUri);
        $resource = $parts[count($parts)-1];

        $requestUri = 'http://api.directorzone.local/' . $resource;
        
        $client = new Client();
        $response = $client->get($requestUri, [
            'headers' => [
                'Accept' => 'application/hal+json'
            ]
        ]);
        
        echo $response->getBody(); die;
        
        $json = json_decode($response->getBody());
        
        return new JsonModel($json);
        
    }
        
}

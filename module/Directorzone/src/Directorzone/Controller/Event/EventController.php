<?php

namespace Directorzone\Controller\Event;

use Netsensia\Controller\NetsensiaActionController;
use Zend\View\Model\JsonModel;

class EventController extends NetsensiaActionController
{
    public function calendarAction()
    {
    }
 
    public function listAction()
    {
        $events = [
	        'success' => 1,
	        'result' => [
	           [
    	        "id" => 293,
    	        "title" => "Event 1",
    	        "url" => "http://example.com",
    	        "class" => "event-important",
    	        "start" => 12039485678000, // Milliseconds
    	        "end" => 1234576967000 // Milliseconds
              ],
           ],
        ];
        
        return new JsonModel(
            $events
        );
    }
}

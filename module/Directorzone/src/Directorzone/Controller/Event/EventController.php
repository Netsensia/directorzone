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
        $events = [];
        
        $events[] = [
            'id' => 293,
            'title' => 'Title',
            'url' => "http://example.com",
            'start' => 12039485678000,
            'end' => 1234576967000,
            'class' => 'event-important',
        ];
        
        return new JsonModel(
            [
                'success' => 1,
                'result' => $events,
            ]
        );
    }
}

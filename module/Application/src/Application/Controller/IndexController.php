<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {
        $items = [
    	        [
    	           'image' => '/img/brand/globe.fw.png',
    	           'title' => 'Example title',
    	           'content' => 'This is some example content.  It is a little bit longer than the title.'
                ],
                [
                'image' => '/img/brand/globe.fw.png',
                    'title' => 'Another example title',
                    'content' => 'This is some more example content.  It is a little bit longer than the title.'
                ],
            ];
        
        $mediaItems = [
            'news' => $items,
            'movers' => $items,
            'talentpool' => $items,
            'wantedoffered' => $items,
            'events' => $items,
            'blogposts' => $items,
           
        ];
        return [
            'flashMessages' => $this->getFlashMessages(),
            'mediaItems' => $mediaItems,
        ];
    }
}

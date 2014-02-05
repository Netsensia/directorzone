<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\ArticleService;
use Directorzone\Service\ElasticService;

class ImageUploadController extends NetsensiaActionController
{
    public function __construct(
    )
    {
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function imageUploadAction()
    {
        return new JsonModel(
            [
                'teaser'=>'/img/flag/England.fw.png',
                'thumb' => '/img/flag/Germany.fw.png',
                'main' => '/img/flag/Italy.fw.png',
            ]
        );
    }
}

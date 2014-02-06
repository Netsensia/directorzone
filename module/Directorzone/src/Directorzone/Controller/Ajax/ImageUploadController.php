<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\ArticleService;
use Directorzone\Service\ElasticService;
use Netsensia\Service\ImageService;

class ImageUploadController extends NetsensiaActionController
{
    private $imageService;
    
    public function __construct(
        ImageService $imageService
    )
    {
        $this->imageService = $imageService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function imageUploadAction()
    {
        if ($_FILES && is_array($_FILES) && count($_FILES) > 0) {
            $fieldIds = array_keys($_FILES);
            
            $file = $_FILES[$fieldIds[0]];
            $result = $this->imageService->saveUploadedFile($file);

            return new JsonModel(
                $result
            );
        }
        $this->getResponse()->setStatusCode(500);
    }
}
?>

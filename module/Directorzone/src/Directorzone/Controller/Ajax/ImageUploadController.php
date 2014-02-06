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
        if ($_FILES && is_array($_FILES) && count($_FILES) > 0) {
            $fieldIds = array_keys($_FILES);
            
            $file = $_FILES[$fieldIds[0]];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . uniqid() . '_' . md5($file['name']) . '.' . $extension;
            $finalPath = 'img/upload/' . $filename;
            move_uploaded_file($file['tmp_name'], 'public/' . $finalPath);
            file_put_contents('test2.txt', $finalPath);
            
            //{"account-publish-image":{"name":"enhanced-buzz-30227-1367984436-3.jpg","type":"image/jpeg","tmp_name":"/tmp/phpVs5F8l","error":0,"size":126392}}
            return new JsonModel(
                [
                    'teaser'=>'/img/flag/England.fw.png',
                    'thumb' => '/' . $finalPath,
                    'main' => '/img/flag/Italy.fw.png',
                ]
            );
        }
        $this->getResponse()->setStatusCode(500);
    }
}
?>

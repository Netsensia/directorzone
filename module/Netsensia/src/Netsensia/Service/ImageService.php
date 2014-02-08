<?php
namespace Netsensia\Service;

use Netsensia\Service\NetsensiaService;

class ImageService extends NetsensiaService
{
    public function saveUploadedFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        $filename = time() . '_' . uniqid() . '_' . md5($file['name']) . '.' . $extension;
        
        $basePath = '/img/upload/';
            
        $mainPath = $basePath . 'main/' . $filename;
        $thumbPath = $basePath . 'thumb/' . $filename;
        $teaserPath = $basePath . 'teaser/' . $filename;
        
        move_uploaded_file($file['tmp_name'], 'public' . $mainPath);
        
        $result = [
            'teaser' => $mainPath,
            'thumb' => $mainPath,
            'main' =>  $mainPath,
        ];
        
        return $result;
    }

}

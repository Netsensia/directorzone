<?php
namespace Netsensia\Service;

use Netsensia\Service\NetsensiaService;

class ImageService extends NetsensiaService
{
    public function saveUploadedFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '_' . md5($file['name']) . '.' . $extension;
        $finalPath = 'img/upload/' . $filename;
        move_uploaded_file($file['tmp_name'], 'public/' . $finalPath);
        
        return [
            'teaser'=>'/img/flag/England.fw.png',
            'thumb' => '/' . $finalPath,
            'main' => '/img/flag/Italy.fw.png',
        ];
    }
}

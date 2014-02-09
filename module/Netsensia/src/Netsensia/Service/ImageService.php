<?php
namespace Netsensia\Service;

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
        
        $mainZf2Path = 'public' . $mainPath;
        $thumbZf2Path = 'public' . $thumbPath;
        $teaserZf2Path = 'public' . $teaserPath;
        
        move_uploaded_file($file['tmp_name'], $mainZf2Path);
        
        $iMagick = new \IMagick($mainZf2Path);
        $iMagick->setImageFormat('jpg');
        $iMagick->cropthumbnailimage(200, 200);
        $iMagick->writeimage($thumbZf2Path);
        
        $iMagick = new \IMagick($mainZf2Path);
        $iMagick->setImageFormat('jpg');
        $iMagick->cropthumbnailimage(50, 50);
        $iMagick->writeimage($teaserZf2Path);
                    
        $result = [
            'teaser' => $teaserPath,
            'thumb' => $thumbPath,
            'main' =>  $mainPath,
        ];
        
        return $result;
    }

}

<?php
namespace Netsensia\Service;

use Netsensia\Service\NetsensiaService;

class ImageService extends NetsensiaService
{
    public function saveUploadedFile($file)
    {
        $teaserPath = ;
        $thumbPath = $this->saveThumb($file);
        $mainPath = $this->saveMain($file);
        
        return [
            'teaser' => $this->save($file, 'teaser', 200, 200),
            'thumb' => $this->save($file, 'thumb', 200, 200),
            'main' =>  $this->save($file, 'main', 200, 200),
        ];
    }
    
    private function saveTeaser($file, $directory)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        $filename = time() . '_' . uniqid() . '_' . md5($file['name']) . '.' . $extension;

        $finalPath = 'img/upload/teaser/' . $filename;
        move_uploaded_file($file['tmp_name'], 'public' . $finalPath);
        
        return $finalPath;
    }
}

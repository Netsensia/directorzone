<?php
namespace Directorzone\Service\Admin;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Adapter\Adapter;

class CompanyUploadService extends NetsensiaService
{
    private $dbAdapter;
    
    public function __construct(
        Adapter $adapter
    ) {
        $this->dbAdapter = $adapter;
    }

    public function ingest($filename)
    {
        $file = new \SplFileInfo($filename);
        
        if ($file->getExtension() != 'csv') {
            throw new \InvalidArgumentException(
	            'File type must be CSV'
            );
        }
    }
}
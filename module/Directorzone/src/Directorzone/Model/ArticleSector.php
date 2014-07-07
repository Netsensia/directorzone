<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class ArticleSector extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('articlesector');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("articlesectorid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articlesectorid'];
    }
}

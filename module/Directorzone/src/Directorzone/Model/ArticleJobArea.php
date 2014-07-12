<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class ArticleJobArea extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('articlejobarea');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("articlejobareaid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articlejobareaid'];
    }
}

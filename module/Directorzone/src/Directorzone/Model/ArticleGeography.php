<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class ArticleGeography extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('articlegeography');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("articlegeographyid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articlegeographyid'];
    }
}

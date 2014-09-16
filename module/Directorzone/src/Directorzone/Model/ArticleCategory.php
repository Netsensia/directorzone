<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class ArticleCategory extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('articlecategory');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("articlecategoryid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articlecategoryid'];
    }
}

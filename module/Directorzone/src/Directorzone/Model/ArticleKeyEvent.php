<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class ArticleKeyEvent extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('articlekeyevent');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("articlekeyeventid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articlekeyeventid'];
    }
}

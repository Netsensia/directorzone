<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserAvailableAs extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('useravailableas');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("useravailableasid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getArticleId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['useravailableasid'];
    }
}

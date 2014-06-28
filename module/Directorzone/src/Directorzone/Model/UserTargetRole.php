<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserTargetRole extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('usertargetrole');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("usertargetroleid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getArticleId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['usertargetroleid'];
    }
}

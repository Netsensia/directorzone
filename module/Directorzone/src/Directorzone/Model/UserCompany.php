<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserCompany extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('usercompany');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("usercompanyid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['usercompanyid'];
    }
}

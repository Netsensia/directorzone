<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserWhosWho extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('userwhoswho');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("userwhoswhoid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['userwhoswhoid'];
    }
}

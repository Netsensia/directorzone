<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserWhosWhoSector extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('userwhoswhosector');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("userwhoswhosectorid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['userwhoswhosectorid'];
    }
}

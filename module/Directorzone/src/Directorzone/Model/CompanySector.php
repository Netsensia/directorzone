<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanySector extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companysector');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companysectorid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companysectorid'];
    }
}

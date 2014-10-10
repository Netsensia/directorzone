<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyPatent extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companypatent');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companypatentid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companypatentid'];
    }
}

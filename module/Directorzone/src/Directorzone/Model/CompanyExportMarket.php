<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyExportMarket extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companyexportmarket');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companyexportmarketid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companyexportmarketid'];
    }
}

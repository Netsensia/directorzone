<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyImportMarket extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companyimportmarket');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companyimportmarketid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companyimportmarketid'];
    }
}

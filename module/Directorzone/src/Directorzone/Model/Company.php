<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class Company extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companydirectory');
    
        parent::__construct();
    
    }
    
    public function init($companyId = null)
    {
        $this->setPrimaryKey(array("companyid" => $companyId));
        if ($companyId != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getCompanyId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['addressid'];
    }
}

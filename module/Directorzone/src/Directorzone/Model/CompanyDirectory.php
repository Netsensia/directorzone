<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyDirectory extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companydirectory');
    
        parent::__construct();
    
    }
    
    public function init($companyId = null)
    {
        $this->setPrimaryKey(array("companydirectoryid" => $companyId));
        if ($companyId != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getCompanyId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companydirectoryid'];
    }
}

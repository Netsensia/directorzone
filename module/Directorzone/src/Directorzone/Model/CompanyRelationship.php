<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyRelationship extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companyrelationship');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companyrelationshipid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companyrelationshipid'];
    }
}

<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class PeopleDirectory extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companyofficer');
    
        parent::__construct();
    
    }
    
    public function init($companyId = null)
    {
        $this->setPrimaryKey(array("officerid" => $companyId));
        if ($companyId != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getPersonId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['officerid'];
    }
}

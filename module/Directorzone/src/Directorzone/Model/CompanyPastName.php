<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class CompanyPastName extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('companypastname');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("companypastnameid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getSectorId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['companypastnameid'];
    }
}

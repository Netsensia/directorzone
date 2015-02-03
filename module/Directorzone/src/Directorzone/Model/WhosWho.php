<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class WhosWho extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('whoswho');
    
        parent::__construct();
    }
    
    public function init($officerId = null)
    {
        $this->setPrimaryKey(array("whoswhoid" => $officerId));
        if ($officerId != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getPersonId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['whoswhoid'];
    }
}

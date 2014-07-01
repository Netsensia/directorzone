<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserMessage extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('usermessage');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array("usermessageid" => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getUserMessageId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['usermessageid'];
    }
}

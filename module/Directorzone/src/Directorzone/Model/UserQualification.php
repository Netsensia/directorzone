<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class UserQualification extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('userqualification');
    
        parent::__construct();
    
    }
    
    public function init($id = null)
    {
        $this->setPrimaryKey(array($this->getTableName() . 'id' => $id));
        if ($id != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getArticleId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey[$this->getTableName() . 'id'];
    }
}

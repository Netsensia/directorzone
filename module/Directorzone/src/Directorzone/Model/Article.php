<?php
namespace Directorzone\Model;

use Netsensia\Model\DatabaseTableModel;

class Article extends DatabaseTableModel
{
    public function __construct()
    {
        $this->setTableName('article');
    
        parent::__construct();
    
    }
    
    public function init($articleId = null)
    {
        $this->setPrimaryKey(array("articleid" => $articleId));
        if ($articleId != null) {
            $this->load();
        }
        return $this;
    }
    
    public function getArticleId()
    {
        $primaryKey = $this->getPrimaryKey();
        return $primaryKey['articleid'];
    }
}

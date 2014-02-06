<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ArticleService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $articleTable;
    
    public function __construct(
        TableGateway $articleTable
    )
    {
        $this->articleTable = $articleTable;
    }
    
    public function getArticle($articleId)
    {
        $rowset = $this->articleTable->select(
            function (Select $select) use ($articleId) {
        
                $select->columns(
                    ['title', 'publishdate', 'articleid', 'content', 'image']
                )
                ->where(['articleid' => $articleId]);
            }
        );
        
        $rows = $rowset->toArray();
        
        if (count($rows) == 1) {
            $article = $rows[0];
            $article['image'] = 'https://dl.dropboxusercontent.com/u/63777076/_72603635_stottie_petermiddleton.jpg';
            return $article;
        } else {
            throw new NotFoundResourceException('Article not found');
        }
    }
    
    public function getArticlesByType($typeArray, $start, $end = 0)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
        
        $rowset = $this->articleTable->select(
            function (Select $select) use ($typeArray, $start, $end) {
        
                $select->where(
                    ['articlecategoryid' => $typeArray]
                )
                ->columns(
                    ['image', 'title', 'content', 'publishdate', 'articleid']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('publishdate DESC');
            }
        );
        
        $rows = $rowset->toArray();
        $articles = [];
        
        foreach ($rows as $row) {
            $image = '/img/brand/globe.fw.png';
            $articles[] = [
	            'image' => $image,
	            'title' => $row['title'],
	            'content' => $row['content'],
	            'articleid' => $row['articleid'],
	            'publishdate' => $row['publishdate'],
            ];
        }
        
        return $articles;
    }
}
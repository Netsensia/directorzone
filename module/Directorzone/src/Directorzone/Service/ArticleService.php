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
                    ['title', 'publishdate', 'articleid', 'content']
                )
                ->where(['articleid' => $articleId]);
            }
        );
        
        $rows = $rowset->toArray();
        
        if (count($rows) == 1) {
            return $rows[0];
        } else {
            throw new NotFoundResourceException('Article not found');
        }
    }

    public function getArticles($start, $end)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
        
        $rowset = $this->articleTable->select(
            function (Select $select) use ($start, $end) {
        
                $select->columns(
                    ['title', 'publishdate', 'articleid', 'content']
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
                'articleid' => $row['articleid'],
                'publishdate' => $row['publishdate'],
                'content' => $row['content'],
            ];
        }

        return $articles;
    }
    
    public function getArticlesByType($type, $start, $end = 0)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
        
        switch ($type) {
        	case 'news' : $categoryId = 2; break;
        	case 'movers' : $categoryId = 8; break;
        	case 'blogposts' : $categoryId = 1; break;
        	case 'wanted' : $categoryId = 3; break;
        	case 'offered' : $categoryId = 4; break;
        	case 'events' : $categoryId = 5; break;
        	case 'jobs' : $categoryId = 7; break;
        	default: throw new \Exception('Category ' . $type . ' not found');
        }
        
        $rowset = $this->articleTable->select(
            function (Select $select) use ($categoryId, $start, $end) {
        
                $select->where(
                    ['articlecategoryid' => $categoryId]
                )
                ->columns(
                    ['image', 'title', 'content']
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
            ];
        }
        
        return $articles;
    }
}

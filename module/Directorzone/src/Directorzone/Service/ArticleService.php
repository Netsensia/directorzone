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
    
    public function deleteArticle($articleId)
    {
        $this->articleTable->delete(['articleid' => $articleId]);
    }
    
    public function getArticle($articleId)
    {
        $rowset = $this->articleTable->select(
            function (Select $select) use ($articleId) {
        
                $select->columns(
                    ['title', 'publishdate', 'articleid', 'content', 'image', 'userid']
                )
                ->join('user', 'article.userid = user.userid', ['pseudonym'])
                ->where(['articleid' => $articleId]);
            }
        );
        
        $rows = $rowset->toArray();
        
        if (count($rows) == 1) {
            $article = $rows[0];
            $autoPseudonym = 'AnonymousUser' . $article['userid'];
            $article['pseudonym'] =
                ($article['pseudonym'] == '' ? $autoPseudonym : $article['pseudonym']);
            $article['image'] =
                ($article['image'] == '' ? '/img/brand/globe.fw.png' : $article['image']);
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
                    ['image', 'title', 'content', 'publishdate', 'articleid', 'startdate', 'enddate']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('articleid DESC');
            }
        );
        
        $rows = $rowset->toArray();
        $articles = [];
        
        foreach ($rows as $row) {
            $image = ($row['image'] == '' ? '/img/brand/globe.fw.png' : $row['image']);
            $articles[] = [
	            'image' => $image,
	            'title' => $row['title'],
	            'content' => $row['content'],
	            'startdate' => $row['startdate'],
	            'enddate' => $row['enddate'],
	            'articleid' => $row['articleid'],
	            'publishdate' => $row['publishdate'],
            ];
        }
        
        return $articles;
    }
}

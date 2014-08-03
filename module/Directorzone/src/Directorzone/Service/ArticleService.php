<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Netsensia\Service\CommentsService;

class ArticleService extends NetsensiaService
{
    private $commentsService;
    
    /**
     * @var TableGateway
     */
    private $articleTable;
    private $articleSectorTable;
    private $articleGeographyTable;
    private $articleKeyEventTable;
    private $articleJobAreaTable;
        
    public function __construct(
        CommentsService $commentsService,
        TableGateway $articleTable,
        TableGateway $articleSectorTable,
        TableGateway $articleGeographyTable,
        TableGateway $articleKeyEventTable,
        TableGateway $articleJobAreaTable 
    )
    {
        $this->setPrimaryTable($articleTable);
        
        $this->commentsService = $commentsService;
        $this->articleTable = $articleTable;
        $this->articleSectorTable = $articleSectorTable;
        $this->articleGeographyTable = $articleGeographyTable;
        $this->articleKeyEventTable = $articleKeyEventTable;
        $this->articleJobAreaTable = $articleJobAreaTable;
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
            
            $article['comments'] = 
                $this->commentsService->getCommentsForArticle(
                    $articleId, 1, 1000, 1
                );
            
            $article['sectors'] = $this->getRelationshipList(
                $articleId,
                'sector',
                $this->articleSectorTable
            );
            
            $article['geographies'] = $this->getRelationshipList(
                $articleId,
                'geography',
                $this->articleGeographyTable
            );
            
            $article['keyevents'] = $this->getRelationshipList(
                $articleId,
                'keyevent',
                $this->articleKeyEventTable
            );
            
            $article['jobareas'] = $this->getRelationshipList(
                $articleId,
                'jobarea',
                $this->articleJobAreaTable
            );
            
            return $article;
        } else {
            throw new NotFoundResourceException('Article not found');
        }
    }
    
    public function getArticlesByType($typeArray, $statusArray, $start, $end = 0, $order, $userId = null)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
        

        $rowset = $this->articleTable->select(
            function (Select $select) use ($typeArray, $statusArray, $start, $end, $order, $userId) {

                $sortColumns = ['title', 'title', 'publishdate', 'publishdate'];
                
                if ($userId == null) {
                    $criteria = [
                        'articlecategoryid' => $typeArray,
                        'approvestatusid' => $statusArray,
                    ];
                } else {
                    $criteria = [
                        'articlecategoryid' => $typeArray,
                        'userid' => $userId,
                        'approvestatusid' => $statusArray,
                    ];
                }
                
                $select->where($criteria)
                       ->columns(
                           ['image', 'title', 'content', 'publishdate', 'articleid', 'startdate', 'enddate']
                       )
                       ->offset($start - 1)
                       ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'))
                       ->limit(1 + ($end - $start));
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

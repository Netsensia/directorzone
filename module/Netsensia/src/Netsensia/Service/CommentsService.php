<?php
namespace Netsensia\Service;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;

class CommentsService extends NetsensiaService
{
    private $articleCommentsTable;
    
    public function __construct(
	    TableGateway $articleCommentsTable
    )
    {
        $this->articleCommentsTable = $articleCommentsTable;
    }
    
    public function addComment(
        $userId,
        $articleId,
        $content
    )
    {
        $result = $this->articleCommentsTable->insert(
            [
                'userid' => $userId,
                'articleid' => $articleId,
                'content' => $content,
            ]
        );
        
        $success = ($result == 1);
        
        $result = [
            'success' => $success,
            'userid' => $userId,
            'articleid' => $articleId,
            'content' => $content,
        ];
        
        return $result;
    }
    
    public function getCommentsForArticle($articleId, $start, $end, $order)
    {
        $rowset = $this->articleCommentsTable->select(
            function (Select $select) use ($articleId, $start, $end, $order) {
                $columns = ['articlecommentid', 'userid', 'content', 'createdtime'];
        
                $select->where(
                    ['articlecomment.articleid' => $articleId]
                )
                ->columns(
                    $columns
                )
                ->join(
                    'user',
                    'user.userid = articlecomment.userid',
                    ['name', 'forenames', 'surname'],
                    'left'
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('createdtime desc');
            }
        );
        
        $comments = [
            'results' => [],
        ];
        
        $results = $rowset->toArray();
        
        foreach ($results as $result) {
        
            $from = $result['forenames'] . ' ' . $result['surname'];
            if (trim($from) == '') {
                $from = $result['name'];
            }
            
            $comments['results'][] = [
                'internalId' => $result['articlecommentid'],
                'content' => $result['content'],
                'createdtime' => $result['createdtime'],
                'author' => $result['forenames'] . ' ' . $result['surname'],
            ];
        }
        
        return $comments;
    }
}

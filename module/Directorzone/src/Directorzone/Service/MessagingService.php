<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class MessagingService extends NetsensiaService
{
    private $userMessageTable;
    
    public function __construct(
	    TableGateway $userMessageTable
    )
    {
        $this->userMessageTable = $userMessageTable;
    }
    
    public function sendMessage(
        $id,
        $type,
        $title,
        $content
    )
    {
        $result = $this->userMessageTable->insert(
            [
                'userid' => $id,
                'senderid' => $this->getUserId(),
                'typeid' => $type,
                'title' => $title,
                'content' => $content,
            ]
        );
        
        $success = ($result == 1);
        
        $result = [
            'success' => $success,
            'id' => $id,
            'type' => $type,
            'title' => $title,
            'content' => $content,
        ];
        
        return $result;
    }
    
    public function getInboxList($start, $end, $order)
    {
        $rowset = $this->userMessageTable->select(
            function (Select $select) use ($start, $end, $order) {
                $columns = ['usermessageid', 'userid', 'typeid', 'title', 'content', 'senttime'];
        
                $sortColumns = ['surname', 'title'];
        
                $select->where(
                    ['usermessage.userid' => $this->getUserId()]
                )
                ->columns(
                    $columns
                )
                ->join(
                    'user',
                    'user.userid = usermessage.senderid',
                    ['forenames', 'surname'],
                    'left'
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );
        
        $messages = [
            'results' => [],
        ];
        
        $results = $rowset->toArray();
        
        foreach ($results as $result) {
        
            $messages['results'][] = [
                'internalId' => $result['usermessageid'],
                'title' => $result['title'],
                'content' => $result['content'],
                'senttime' => $result['senttime'],
                'from' => $result['forenames'] . ' ' . $result['surname']
            ];
        }
        
        return $messages;
    }

}

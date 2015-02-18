<?php
namespace Netsensia\Service;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;

class MessagingService extends NetsensiaService
{
    private $userMessageTable;
    private $feedbackTable;
    
    public function __construct(
	    TableGateway $userMessageTable,
        TableGateway $feedbackTable
    )
    {
        $this->userMessageTable = $userMessageTable;
        $this->feedbackTable = $feedbackTable;
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
                $columns = ['usermessageid', 'userid', 'senttime', 'typeid', 'title', 'content'];
        
                $sortColumns = ['surname', 'title', 'senttime'];
        
                $select->where(
                    ['usermessage.userid' => $this->getUserId()]
                )
                ->columns(
                    $columns
                )
                ->join(
                    'user',
                    'user.userid = usermessage.senderid',
                    ['name', 'forenames', 'surname'],
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
        
            $from = $result['forenames'] . ' ' . $result['surname'];
            if (trim($from) == '') {
                $from = $result['name'];
            }
            
            $messages['results'][] = [
                'internalId' => $result['usermessageid'],
                'title' => $result['title'],
                'content' => $result['content'],
                'senttime' => $result['senttime'],
                'from' => $from
            ];
        }
        
        return $messages;
    }
    
    public function getMessageDetails($userMessageId)
    {
        $rowset = $this->userMessageTable->select(
            function (Select $select) use ($userMessageId) {
        
               $columns = ['usermessageid', 'senderid', 'userid', 'typeid', 'title', 'content', 'senttime'];
                
                $select->where(
                    ['usermessageid' => $userMessageId]
                )
                ->columns(
                    $columns
                )
                ->join(
                    'user',
                    'user.userid = usermessage.senderid',
                    ['forenames', 'surname', 'name'],
                    'left'
                );
            }
        );
        
        $rows = $rowset->toArray();
        
        if (count($rows) == 1) {
            $message = $rows[0];
            
            $from = $message['forenames'] . ' ' . $message['surname'];
            if (trim($from) == '') {
                $from = $message['name'];
            }
            
            $message['from'] = $from;
            
            return $message;
        } else {
            throw new NotFoundResourceException('Message not found');
        }
    }
}

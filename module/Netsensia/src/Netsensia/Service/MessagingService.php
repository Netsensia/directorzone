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
    
    public function deleteMessage($id)
    {
        $deletedRows = $this->userMessageTable->delete(['usermessageid' => $id]);
        if ($deletedRows != 1) {
            return [
                'success' => false,
                'message' => 'Unknown error deleting message',
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Message deleted',
        ];
    }
    
    public function archiveMessage($id, $unarchive = false)
    {
        $archiveFlag = $unarchive ? 'N' : 'Y';
        
        $rowCount = $this->userMessageTable->update(['isarchived' => $archiveFlag], ['usermessageid' => $id]);
        if ($rowCount != 1) {
            return [
                'success' => false,
                'message' => 'Unknown error updating message',
            ];
        }
    
        return [
            'success' => true,
            'message' => 'Message updating',
        ];
    }
    
    public function flagMessage($id, $unflag = false)
    {
        $flagFlag = $unflag ? 'N' : 'Y';
    
        $rowCount = $this->userMessageTable->update(['isflagged' => $flagFlag], ['usermessageid' => $id]);
        if ($rowCount != 1) {
            return [
                'success' => false,
                'message' => 'Unknown error updating message',
            ];
        }
    
        return [
            'success' => true,
            'message' => 'Message updated',
        ];
    }
    
    public function sendMessage(
        $id,
        $type,
        $title,
        $content,
        $receiverName
    )
    {
        $receiverName = trim($receiverName);
        
        $title = preg_replace('/^Re: Re:/', 'Re:', $title);
        
        if ($receiverName != '') {
            $result = $this->getServiceLocator()->get('UserTableGateway')->select(
                function (Select $select) use ($receiverName) {
                    $select->columns(['userid'])->where(['name' => $receiverName]);
                }
            )->toArray();

            if (count($result) == 1) {
                $id = $result[0]['userid'];
            } else {
                return [
                    'success' => false,
                    'message' => 'Recipient not found',
                ];
            }
        }
        
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
            'message' => 'Message sent',
        ];
        
        return $result;
    }
    
    public function getInboxList($start, $end, $order, $isArchive = false)
    {
        $rowset = $this->userMessageTable->select(
            function (Select $select) use ($start, $end, $order, $isArchive) {
                $columns = ['usermessageid', 'userid', 'senttime', 'typeid', 'title', 'content'];
        
                $sortColumns = ['surname', 'title', 'senttime'];
        
                $select->where(
                    ['usermessage.userid' => $this->getUserId(), 'isarchived' => ($isArchive ? 'Y' : 'N')]
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
        
               $columns = ['usermessageid', 'senderid', 'userid', 'typeid', 'title', 'content', 'senttime', 'isarchived', 'isflagged'];
                
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

            $message['from'] = $message['name'];
            
            return $message;
        } else {
            throw new NotFoundResourceException('Message not found');
        }
    }
}

<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;

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
        $content
    )
    {
        $result = $this->userMessageTable->insert(
            [
                'userid' => $id,
                'typeid' => $type,
                'content' => $content,
            ]
        );
        
        $success = ($result == 1);
        
        $result = [
            'success' => $success,
            'id' => $id,
            'type' => $type,
            'content' => $content,
        ];
        
        return $result;
    }

}

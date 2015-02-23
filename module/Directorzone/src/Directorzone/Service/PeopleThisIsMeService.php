<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class PeopleThisIsMeService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $userWhosWhoTable;
    
    public function __construct(
        TableGateway $userWhosWho
    )
    {
        $this->userWhosWhoTable = $userWhosWho;
    }

    public function switchGrantStatus($requestId)
    {
        $result = $this->userCompanyDirectoryTable->select(
            function (Select $select) use ($requestId) {
                $select->columns(
                    ['granted']
                )
                ->where(
                    ['usercompanyid' => $requestId]
                );
            }
        )->toArray();
        
        $row = $result[0];
        $grantedStatus = $row['granted'] == 'Y' ? 'N' : 'Y';
        
        $status = $this->userCompanyDirectoryTable->update(
            ['granted' => $grantedStatus],
            ['usercompanyid' => $requestId]
        );

        return $grantedStatus;
    }
    
    public function getUserWhosWhoId(
        $userId,
        $whosWhoId
    )
    {
        return 0;    
    }
    
    public function userIsOwner($userId)
    {
        return false;
    }
    
}

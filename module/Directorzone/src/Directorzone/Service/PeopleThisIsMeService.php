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
        $result = $this->userWhosWhoTable->select(
            function (Select $select) use ($requestId) {
                $select->columns(
                    ['isapproved']
                )
                ->where(
                    ['userwhoswhoid' => $requestId]
                );
            }
        )->toArray();
        
        $row = $result[0];
        $grantedStatus = $row['isapproved'] == 'Y' ? 'N' : 'Y';
        
        $status = $this->userWhosWhoTable->update(
            ['isapproved' => $grantedStatus],
            ['userwhoswhoid' => $requestId]
        );

        return $grantedStatus;
    }
    
    public function getThisIsMeClaims($start, $end = 0, $order = 1)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
    
        if (abs($order) < 1 || abs($order) > 5) {
            $order = 1;
        }
    
        $rows = $this->userWhosWhoTable->select(
            function (Select $select) use ($start, $end, $order) {
    
                $sortColumns = ['u_username', 'u_surname', 'u_email', 'ww_surname', 'u_aboutme', 'isapproved'];
    
                $select->columns(
                    ['userwhoswhoid', 'isapproved', 'aboutme']
                )
                ->join(
                    'user',
                    'user.userid = userwhoswho.userid',
                    ['u_username' => 'name', 'u_email' => 'email', 'u_surname' => 'surname', 'u_forenames' => 'forenames'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'whoswho',
                    'whoswho.whoswhoid = userwhoswho.whoswhoid',
                    ['ww_surname' => 'surname', 'ww_forenames' => 'forename'],
                    Select::JOIN_LEFT
                )
                ->offset($start - 1)
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'))
                ->limit(1 + ($end - $start));
            }
        )->toArray();
    
        $results = [];
    
        foreach ($rows as $row) {
            $results[] = [
                'internalId' => $row['userwhoswhoid'],
                'username' => $row['u_username'],
                'fullname' => $row['u_surname'] . ', ' . $row['u_forenames'],
                'email' => $row['u_email'],
                'whoswhoname' => $row['ww_surname'] . ', ' . $row['ww_forenames'],
                'aboutme' => $row['aboutme'],
                'granted' => $row['isapproved']
            ];
        }
    
        return ['results' => $results];
    
    }
    
    public function getUserWhosWhoId(
        $userId,
        $whosWhoId
    )
    {
        $resultSet = $this->userWhosWhoTable->select(
            function (Select $select) use ($userId, $whosWhoId) {
                $select->columns(['userwhoswhoid'])->where(['userid' => $userId, 'whoswhoid' => $whosWhoId]);
            }
        )->toArray();
        
        if (count($resultSet) > 0) {
            return $resultSet[0]['userwhoswhoid'];
        }
        
        return 0;    
    }
    
    public function userIsOwner($whosWhoId)
    {
        return false;
    }
    
    public function hasOwner($whosWhoId)
    {
        return false;
    }
}

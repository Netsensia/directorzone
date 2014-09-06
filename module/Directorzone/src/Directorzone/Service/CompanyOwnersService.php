<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class CompanyOwnersService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $userCompanyDirectoryTable;
    
    public function __construct(
        TableGateway $userCompany
    )
    {
        $this->userCompanyDirectoryTable = $userCompany;
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
    
    public function getCompanyOwners($start, $end = 0, $order = 1)
    {
        if ($end == 0) {
            $end = $start;
            $start = 1;
        }
        
        if (abs($order) < 1 || abs($order) > 5) {
            $order = 1;
        }
        
        $rowset = $this->userCompanyDirectoryTable->select(
            function (Select $select) use ($start, $end, $order) {
        
                $sortColumns = ['companyname', 'username', 'requesttime', 'relationshiptext', 'granted'];

                $select->columns(
                    ['usercompanyid', 'userid', 'companydirectoryid', 'relationshiptext', 'granted', 'requesttime'] 
                )
                ->join(
                    'companydirectory',
                    'companydirectory.companydirectoryid = usercompany.companydirectoryid',
                    ['companyname' => 'name'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'user',
                    'user.userid = usercompany.userid',
                    ['username' => 'name'],
                    Select::JOIN_LEFT
                )
                ->offset($start - 1)
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'))
                ->limit(1 + ($end - $start));
            }
        );
        
        $rows = $rowset->toArray();
        $results = [];
        
        foreach ($rows as $row) {
            $results[] = [
                'internalId' => $row['usercompanyid'],
                'companyname' => $row['companyname'],
                'username' => $row['username'],
                'requesttime' => $row['requesttime'],
                'granted' => $row['granted'],
                'text' => $row['relationshiptext'],
            ];
        }
        
        return ['results' => $results];

    }
    
    public function getUserCompanyId()
    {
        return 0;
    }
    
    public function getOwnershipRole(
        $companyDirectoryId,
        $userId
    )
    {
        return false;
    }
}

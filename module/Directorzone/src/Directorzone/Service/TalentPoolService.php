<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class TalentPoolService extends NetsensiaService
{
    const PUBLISHED_YES = 1;
    const PUBLISHED_NO = 2;
    
    /**
     * @var TableGateway
     */
    private $talentPoolDirectoryTable;
    private $userTargetRole;
    
    public function __construct(
        TableGateway $talentPoolDirectory,
        TableGateway $userTargetRole
    )
    {
        $this->talentPoolDirectoryTable = $talentPoolDirectory;
        $this->userTargetRoleTable = $userTargetRole;
        $this->setPrimaryTable($talentPoolDirectory);
    }

    public function getTalentPoolList($start, $end, $order)
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) use ($start, $end, $order) {
                $columns = ['userid', 'talentpoolsummary', 'createddate'];
                
                $sortColumns = ['talentpoolsummary', 'createddate'];
                
                $select->columns(
                    $columns    
                )
                ->where(['talentpoolpublishstatusid' => self::PUBLISHED_YES])
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );
        
        $people = [
            'results' => [],
        ];
        
        $results = $rowset->toArray();
        
        foreach ($results as $result) {
        
            $userId = $result['userid'];
            
            $footprint = $this->getFootprint($userId);
            $targetRoles = $this->userTargetRoleTable->select(
                function (Select $select) use ($userId) {
                    $select->columns(['titlesummary'])
                    ->where(['userid' => $userId]);
                }
            )->toArray();            
            
            foreach ($targetRoles as $targetRole) {
                if (trim($targetRole['titlesummary']) != '') {
                    $people['results'][] = array_merge([
                            'internalId' => $result['userid'],
                            'footprint' => $footprint . ', ' . $targetRole['titlesummary']
                        ],
                        $result
                    );
                }
            }
        }
        
        return $people;
    }
        
    public function getTalentPoolDetails($talentPoolDirectoryId)
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) use ($talentPoolDirectoryId) {
                $select->where(
                    [
                        'userid' => $talentPoolDirectoryId
                    ]
                );
            }
        );
    
        if ($rowset->count() == 0) {
            throw new NotFoundResourceException('Person not found in directory');
        }
    
        $peopleDetails = $rowset->current()->getArrayCopy();
        $peopleDetails['footprint'] = $this->getFootprint(
            $talentPoolDirectoryId
        );
    
        return $peopleDetails;
    
    }
    
    public function count()
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
    
        return $rowset->current()['count'];
    }
    
    public function getFootprint($userId)
    {
        $jobArea = $this->getResolvedProperty($userId, 'jobarea');
        $profession = $this->getResolvedProperty($userId, 'profession');
        
        return $profession . ', ' . $jobArea;
    }
}

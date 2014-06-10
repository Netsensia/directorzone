<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class TalentPoolService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $talentPoolDirectoryTable;
    
    public function __construct(
        TableGateway $talentPoolDirectory
    ) {
        $this->talentPoolDirectoryTable = $talentPoolDirectory;
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
        
            $people['results'][] = [
                'internalId' => $result['userid'],
                'anonymousSummary' => $result['talentpoolsummary'],
                'joinedDate' => $result['createddate']
            ];
        }
        
        return $people;
    }
        
    public function getTalentPoolDetails($talentPoolDirectoryId)
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) use ($talentPoolDirectoryId) {
                $select->where(
                    [
                        'talentpoolid' => $talentPoolDirectoryId
                    ]
                );
            }
        );
    
        if ($rowset->count() == 0) {
            throw new NotFoundResourceException('Person not found in directory');
        }
    
        $peopleDetails = $rowset->current()->getArrayCopy();
    
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
}
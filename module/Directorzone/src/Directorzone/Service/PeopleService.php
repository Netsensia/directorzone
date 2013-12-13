<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class PeopleService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $peopleDirectoryTable;
    
    public function __construct(
        TableGateway $peopleDirectory
    ) {
        $this->peopleDirectoryTable = $peopleDirectory;
    }

    public function getDirectoryPeople($start, $end)
    {
        $rowset = $this->peopleDirectoryTable->select(
            function (Select $select) use ($start, $end) {
                $select->where(
                    ['appointmentstatus' => 'CURRENT']
                )
                ->columns(
                    ['officernumber', 'dob', 'appointmenttype', 'companyreference', 'forename', 'surname']
                )
                ->join(
                    'companydirectory',
                    'companydirectory.reference = companyofficer.companyreference',
                    ['name'],
                    'left'
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('officernumber ASC');
            }
        );
    
        $people = [
            'results' => [],
        ];
        
        $results = $rowset->toArray();
        
        foreach ($results as $result) {
        
            switch ($result['appointmenttype']) {
                case 'DIR': $type = 'Director';
                    break;
                case 'SEC': $type = 'Secretary';
                    break;
                case 'NOMDIR': $type = 'Nominee Director';
                    break;
                case 'NOMSEC': $type = 'Nominee Secretary';
                    break;
                default: $type = $result['appointmenttype'];
                    break;
            }
            
            $people['results'][] = [
                'officernumber' => $result['officernumber'],
                'number' => $result['companyreference'],
                'appointmenttype' => $type,
                'companyname' => $result['name'],
                'dob' => $result['dob'],
                'name' => $result['forename'] . ' ' . $result['surname']
            ];
        }
        
        return $people;
    }
}

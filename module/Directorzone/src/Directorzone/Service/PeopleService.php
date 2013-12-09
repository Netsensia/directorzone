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
                    ['officernumber', 'companyreference', 'forename', 'surname']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('officernumber ASC');
            }
        );
    
        return $rowset->toArray();
    }
}

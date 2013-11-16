<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class CompanyService extends NetsensiaService
{
    private $dbAdapter;
    
    public function __construct(
        Adapter $adapter
    ) {
        $this->dbAdapter = $adapter;    
    }
    
    private function count($table)
    {
        $tableGateway = new TableGateway($table, $this->dbAdapter);
        
        $rowset = $tableGateway->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
        
        foreach ($rowset as $row) {
            $count = number_format($row['count']);
        }
        
        return $count;
    }
    
    public function getCompaniesHouseCount()
    {
        return $this->count('company');    
    }
    
    public function getLiveCount()
    {
        return $this->count('companydirectory');
    }
    
    public function getStatusCount($table, $status)
    {
        $tableGateway = new TableGateway($table, $this->dbAdapter);
        
        $rowset = $tableGateway->select(
            function (Select $select) use ($status) {
                $select->where(
                            ['recordstatus' => $status]
                         )
                       ->columns(
                            ['count' => new Expression('COUNT(*)')]
                         );
            }
        );
        
        foreach ($rowset as $row) {
            $count = number_format($row['count']);
        }
        
        return $count;    
    }
    
    public function getPendingCount()
    {
        return $this->getStatusCount('companyupload', 'P');
    }
    
    public function getUnmatchedCount()
    {
        return $this->getStatusCount('companyupload', 'U');
    }
    
    public function getUnprocessedCount()
    {
        return $this->getStatusCount('companyupload', 'W');
    }
    
    public function getConflictsCount()
    {
        return $this->getStatusCount('companyupload', 'C');
    }
    
    public function getRemovedCount()
    {
        return $this->getStatusCount('company', 'R');
    }
    
    public function isCompanyNumberTaken($companyNumber)
    {
        $sql =
            "SELECT companyid " .
            "FROM company " .
            "WHERE number = :number";
    
        $query = $this->getConnection()->prepare($sql);
    
        $query->execute(
            array(
                ':number' => $companyNumber,
            )
        );
    
        return ($query->rowCount() == 1);
    }
}

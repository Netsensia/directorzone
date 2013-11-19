<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class CompanyService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $companyUploadTable;
    
    /**
     * @var TableGateway
     */
    private $companiesHouseTable;
    
    /**
     * @var TableGateway
     */
    private $companyDirectoryTable;
    
    public function __construct(
        TableGateway $companyUpload,
        TableGateway $companiesHouse,
        TableGateway $companyDirectory
    ) {
        $this->companyUploadTable = $companyUpload;
        $this->companiesHouseTable = $companiesHouse;
        $this->companyDirectoryTable = $companyDirectory; 
    }
    
    public function getCompaniesHouseCount()
    {
        $rowset = $this->companiesHouseTable->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
        
        return number_format($rowset->current()['count']);
    }
    
    public function getLiveCount()
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
        
        return $rowset->current()['count'];    
    }
    
    private function getUploadStatusCount($status)
    {        
        $rowset = $this->companyUploadTable->select(
            function (Select $select) use ($status) {
                $select->where(
                            ['recordstatus' => $status]
                         )
                       ->columns(
                            ['count' => new Expression('COUNT(*)')]
                         );
            }
        );
        
        return number_format($rowset->current()['count']);    
    }
    
    private function getDirectoryStatusCount($status)
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) use ($status) {
                $select->where(
                    ['recordstatus' => $status]
                )
                ->columns(
                    ['count' => new Expression('COUNT(*)')]
                );
            }
        );
    
        return number_format($rowset->current()['count']);
    }
    
    private function getUploadedCompaniesFromStatus($status, $start, $end)
    {
        $rowset = $this->companyUploadTable->select(
            function (Select $select) use ($status, $start, $end) {
                $select->where(
                    ['recordstatus' => $status]
                )
                ->columns(
                    ['companynumber', 'name']
                )
                ->offset($start - 1)
                ->limit( 1 + ($end - $start) )
                ->order('name ASC');
            }
        );

        return $rowset->toArray();
    }
    
    public function getPendingCompanies($start, $end)
    {
        return $this->getUploadedCompaniesFromStatus('P', $start, $end);
    }
    
    public function getPendingCount()
    {
        return $this->getUploadStatusCount('P');
    }
    
    public function getUnmatchedCount()
    {
        return $this->getUploadStatusCount('U');
    }
    
    public function getUnprocessedCount()
    {
        return $this->getUploadStatusCount('W');
    }
    
    public function getConflictsCount()
    {
        return $this->getUploadStatusCount('C');
    }
    
    public function getRemovedCount()
    {
        return $this->getDirectoryStatusCount('R');
    }
    
    public function isCompanyNumberTaken($companyNumber)
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) {
                $select->where(
                    ['number' => $companyNumber]
                )
                ->columns(
                    ['count' => new Expression('COUNT(*)')]
                );
            }
        );
    
        return $rowset->current()['count'] == 1;
    }
}

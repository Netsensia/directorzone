<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
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
    
    public function addToCompaniesHouseDirectory(
        $data
    ) {
        $this->companiesHouseTable->insert($data);
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
    
    public function updateUploadStatus(
        $uploadId,
        $companyNumber,
        $companyName,
        $status
    ) {
        $result = $this->companyUploadTable->update(
            [
                'companynumber' => $companyNumber,
                'name' => $companyName,
                'recordstatus' => $status,
            ],
            [
                'companyuploadid' => $uploadId,
            ]
        );
        
        return $result;
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
                    ['companyuploadid', 'companynumber', 'name']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('name ASC');
            }
        );

        return $rowset->toArray();
    }
    
    private function getDirectoryCompaniesFromStatus($status, $start, $end)
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) use ($status, $start, $end) {
                $select->where(
                    ['recordstatus' => $status]
                )
                ->columns(
                    ['reference', 'name']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('name ASC');
            }
        );
    
        return $rowset->toArray();
    }
    
    private function getCompaniesHouseCompaniesFromStatus($status, $start, $end)
    {
        $rowset = $this->companiesHouseTable->select(
            function (Select $select) use ($status, $start, $end) {
                $select->where(
                    ['recordstatus' => $status]
                )
                ->columns(
                    ['number', 'name']
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order('name ASC');
            }
        );
    
        return $rowset->toArray();
    }
    
    public function getPendingCompanies($start, $end)
    {
        return $this->getUploadedCompaniesFromStatus('P', $start, $end);
    }
    
    public function getUnmatchedCompanies($start, $end)
    {
        return $this->getUploadedCompaniesFromStatus('U', $start, $end);
    }
    
    public function getProblemCompanies($start, $end)
    {
        return $this->getUploadedCompaniesFromStatus('O', $start, $end);
    }
    
    public function getRemovedCompanies($start, $end)
    {
        return $this->getDirectoryCompaniesFromStatus('R', $start, $end);
    }
    
    public function getLiveCompanies($start, $end)
    {
        return $this->getDirectoryCompaniesFromStatus('L', $start, $end);
    }
    
    public function getCompaniesHouseCompanies($start, $end)
    {
        return $this->getCompaniesHouseCompaniesFromStatus('N', $start, $end);
    }
    
    public function getPendingCount()
    {
        return $this->getUploadStatusCount('P');
    }
    
    public function getUnmatchedCount()
    {
        return $this->getUploadStatusCount('U');
    }
    
    public function getProblemCount()
    {
        return $this->getUploadStatusCount('O');
    }
    
    public function getRemovedCount()
    {
        return $this->getDirectoryStatusCount('R');
    }
    
    public function getCompanies($type, $start, $end)
    {
        switch ($type) {
            case 'P':
                return $this->getPendingCompanies($start, $end);
            case 'O':
                return $this->getProblemCompanies($start, $end);
            case 'L':
                return $this->getLiveCompanies($start, $end);
            case 'U':
                return $this->getUnmatchedCompanies($start, $end);
            case 'R':
                return $this->getRemovedCompanies($start, $end);
            case 'H':
                return $this->getCompaniesHouseCompanies($start, $end);
            default:
                return $this->getLiveCompanies($start, $end);
        }
    }
    
    public function isCompanyNumberTaken($companyNumber)
    {
        $rowset = $this->companiesHouseTable->select(
            function (Select $select) use ($companyNumber) {
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

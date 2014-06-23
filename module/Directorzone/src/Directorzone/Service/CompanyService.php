<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use NetsensiaCompanies\Request\CompanyAppointmentsRequest;
use NetsensiaCompanies\Model\Person;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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
    
    /**
     * @var TableGateway
     */
    private $companyOfficersTable;
    
    /**
     * @var TableGateway
     */
    private $companySicCodesTable;
    
    /**
     * @var CompanyAppointmentsRequest
     */
    private $companyAppointmentsRequest;
    
    public function __construct(
        TableGateway $companyUpload,
        TableGateway $companiesHouse,
        TableGateway $companyDirectory,
        TableGateway $companySicCode,
        TableGateway $companyOfficers,
        CompanyAppointmentsRequest $companyAppointmentsRequest
    )
    {
        $this->companyUploadTable = $companyUpload;
        $this->companiesHouseTable = $companiesHouse;
        $this->companyDirectoryTable = $companyDirectory;
        $this->companySicCodeTable = $companySicCode;
        $this->companyOfficersTable = $companyOfficers;
        $this->companyAppointmentsRequest = $companyAppointmentsRequest;
    }

    public function deleteCompanyFromCompanyDirectory($companyDirectoryId)
    {
        $this->companyDirectoryTable->delete(['companydirectoryid' => $companyDirectoryId]);
    }
    
    public function addToCompaniesHouseDirectory(
        $data
    )
    {
        $sicCodes = $data['siccodes'];
        unset($data['siccodes']);
        
        $this->companiesHouseTable->insert(
            $data
        );

        $companyNumber = $data['number'];
        
        foreach ($sicCodes as $sicCode) {
            $data = [
                'siccode' => $sicCode,
                'companynumber' => $companyNumber
            ];
            $this->companySicCodeTable->insert(
                $data
            );
        }
    }
    
    public function updateCompaniesHouseDirectory(
        $data
    )
    {
        $companyNumber = $data['number'];
        unset($data['number']);

        $sicCodes = $data['siccodes'];
        unset($data['siccodes']);
        
        $this->companiesHouseTable->update(
            $data,
            ['number' => $companyNumber]
        );
        
        $result = $this->companySicCodeTable->delete(
            [
                'companynumber' => $companyNumber,
            ]
        );
        
        foreach ($sicCodes as $sicCode) {
            $data = [
                'siccode' => $sicCode,
                'companynumber' => $companyNumber
            ];
            $this->companySicCodeTable->insert(
                $data
            );
        }
    }
    
    public function getUserCompanyId()
    {
        return 0;
    }
    
    public function getCompanyDetails($companyDirectoryId)
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) use ($companyDirectoryId) {
                $select->where(
                    [
                    'companydirectoryid' => $companyDirectoryId
                    ]
                )
                ->join(
                    'companieshouse',
                    'companydirectory.reference = companieshouse.number',
                    Select::SQL_STAR,
                    Select::JOIN_LEFT
                );
            }
        );
                
        if ($rowset->count() == 0) {
            throw new NotFoundResourceException('Company not found in directory');
        }
    
        $companyDetails = $rowset->current()->getArrayCopy();
        
        $rowset = $this->companyOfficersTable->select(
            function (Select $select) use ($companyDetails) {
                $select->where(
                    [
                        'companyreference' => $companyDetails['reference'],
                        'appointmentstatus' => 'CURRENT',
                    ]
                );
            }
        );
        
        if (count($rowset) == 0) {
            try {
                $this->addOfficers(
                    $companyDetails['reference'],
                    $companyDetails['name']
                );
            } catch (\Exception $e) {
                //
            }
            
            $rowset = $this->companyOfficersTable->select(
                function (Select $select) use ($companyDetails) {
                    $select->where(
                        [
                        'companyreference' => $companyDetails['reference'],
                        'appointmentstatus' => 'CURRENT',
                        ]
                    );
                }
            );
        }
        
        foreach ($rowset as $row) {
        	$companyDetails['officers'][] = $row->getArrayCopy();
        }
        
        $companyDetails['relatedCompanies'] = [];
        
        return $companyDetails;
        
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
    
    public function updateCanUseFeedCache(
        $companyDirectoryId,
        $canUseFeedCache
    )
    {
        $result = $this->companyDirectoryTable->update(
            [
                'canusefeedcache' => ($canUseFeedCache ? 'Y' : 'N'),
            ],
            [
                'companydirectoryid' => $companyDirectoryId,
            ]
        );

        return $result;
    }
    
    public function deleteUploaded(
        $type,
        $uploadId
    ) {
        switch ($type) {
        	case 'U':
            $result = $this->companyUploadTable->delete(
                [
                    'companyuploadid' => $uploadId,
                ]
            );
            break;
            case 'P':
                $result = $this->companyUploadTable->delete(
                [
                    'companyuploadid' => $uploadId,
                ]
                );
            break;
            case 'L':
                $result = $this->companyDirectoryTable->delete(
                [
                    'companydirectoryid' => $uploadId,
                ]
                );
            break;
        }
    
        return $result;
    }
    
    public function makeLive(
        $uploadId
    )
    {        
        $rowset = $this->companyUploadTable->select(
            function (Select $select) use ($uploadId) {
                $select->where(
                    ['companyuploadid' => $uploadId]
                );
            }
        );
        
        $array = $rowset->toArray();
        
        if (count($array) != 1) {
            throw new \Exception(
                'Could not find company to make live'
            );
        }
        
        $companyRow = $array[0];
        
        $result = $this->companyDirectoryTable->insert(
            [
                'reference' => $companyRow['companynumber'],
                'name' => $companyRow['name'],
                'recordstatus' => 'L',
            ]
        );
        
        $result = $this->companyUploadTable->delete(
            [
                'companyuploadid' => $uploadId,
            ]
        );
        
        $result = $this->addOfficers(
            $companyRow['companynumber'],
            $companyRow['name']
        );
        
        return $result;
    }
    
    public function addOfficers(
        $companyNumber,
        $companyName
    )
    {
        $companyAppointmentsModel =
            $this->companyAppointmentsRequest->loadCompanyAppointments(
                $companyNumber,
                $companyName,
                true,
                true
            );
        
        $appointments = $companyAppointmentsModel->getAppointments();
        
        $result = $this->companyOfficersTable->delete(
            [
                'companyreference' => $companyNumber,
            ]
        );
        
        foreach ($appointments as $appointment) {
        
            $appointment instanceof Person;
            $address = $appointment->getAddress();
            $data = [
                'companyreference' => $companyNumber,
                'officernumber' => $appointment->getId(),
                'forename' => $appointment->getForename(),
                'surname' => $appointment->getSurname(),
                'dob' => $appointment->getDob(),
                'nationality' => $appointment->getNationality(),
                'numappointments' => $appointment->getNumAppointments(),
                'appointmenttype' => $appointment->getAppointmentType(),
                'appointmentstatus' => $appointment->getAppointmentStatus(),
                'appointmentdate' => $appointment->getAppointmentDate(),
                'honours' => $appointment->getHonours(),
            ];
        
            $result = $this->companyOfficersTable->insert(
                $data
            );
        }

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
    
    private function getUploadedCompaniesFromStatus($status, $start, $end, $order)
    {

        $rowset = $this->companyUploadTable->select(
            function (Select $select) use ($status, $start, $end, $order) {
                $columns = ['companyuploadid', 'companynumber', 'name', 'createdtime'];
                $sortColumns = ['name', 'name', 'name', 'name', 'name', 'createdtime'];
                
                $select->where(
                    ['recordstatus' => $status]
                )
                ->columns(
                    $columns
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );

        return $rowset->toArray();
    }
    
    private function getDirectoryCompaniesFromStatus($status, $start, $end, $dzType = 3, $order)
    {
        $rowset = $this->companyDirectoryTable->select(
            function (Select $select) use ($status, $start, $end, $dzType, $order) {
                $columns = ['reference', 'name', 'ceo', 'sectors', 'turnoverid', 'createdtime', 'companydirectoryid'];

                $select->where(
                    [
                    'recordstatus' => $status,
                    'companytypeid' => ($dzType == 3 ? [1,2,3] : [$dzType, 3])
                    ]
                )
                ->columns(
                    $columns   
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($columns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );
    
        return $rowset->toArray();
    }
    
    private function getCompaniesHouseCompaniesFromStatus($status, $start, $end, $order)
    {
        $rowset = $this->companiesHouseTable->select(
            function (Select $select) use ($status, $start, $end, $order) {
                $columns = ['number', 'name', 'createdtime'];
                $sortColumns = ['name', 'name', 'name', 'name', 'name', 'createdtime'];
                $select->columns(
                    $columns
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );
    
        return $rowset->toArray();
    }
    
    public function getPendingCompanies($start, $end, $order)
    {
        return $this->getUploadedCompaniesFromStatus('P', $start, $end, $order);
    }
    
    public function getUploadedCompanies($start, $end, $order)
    {
        return $this->getUploadedCompaniesFromStatus('U', $start, $end, $order);
    }
    
    public function getProblemCompanies($start, $end, $order)
    {
        return $this->getUploadedCompaniesFromStatus('O', $start, $end, $order);
    }
    
    public function getRemovedCompanies($start, $end, $order)
    {
        return $this->getDirectoryCompaniesFromStatus('R', $start, $end, $order);
    }
    
    public function getLiveCompanies($start, $end, $dzType = 3, $order)
    {
        return $this->getDirectoryCompaniesFromStatus('L', $start, $end, $dzType, $order);
    }
    
    public function getCompaniesHouseCompanies($start, $end, $order)
    {
        return $this->getCompaniesHouseCompaniesFromStatus('N', $start, $end, $order);
    }
    
    public function getPendingCount()
    {
        return $this->getUploadStatusCount('P');
    }
    
    public function getUploadedCount()
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
    
    public function getOwnershipRole(
        $companyDirectoryId,
        $userId
    )
    {
        return false;
    }
    
    public function setOwnedBy(
        $companyDirectoryId,
        $userId,
        $roleId
    )
    {
        return true;
    }
    
    public function removeOwnedBy(
        $companyDirectoryId,
        $userId
    )
    {
        return true;
    }
    
    public function getCompanies($type, $start, $end, $order)
    {               
        switch ($type) {
            case 'P':
                return $this->getPendingCompanies($start, $end, $order);
            case 'O':
                return $this->getProblemCompanies($start, $end, $order);
            case 'U':
                return $this->getUploadedCompanies($start, $end, $order);
            case 'R':
                return $this->getRemovedCompanies($start, $end, $order);
            case 'H':
                return $this->getCompaniesHouseCompanies($start, $end, $order);
            case 'L':
                return $this->getLiveCompanies($start, $end, 1, $order);
            case 'S':
                return $this->getLiveCompanies($start, $end, 2, $order);
            case 'B':
            default:
                return $this->getLiveCompanies($start, $end, 3, $order);
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
    
    public function getCompaniesHouseList(
        $companyNumberHigherThan,
        $numberOfResults
    )
    {
        $rowset = $this->companiesHouseTable->select(
            function (Select $select) use (
                $companyNumberHigherThan,
                $numberOfResults
            ) {
                $select->order('companyid ASC')
                       ->limit($numberOfResults)
                       ->where->greaterThan(
                           'companyid',
                           $companyNumberHigherThan
                       );
            }
        );
    
        return $rowset;
    }
}

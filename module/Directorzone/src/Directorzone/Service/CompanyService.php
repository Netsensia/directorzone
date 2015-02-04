<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use NetsensiaCompanies\Request\CompanyAppointmentsRequest;
use NetsensiaCompanies\Model\Person;
use Netsensia\Exception\NotFoundResourceException;

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
   
    private $companyKeywordTable;
    
    private $companyPastNameTable;
    
    private $companyPatentTable;
    
    private $companySectorTable;
   
    private $userCompanyTable;
    
    private $companyImportMarketTable;
    
    private $companyExportMarketTable;
    
    private $whosWhoService;
    
    /**
     * @var TableGateway
     */
    private $companyRelationship;
    
    /**
     * @var CompanyAppointmentsRequest
     */
    private $companyAppointmentsRequest;
    
    private $addressService;
    
    public function __construct(
        TableGateway $companyUpload,
        TableGateway $companiesHouse,
        TableGateway $companyDirectory,
        TableGateway $companySicCode,
        TableGateway $companySector,
        TableGateway $companyOfficers,
        TableGateway $companyRelationship,
        TableGateway $companyPastName,
        TableGateway $companyKeywords,
        TableGateway $companyPatent,
        TableGateway $companyImportMarket,
        TableGateway $companyExportMarket,
        TableGateway $userCompany,
        WhosWhoService $whosWhoService,
        AddressService $addressService,
        CompanyAppointmentsRequest $companyAppointmentsRequest
    )
    {
        $this->companyUploadTable = $companyUpload;
        $this->companiesHouseTable = $companiesHouse;
        $this->companyDirectoryTable = $companyDirectory;
        $this->companySicCodeTable = $companySicCode;
        $this->companySectorTable = $companySector;
        $this->companyOfficersTable = $companyOfficers;
        $this->companyRelationship = $companyRelationship;
        $this->companyPastNameTable = $companyPastName;
        $this->companyKeywordTable = $companyKeywords;
        $this->companyPatentTable = $companyPatent;
        $this->companyImportMarketTable = $companyImportMarket;
        $this->companyExportMarketTable = $companyExportMarket;
        $this->userCompany = $userCompany;
        $this->addressService = $addressService;
        $this->whosWhoService = $whosWhoService;
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
                )
                ->join(
                    'companystatus',
                    'companydirectory.companystatusid = companystatus.companystatusid',
                    ['companystatus'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'companyphase',
                    'companydirectory.companyphaseid = companyphase.companyphaseid',
                    ['companyphase'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'companyprofit',
                    'companydirectory.companyprofitid = companyprofit.companyprofitid',
                    ['companyprofit'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'companyranking',
                    'companydirectory.companyrankingid = companyranking.companyrankingid',
                    ['companyranking'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'investmentstatus',
                    'companydirectory.investmentstatusid = investmentstatus.investmentstatusid',
                    ['investmentstatus'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'month',
                    'companydirectory.financialyearendid = month.monthid',
                    ['financialyearend' => 'month'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'exchange',
                    'companydirectory.exchangeid = exchange.exchangeid',
                    ['exchange'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'companycategory',
                    'companydirectory.companycategoryid = companycategory.companycategoryid',
                    ['companycategory'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'country',
                    'companydirectory.countryoforiginid = country.countryid',
                    ['countryoforigin' => 'country'],
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
                        ]
                    );
                }
            );
        }
        
        $companyDetails['officers'] = [];
        $companyDetails['pastofficers'] = [];
        
        foreach ($rowset as $row) {
            if ($row['appointmentstatus'] == 'CURRENT') {
        	   $companyDetails['officers'][] = $row->getArrayCopy();
            } else {
               $companyDetails['pastofficers'][] = $row->getArrayCopy();
            }
        }
        
        $companyDetails['pastnames'] = $this->getMultipleTextValues(
            $this->companyPastNameTable,
            $companyDetails['companydirectoryid']
        );
        
        $companyDetails['keywords'] = $this->getMultipleTextValues(
            $this->companyKeywordTable,
            $companyDetails['companydirectoryid']
        );
        
        $companyDetails['patents'] = $this->getMultipleTextValues(
            $this->companyPatentTable,
            $companyDetails['companydirectoryid']
        );
        
        $relatedCompanies = [];
        
        $rowset = $this->companyRelationship->select(
            function (Select $select) use ($companyDetails) {
                $select->where(
                    [
                        'companyrelationship.companydirectoryid' => $companyDetails['companydirectoryid'],
                    ]
                )
                ->join(
                    'relationship',
                    'companyrelationship.relationshipid = relationship.relationshipid',
                    ['relationship']
                )
                ->join(
                    'companydirectory',
                    'companydirectory.companydirectoryid = companyrelationship.relatedcompanyid',
                    ['relatedcompanyname' => 'name'],
                    Select::JOIN_LEFT
                ); 
            }
        )->toArray();
        
        foreach ($rowset as $row) {
            $relationshipCompanyDetails = $this->companyDirectoryTable->select(
                function (Select $select) use ($row, $companyDetails) {
                    $select->where(
                        [
                            'companydirectory.name' => $row['relatedcompany'],
                        ]
                    ); 
                }
            )->toArray();
            
            if (count($relationshipCompanyDetails) > 0) {
                $row['relatedcompanyid'] = $relationshipCompanyDetails[0]['companydirectoryid'];
            } else {
                $row['relatedcompanyid'] = 0;
            }
            $relatedCompanies[] = $row;
        }
        
        $companyDetails['relatedCompanies'] = $relatedCompanies;
        
        $companyDetails['sectors'] = $this->companySectorTable->select(
            function (Select $select) use ($companyDetails) {
                $select->where(
                    [
                        'companysector.companydirectoryid' => $companyDetails['companydirectoryid'],
                    ]
                )
                ->join(
                    'sector',
                    'companysector.sectorid = sector.sectorid',
                    ['sectorid', 'sector']
                );
            }
        )->toArray();
        
        $companyDetails['importmarkets'] = $this->companyImportMarketTable->select(
            function (Select $select) use ($companyDetails) {
                $select->where(
                    [
                        'companyimportmarket.companydirectoryid' => $companyDetails['companydirectoryid'],
                    ]
                )
                ->join(
                    'geography',
                    'companyimportmarket.geographyid = geography.geographyid',
                    ['geographyid', 'geography']
                );
            }
        )->toArray();
        
        $companyDetails['exportmarkets'] = $this->companyExportMarketTable->select(
            function (Select $select) use ($companyDetails) {
                $select->where(
                    [
                        'companyexportmarket.companydirectoryid' => $companyDetails['companydirectoryid'],
                    ]
                )
                ->join(
                    'geography',
                    'companyexportmarket.geographyid = geography.geographyid',
                    ['geographyid', 'geography']
                );
            }
        )->toArray();
        
        if ($companyDetails['closuredate'] == '0000-00-00') $companyDetails['closuredate'] = '';
        if ($companyDetails['incorporationdate'] == '0000-00-00') $companyDetails['incorporationdate'] = '';
        if ($companyDetails['employeecountdate'] == '0000-00-00') $companyDetails['employeecountdate'] = '';
        if ($companyDetails['revenuedate'] == '0000-00-00') $companyDetails['revenuedate'] = '';
        if ($companyDetails['revenuegrowthdate'] == '0000-00-00') $companyDetails['revenuegrowthdate'] = '';
        
        $companyDetails['revenuegrowthrange'] = $this->getGrowthRange($companyDetails['actualrevenuegrowth']);
        $companyDetails['revenuerange'] = $this->getRevenueRange($companyDetails['actualrevenue']);
        $companyDetails['employeerange'] = $this->getEmployeeRange($companyDetails['actualemployees']);
        
        if (empty($companyDetails['registeredaddressid'])) {
            $registeredAddressId = $this->addressService->addAddress([
                'address1' =>  $companyDetails['addressline1'],
                'address2' =>  $companyDetails['addressline2'],
                'address3' =>  $companyDetails['addressline3'],
                'town' =>  $companyDetails['addressline4'],
                'postcode' =>  $companyDetails['postcode'],
            ]);
            
            $this->companyDirectoryTable->update(
                ['registeredaddressid' => $registeredAddressId],
                ['companydirectoryid' => $companyDetails['companydirectoryid']]
            );
            
            $companyDetails['registeredaddressid'] = $registeredAddressId;
        }
        
        $companyDetails['registeredaddress'] = $this->addressService->getAddressDetails($companyDetails['registeredaddressid']);
        $companyDetails['tradingaddress'] = $this->addressService->getAddressDetails($companyDetails['tradingaddressid']);

        if (isset($companyDetails['registeredaddress']['postcode']) && trim($companyDetails['registeredaddress']['postcode']) != '') {
            $latLong = $this->getLatLong($companyDetails['registeredaddress']['postcode']);
            $companyDetails['registeredaddress']['lat'] = $latLong['lat'];
            $companyDetails['registeredaddress']['long'] = $latLong['long'];
        }
        
        if (isset($companyDetails['tradingaddress']['postcode']) && trim($companyDetails['tradingaddress']['postcode']) != '') {
            $latLong = $this->getLatLong($companyDetails['tradingaddress']['postcode']);
            $companyDetails['tradingaddress']['lat'] = $latLong['lat'];
            $companyDetails['tradingaddress']['long'] = $latLong['long'];
        }
        
        $companyDetails['isowner'] = $this->companyIsOwnedBy(
            $companyDetails['companydirectoryid'],
            $this->getUserId()
        );
        
        return $companyDetails;
        
    }
    
    private function getLatLong($postcode)
    {
        if (trim($postcode) == '') return;
        
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($postcode) . '&sensor=false';
        $json = json_decode(file_get_contents($url));
        
        return [
            'lat' => $json->results[0]->geometry->location->lat,
            'long' => $json->results[0]->geometry->location->lng
        ];
    }
    
    public function getCompanyDirectoryIdFromName($name)
    {
        $result = $this->companyDirectoryTable->select(
            function (Select $select) use ($name) {
                $select->where(
                    [
                        'companydirectory.name' => $name,
                    ]
                )->
                columns(['companydirectoryid']);
            }
        )->toArray();
        
        if (count($result) > 0) {
            return $result[0]['companydirectoryid'];
        }
        
        return false;
    }
    
    public function getNameFromCompanyDirectoryId($id)
    {
        $result = $this->companyDirectoryTable->select(
            function (Select $select) use ($id) {
                $select->where(
                    [
                        'companydirectoryid' => $id,
                    ]
                )->
                columns(['name']);
            }
        )->toArray();
    
        if (count($result) > 0) {
            return $result[0]['name'];
        }
    
        return false;
    }
    
    public function getOwners($companyDirectoryId)
    {
        $rowset = $this->userCompany->select(
            function (Select $select) use ($companyDirectoryId) {
                $select->where(
                    [
                        'usercompany.companydirectoryid' => $companyDirectoryId,
                    ]
                )
                ->join(
                    'usercompanyrole',
                    'usercompanyrole.usercompanyroleid = usercompany.usercompanyroleid',
                    ['usercompanyrole']
                );
            }
        )->toArray();
        
        $owners = [];
        
        foreach ($rowset as $owner) {
            $owners[] = [
                'userid' => $owner['userid'],
                'roleid' => $owner['usercompanyroleid'],
                'roledesc' => $owner['usercompanyrole']  
            ];
        }
        
        return $owners;
    }
    
    public function companyIsOwnedBy($companyDirectoryId, $userId)
    {
        $owners = $this->getOwners($companyDirectoryId);
        
        $isOwner = false;
        
        foreach ($owners as $owner) {
            if ($owner['userid'] == $userId && $owner['roledesc'] == 'Owner') {
                return true;
            }
        }
        
        return false;
    }
    
    public function getOwnershipRole($companyDirectoryId, $userId)
    {
        $owners = $this->getOwners($companyDirectoryId);
        
        $isOwner = false;
        
        foreach ($owners as $owner) {
            if ($owner['userid'] == $userId) {
                return $owner['roledesc'];
            }
        }
        
        return null;
    }
    
    private function getMultipleTextValues(TableGateway $tableGateway, $companyDirectoryId)
    {
        $tableName = $tableGateway->getTable();
        
        return $tableGateway->select(
            function (Select $select) use ($tableName, $companyDirectoryId) {
                $select->where(
                    [
                        $tableName . '.companydirectoryid' => $companyDirectoryId,
                    ]
                )
                ->columns([$tableName])
                ->join(
                    'companydirectory',
                    'companydirectory.companydirectoryid = ' . $tableName .  '.companydirectoryid',
                    [],
                    Select::JOIN_LEFT
                );
            }
        )->toArray();
    }
    
    private function getGrowthRange($n)
    {
        if ($n <= 5) {
            return '0-5%';
        }
        
        if ($n <= 10) {
            return '6-10%';
        }
        
        if ($n <= 20) {
            return '11-20%';
        }
        
        if ($n <= 30) {
            return '21-30%';
        }
        
        if ($n <= 50) {
            return '31-50%';
        }
        
        if ($n <= 75) {
            return '51-75%';
        }
        
        if ($n < 100) {
            return '76-100%';
        }
        
        return '100% +';
    }
    
    private function getEmployeeRange($n)
    {
        if ($n <= 4) {
            return '0-4';
        }
        
        if ($n <= 10) {
            return '5-10';
        }
        
        if ($n <= 20) {
            return '11-20';
        }
        
        if ($n <= 50) {
            return '21-50';
        }
        
        return '50+';
    }
    
    private function getRevenueRange($n)
    {
        if ($n == '') {
            return 'Not available/applicable';
        }
        
        if ($n < 0) {
            return 'Pre-revenue';
        }
        
        if ($n <= 100) {
            return 'EUR 0-100k';
        }
        
        if ($n <= 500) {
            return 'EUR 100-500k';
        }
        
        if ($n <= 2000000) {
            return 'EUR 500k - 2m';
        }
        
        if ($n <= 5000000) {
            return 'EUR 2 - 5m';
        }
        
        if ($n <= 20000000) {
            return 'EUR 5 - 20m';
        }
        
        if ($n <= 50000000) {
            return 'EUR 20 - 50m';
        }
        
        if ($n <= 200000000) {
            return 'EUR 50 - 200m';
        }
        
        if ($n <= 1000000000) {
            return 'EUR 200m - 1bn';
        }
        
        return 'EUR 1bn+';
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
        $array = $this->companyUploadTable->select(
            function (Select $select) use ($uploadId) {
                $select->where(
                    ['companyuploadid' => $uploadId]
                )->join('companieshouse', 'companieshouse.number=companyupload.companynumber', [
                    'incorporationdate',
                    'addressline1',
                    'addressline2',
                    'addressline3',
                    'addressline4',
                    'postcode',
                ]);
            }
        )->toArray();
        
        if (count($array) == 0) {
             throw new \Exception(
                 'Could not find company ' . $uploadId . ' to make live'
             );
        }
        
        $companyRow = $array[0];
        
        $registeredAddressId = $this->addressService->addAddress([
            'address1' => $companyRow['addressline1'],
            'address2' => $companyRow['addressline2'],
            'address3' => $companyRow['addressline3'],
            'town' => $companyRow['addressline4'],
            'postcode' => $companyRow['postcode'],
        ]);
        
        $result = $this->companyDirectoryTable->insert(
            [
                'reference' => $companyRow['companynumber'],
                'name' => $companyRow['name'],
                'incorporationdate' => date('Y-m-d', strtotime($companyRow['incorporationdate'])),
                'recordstatus' => 'L',
                'registeredaddressid' => $registeredAddressId,
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
        
            $address = $appointment->getAddress();
            
            $data = [
                'officernumber' => $appointment->getId(),
                'forename' => $appointment->getForename(),
                'surname' => $appointment->getSurname(),
                'dob' => $appointment->getDob(),
                'nationality' => $appointment->getNationality(),
                'numappointments' => $appointment->getNumAppointments(),
                'honours' => $appointment->getHonours(),
            ];
            
            $whosWhoId = $this->whosWhoService->addOfficer($data);
            
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
                'whoswhoid' => $whosWhoId,
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
                $columns = ['reference', 'name', 'ceo', 'sectors', 'turnoverid',  'createdtime', 'companydirectoryid'];
                $sortColumns = ['reference', 'name', 'ceo', 'sectors', 'turnoverid',  'createdtime', 'companydirectoryid', 'exchange', 'town', 'siccode1'];

                $select->where(
                    [
                    'companydirectory.recordstatus' => $status,
                    'companytypeid' => ($dzType == 3 ? [1,2,3] : [$dzType, 3])
                    ]
                )
                ->columns(
                    $columns
                )
                ->join(
                    'exchange',
                    'companydirectory.exchangeid = exchange.exchangeid',
                    ['exchange'],
                    Select::JOIN_LEFT
                )
                ->join(
                    'companieshouse',
                    'companydirectory.reference = companieshouse.number',
                    ['town', 'siccode1'],
                    Select::JOIN_LEFT
                )
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
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
    
    public function getOfficerCompanies(
        $whosWhoId
    )
    {
        $rowset = $this->getServiceLocator()->get('CompanyOfficerTableGateway')->select(
            function (Select $select) use ($whosWhoId) {
                $select
                    ->columns(['companyreference', 'appointmenttype'])
                    ->join(
                        'companydirectory',
                        'companydirectory.reference = companyofficer.companyreference',
                        ['name', 'companydirectoryid'],
                        Select::JOIN_LEFT
                    )
                    ->where(['whoswhoid' => $whosWhoId]);
            }
        )->toArray();
    
        return $rowset;
    }
    
    public function getFootprint($companyDirectoryId)
    {
        $details = $this->getCompanyDetails($companyDirectoryId);
        
        $footprint = '';
        
        if (empty($details['countryoforigin'])) {
            $details['countryoforigin'] = 'unknown country';
        }
        
        if (empty($details['category'])) {
            $details['countryoforigin'] = 'unknown company type';
        }
        
        if (empty($details['companyphase'])) {
            $details['companyphase'] = 'unknown size';
        }
        
        if (empty($details['employeerange'])) {
            $details['employeerange'] = 'unknown';
        }   

        if (empty($details['revenuerange'])) {
            $details['revenuerange'] = 'unknown';
        }
        
        if (empty($details['siccode1'])) {
            $details['siccode1'] = 'unknown';
        }
        
        $footprint .= $details['category'] . ' from ' . $details['countryoforigin'] . '; ';
        $footprint .= $details['companyphase'] . '; ';
        $footprint .= 'Employees: ' . $details['employeerange'] . '; ';
        $footprint .= 'Revenues: ' . $details['revenuerange'] . '; ';
        
        $footprint .= 'Import markets: ';
        
        if (count($details['importmarkets']) > 0) {
            foreach ($details['importmarkets'] as $market) {
                $footprint .= $market['geography'] . ', ';
            }
            $footprint = substr($footprint, 0, strlen($footprint) - 2) . '; ';
        } else {
            $footprint .= 'unknown; ';
        }
        
        $footprint .= 'Export markets: ';
        
        if (count($details['exportmarkets']) > 0) {
            foreach ($details['exportmarkets'] as $market) {
                $footprint .= $market['geography'] . ', ';
            }
            $footprint = substr($footprint, 0, strlen($footprint) - 2) . '; ';
        } else {
            $footprint .= 'unknown; ';
        }
        
        $footprint .= 'Activities: ' . $details['siccode1'];
        
        return $footprint;
    }
    
    public function getCompanyDirectoryId($reference)
    {
        $result = $this->companyDirectoryTable->select(
            ['reference' => $reference]
        )->toArray();
        
        if (count($result) > 1) {
            throw new \Exception('Duplicate company (' . $reference . ') detected');
        }
    
        if (count($result) == 1) {
            return $result[0]['companydirectoryid'];
        }
        
        return false;
    }
    
    public function isCompanyInDirectory($reference)
    {
        $count = $this->companyDirectoryTable->select(
            ['reference' => $reference]
        )->count();
        
        if ($count > 1) {
            throw new \Exception('Duplicate company (' . $reference . ') detected');
        }
        
        return $count > 0;
    }
    
    public function addCompanyToDirectory($companyDetails)
    {
        $result = $this->companyDirectoryTable->insert($companyDetails);
        
        return $this->companyDirectoryTable->getAdapter()->getDriver()->getLastGeneratedValue();
    }
}

<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class WhosWhoService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $whosWhoTable;
    
    private $addressService;
    
    public function __construct(
        TableGateway $whosWho,
        AddressService $addressService
    )
    {
        $this->whosWhoTable = $whosWho;
        $this->addressService = $addressService;
    }

    public function officerExists($officerId)
    {
        $rowset = $this->whosWhoTable->select(
            function (Select $select) use ($officerId) {
                $select->columns(
                    [ 'count' => new Expression('COUNT(*)') ]
                )->where(['officernumber' => $officerId]);
            }
        );
    
        return $rowset->current()['count'] > 0;
    }
    
    public function whosWhoIdFromOfficerId($officerId)
    {
        $rowset = $this->whosWhoTable->select(
            function (Select $select) use ($officerId) {
                $select->columns(
                    [ 'whoswhoid' ]
                )->where(['officernumber' => $officerId]);
            }
        )->toArray();
    
        if (count($rowset) > 0) {
            return $rowset[0]['whoswhoid'];
        }
        
        return null;
    }
    
    public function addOfficer($data)
    {
        $whosWhoId = $this->whosWhoIdFromOfficerId($data['officernumber']);
        
        if ($whosWhoId == null) {
            $result = $this->whosWhoTable->insert(
                $data
            );
            
            $whosWhoId = $this->whosWhoTable->getAdapter()->getDriver()->getLastGeneratedValue();
        }
        
        return $whosWhoId;
    }
    
    public function getWhosWhoList($start, $end, $order)
    {
        $results = $this->whosWhoTable->select(
            function (Select $select) use ($start, $end, $order) {
                $columns = ['whoswhoid', 'forename', 'surname', 'nationality', 'numappointments', 'honours', 'dob', 'officernumber', 'userid', 'createdtime'];
    
                $sortColumns = ['createdtime', 'surname', 'numappointments', 'createdtime', 'createdtime', 'createdtime', 'createdtime'];
    
                $select->columns($columns)
                    ->offset($start - 1)
                    ->limit(1 + ($end - $start))
                    ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        )->toArray();
    
        foreach ($results as $result) {
            $people['results'][] = [
                'internalId' => $result['whoswhoid'],
                'officernumber' => $result['officernumber'],
                'nationality' => $result['nationality'],
                'dob' => $result['dob'],
                'numappointments' => $result['numappointments'],
                'createdTime' => $result['createdtime'],
                'name' => $result['forename'] . ' ' . $result['surname']
            ];
        }
    
        return $people;
    }
    
    public function getWhosWhoDetails($peopleDirectoryId)
    {
        $rowset = $this->whosWhoTable->select(
            function (Select $select) use ($peopleDirectoryId) {
                $select->where(
                    [
                        'whoswhoid' => $peopleDirectoryId
                    ]
                );
            }
        );
    
        if ($rowset->count() == 0) {
            throw new NotFoundResourceException('Person not found in directory');
        }
    
        $peopleDetails = $rowset->current()->getArrayCopy();
    
        $peopleDetails['address'] = $this->addressService->getAddressDetails($peopleDetails['addressid']);
    
        return $peopleDetails;
    
    }
}

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
    
        var_dump($rowset); die;
        if (count($rowset) > 0) {
            return $rowset['officernumber'];
        }
        
        return null;
    }
    
    public function insert($data)
    {
        $result = $this->whosWhoTable->insert(
            $data
        );
        
        return $this->whosWhoTable->getAdapter()->getDriver()->getLastGeneratedValue();
    }
}

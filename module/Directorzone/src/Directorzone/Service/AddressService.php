<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class AddressService extends NetsensiaService
{
    private $addressTable;
    
    public function __construct(
        TableGateway $addressTable 
    )
    {
        $this->setPrimaryTable($addressTable);
        $this->addressTable = $addressTable;
    }
    
    public function getAddressDetails($addressId)
    {
        return $this->addressTable->select(
            function (Select $select) use ($addressId) {
                $select->where(
                    [
                        'address.addressid' => $addressId,
                    ]
                );
            }
        )->toArray();
    }
    
    public function addAddress($addressDetails)
    {
        $this->addressTable->insert(
            $addressDetails
        );
        
        return $this->addressTable->getLastInsertValue();
    }
}

<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class AddressService extends NetsensiaService
{
    private $addressTable;
    private $countryTable;
    
    public function __construct(
        TableGateway $addressTable,
        TableGateway $countryTable
    )
    {
        $this->setPrimaryTable($addressTable);
        $this->addressTable = $addressTable;
        $this->countryTable = $countryTable;
    }
    
    public function getAddressDetails($addressId)
    {
        $address = $this->addressTable->select(
            function (Select $select) use ($addressId) {
                $select->where(
                    [
                        'address.addressid' => $addressId,
                    ]
                );
            }
        )->toArray();
        
        if (is_array($address) && count($address) > 0) {
            $address = $address[0];
        } else {
            return null;
        }
        
        if (isset($address['countryid']) && $address['countryid'] != '') {
            $address['country'] = $this->getCountryFromId($address['countryid']);
        } else {
            $address['country'] = '';
        }
        
        return $address;
    }
    
    private function getCountryFromId($countryId)
    {
        $results = $this->countryTable->select(['countryid' => $countryId]);
        if (is_array($results) && isset($results['country'])) {
            return $results['country'];
        } else {
            return null;
        }
    }
    
    public function addAddress($addressDetails)
    {
        $this->addressTable->insert(
            $addressDetails
        );
        
        return $this->addressTable->getLastInsertValue();
    }
}

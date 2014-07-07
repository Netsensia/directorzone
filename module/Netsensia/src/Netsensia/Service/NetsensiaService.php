<?php
namespace Netsensia\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Netsensia\Provider\ProvidesServiceLocator;
use Netsensia\Provider\ProvidesConnection;
use Netsensia\Provider\ProvidesUserInfo;
use Netsensia\Provider\ProvidesModels;
use Netsensia\Provider\ProvidesTranslator;
use Netsensia\Provider\ProvidesEmail;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class NetsensiaService implements ServiceLocatorAwareInterface 
{
    use ProvidesServiceLocator, 
        ProvidesConnection, 
        ProvidesUserInfo,
        ProvidesEmail,
        ProvidesTranslator,
        ProvidesModels;
    
    private $primaryTable;
    
    protected function setPrimaryTable(TableGateway $tableGateway)
    {
        $this->primaryTable = $tableGateway;
    }
    
    public function getResolvedProperty(
        $id,
        $property
    )
    {
        $rowset = $this->primaryTable->select(
            function (Select $select) use ($id, $property) {
                $select->columns(
                    [$property . 'id']
                )
                ->join(
                    $property,
                    $this->primaryTable->getTable() . '.' . $property . 'id = ' . $property . '.' . $property . 'id',
                    $property
                )
                ->where([$this->primaryTable->getTable() . 'id' => $id]);
            }
        );
        
        $rows = $rowset->toArray();
        
        if (count($rows) != 1) {
            throw new \Exception('Expected one row, found ' . count($rows));
        }
        
        return $rows[0][$property];
    }
}

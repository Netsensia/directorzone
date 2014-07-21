<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class FilterService extends NetsensiaService
{
    private $geographyTable;
    private $sectorTable;
    private $jobAreaTable;
    private $keyEventTable;

    public function __construct(
        TableGateway $geographyTable,
        TableGateway $sectorTable,
        TableGateway $jobAreaTable,
        TableGateway $keyEventTable
    )
    {
        $this->geographyTable = $geographyTable;
        $this->sectorTable = $sectorTable;
        $this->jobAreaTable = $jobAreaTable;
        $this->keyEventTable = $keyEventTable;
    }

    public function getFilterJson()
    {
        $filter = [
        'Sector' => [
        'parents' => $this->getRows('SectorParent'),
        'children' => $this->getRows('Sector'),
        ],
        'KeyEvent' => [
        'children' => $this->getRows('KeyEvent'),
        ],
        'JobArea' => [
        'children' => $this->getRows('JobArea'),
        ],
        ];
    
        return $filter;
    }
    
    private function getRows($table)
    {
        $gateway = $this->getServiceLocator()->get($table . 'TableGateway');
        $rowset = $gateway->select();
    
        return $rowset->toArray();
    }
    
    public function search($type, $text)
    {
        switch ($type) {
        	case 'geography' :
        	case 'sector' :
        	case 'jobarea' :
        	case 'keyevent' :
        	    break;
        	default:
        	    throw new \Exception('Invalid filter search request');
        }

        $table = $this->{$type . 'Table'};
        $column = $type;

        $result = $table->select(function(Select $select) use ($column, $text) {
            $select
            ->columns([$column . 'id', $column])
            ->where->like($column, '%' . $text . '%');
        })->toArray();

        return $result;
    }
}

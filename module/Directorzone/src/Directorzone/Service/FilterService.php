<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class FilterService extends NetsensiaService
{
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
}

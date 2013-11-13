<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class AdminController extends NetsensiaActionController
{
    
    private $companyTableGateway;
    
    public function __construct(
        TableGateway $companyTableGateway
    ) {
        $this->companyTableGateway = $companyTableGateway;
    }
   
	public function onDispatch(MvcEvent $e) 
	{
		if (!$this->isLoggedOn()) {
			return $this->redirect()->toRoute('login');
		}
		
		parent::onDispatch($e);
	}

    public function indexAction()
    {
        $this->redirect()->toRoute('admin-companies');
    }
    
    public function companiesAction()
    {
        $rowset = $this->companyTableGateway->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
        
        foreach ($rowset as $row) {
            $companiesHouseCount = number_format($row['count']);
        }
        
        return [
            'filters' =>  [
                'live' => ['name' => 'Live', 'count' => 3],
                'pending' => ['name' => 'Pending', 'count' => 4],
                'unmatched' => ['name' => 'Unmatched', 'count' => 6],
                'companies-house' => ['name' => 'Companies House', 'count' => $companiesHouseCount],
            ]
       ];
    }
    
}

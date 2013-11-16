<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Directorzone\Service\CompanyService;
use Zend\View\Model\JsonModel;

class AdminController extends NetsensiaActionController
{
    private $companyService;
    
    public function __construct(
        CompanyService $companyService
    ) {
        $this->companyService = $companyService;
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
    
    public function uploadCompaniesAction()
    {
        $files = [
	       'files' => [
	             [ 
	                "name" => "picture1.jpg",
                    "size" => 902604,
                    "url" => "http:\/\/example.org\/files\/picture1.jpg",
                    "thumbnailUrl" => "http:\/\/example.org\/files\/thumbnail\/picture1.jpg",
                    "deleteUrl" => "http:\/\/example.org\/files\/picture1.jpg",
                    "deleteType" => "DELETE"
                 ],
                 [
                    "name" => "picture1.jpg",
                    "size" => 902604,
                    "url" => "http:\/\/example.org\/files\/picture1.jpg",
                    "thumbnailUrl" => "http:\/\/example.org\/files\/thumbnail\/picture1.jpg",
                    "deleteUrl" => "http:\/\/example.org\/files\/picture1.jpg",
                    "deleteType" => "DELETE"
                 ],
            ]
        ];
        return new JsonModel($files);
    }
    
    public function companiesAction()
    {        
        return [
            'filters' =>  [
                'live' => 
                    [
                    'name' => 'Live', 
                    'count' => $this->companyService->getLiveCount()
                ],
                'pending' => 
                    [
                    'name' => 'Pending', 
                    'count' => $this->companyService->getPendingCount()
                    ],
                'unmatched' => 
                    [
                    'name' => 'Unmatched', 
                    'count' => $this->companyService->getUnmatchedCount()
                    ],
                'conflicts' =>
                    [
                    'name' => 'Conflicts',
                    'count' => $this->companyService->getConflictsCount()
                    ],
                'removed' =>
                    [
                    'name' => 'Removed',
                    'count' => $this->companyService->getRemovedCount()
                    ],
                'unprocessed' =>
                    [
                    'name' => 'Unprocessed',
                    'count' => $this->companyService->getUnprocessedCount()
                    ],
                'companies-house' => 
                    [
                    'name' => 'Companies House', 
                    'count' => $this->companyService->getCompaniesHouseCount()
                    ],
            ]
       ];
    }
    
}

<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Directorzone\Service\CompanyService;
use Zend\View\Model\JsonModel;
use Zend\Validator\File\Size;
use Zend\Form\Form;

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
        $companyUploadService = $this->getServiceLocator()->get('CompanyUploadService');
        $returnArray = [];
        
        $filter = new \Zend\Filter\File\RenameUpload('./assets/admin/upload/companies/');
        $filter->setUseUploadName(true);
        
        $files = $this->getRequest()->getFiles();
        file_put_contents('bung.txt', print_r($files, true));
                        
        foreach ($files as $file) {
            try {
                $fileDetails = $filter->filter($file[0], true);
                $companyUploadService->ingest($fileDetails['tmp_name']);
            } catch (\Exception $e) {
                $returnArray['files'][] = ['error' => $e->getMessage()];
            }
        }
        
        return new JsonModel($returnArray);
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

<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Directorzone\Service\CompanyService;
use Zend\View\Model\JsonModel;
use Zend\Validator\File\Size;
use Zend\Form\Form;
use Zend\Stdlib\ParametersInterface;
use Zend\Log\Formatter\FirePhp;

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
        
        $filter = new \Zend\Filter\File\RenameUpload('./assets/admin/upload/companies/');
        $filter->setUseUploadName(true);
        $filter->setOverwrite(true);
        
        $files = $this->getRequest()->getFiles()->toArray();

        $file = $files['files'][0];
        
        $fileDetails = $filter->filter($file);
        $returnArray['files'][0]['name'] = $fileDetails['name'];
        
        try {
            $companyUploadService->ingest($fileDetails['tmp_name']);
            $returnArray['files'][0]['error'] = 'Complete';
        } catch (\Exception $e) {
            $returnArray['files'][0]['error'] = $e->getMessage();
        }
        
        $this->getServiceLocator()->get('Zend\Log')->info($returnArray);
        
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

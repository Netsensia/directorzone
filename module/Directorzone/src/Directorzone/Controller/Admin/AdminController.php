<?php

namespace Directorzone\Controller\Admin;

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
        
        $companyUploadService = $this->getServiceLocator()->get('CompanyUploadService');
        
        $filter = new \Zend\Filter\File\RenameUpload('./assets/admin/upload/companies/');
        $filter->setUseUploadName(true);
        $filter->setOverwrite(true);
        
        $files = $this->getRequest()->getFiles()->toArray();

        $file = $files['files'][0];
        
        $fileDetails = $filter->filter($file);
        $returnArray['files'][0]['name'] = $fileDetails['name'];
        
        try {
            $companies = $companyUploadService->ingest($fileDetails['tmp_name']);
            $returnArray['files'][0]['error'] = count($companies) . ' new companies uploaded';
        } catch (\Exception $e) {
            $returnArray['files'][0]['error'] = $e->getMessage();
        }
        
        $this->getServiceLocator()->get('Zend\Log')->info($returnArray);
        
        return new JsonModel($returnArray);
    }
    
    public function companiesAction()
    {
        $selectedCompanyType = $this->params()->fromQuery('type', null);
        if (empty($selectedCompanyType)) {
            $selectedCompanyType = 'uploaded';
        }
        
        return [
            'selectedCompanyType' => $selectedCompanyType,
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
                'uploaded' =>
                    [
                    'name' => 'Uploaded',
                    'count' => $this->companyService->getUploadedCount()
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

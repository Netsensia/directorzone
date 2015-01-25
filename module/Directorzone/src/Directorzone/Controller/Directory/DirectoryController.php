<?php

namespace Directorzone\Controller\Directory;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\CompanyService;

class DirectoryController extends NetsensiaActionController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    
    public function __construct(
        CompanyService $companyService
    )
    {
        $this->companyService = $companyService;
    }
      
    public function indexAction()
    {
        $this->redirect()->toRoute('directories/company-directory');
    }
    
    public function companyListAction()
    {
        $startPage = $this->params()->fromRoute('page', -1);
        
        if ($startPage == -1) {
            $this->redirect()->toRoute('directories/company-directory/company-directory-page', ['page' => '1']);
        }
        
        return [
            'startPage' => $startPage 
        ];
    }
    
    public function acceleratorListAction()
    {
        $startPage = $this->params()->fromRoute('page', -1);
        
        if ($startPage == -1) {
            $this->redirect()->toRoute('directories/accelerator/accelerator-directory-page', ['page' => '1']);
        }
        
        return [
            'startPage' => $startPage 
        ];
    }
    
    public function peopleListAction()
    {
        $startPage = $this->params()->fromRoute('page', -1);
        
        if ($startPage == -1) {
            $this->redirect()->toRoute('directories/people-directory/people-directory-page', ['page' => '1']);
        }
        
        return [
            'startPage' => $startPage 
        ];
    }
    
    public function talentPoolListAction()
    {
        $startPage = $this->params()->fromRoute('page', -1);
        
        if ($startPage == -1) {
            $this->redirect()->toRoute('directories/talent-pool/talent-pool-directory-page', ['page' => '1']);
        }
        
        return [
            'startPage' => $startPage 
        ];
    }
}

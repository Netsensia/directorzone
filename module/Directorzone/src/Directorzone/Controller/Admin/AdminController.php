<?php

namespace Directorzone\Controller\Admin;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Directorzone\Service\CompanyService;
use Zend\View\Model\JsonModel;
use Directorzone\Service\PeopleService;
use Directorzone\Form\Zend\Admin\MemberForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class AdminController extends NetsensiaActionController
{
    private $companyService;
    private $peopleService;
    
    public function __construct(
        CompanyService $companyService,
        PeopleService $peopleService
    ) 
    {
        $this->companyService = $companyService;
        $this->peopleService = $peopleService;
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
        
        $filter = new \Zend\Filter\File\RenameUpload('/tmp/');
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
        
        //$this->getServiceLocator()->get('Zend\Log')->info($returnArray);
        
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
    
    public function membersAction()
    {
        return [
            'members' => $this->getServiceLocator()->get('MemberService')->getMemberList()
        ];

    }
    
    public function memberDetailsAction()
    {
        $service = $this->getServiceLocator()->get('MemberService');
        
        $userId = $this->params()->fromRoute('id');
        $details = $service->getMemberDetails($userId);

        $form = new MemberForm();
        $form->get('userid')->setValue($details['userid']);
        $form->get('name')->setValue($details['name']);
        $form->get('forenames')->setValue($details['forenames']);
        $form->get('surname')->setValue($details['surname']);
        $form->get('email')->setValue($details['email']);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if (trim($form->get('newpassword')->getValue()) != '') {
                $inputFactory = new Factory();
                $inputFilter = $inputFactory->createInputFilter(array(
                    'confirmnewpassword' => array(
                        'name'       => 'confirmnewpassword',
                        'validators' => array(
                            array(
                                'name' => 'Identical',
                                'options' => array(
                                    'token' => 'newpassword',
                                    'message' => 'The passwords do not match'
                                ),
                            ),
                        ),
                    ),
                ));
                $form->setInputFilter($inputFilter);
            }
            
            if ($form->isValid()) {
                
                $details = [
                        'name' => $form->get('name')->getValue(),
                        'forenames' => $form->get('forenames')->getValue(),
                        'surname' => $form->get('surname')->getValue(),
                        'email' => $form->get('email')->getValue(),
                    ];
                
                $newPassword = $form->get('newpassword')->getValue();
                $confirmNewPassword = $form->get('confirmnewpassword')->getValue();
                
                if (trim($newPassword) != '') {
                    $details['password'] = $this->getServiceLocator()->get('Netsensia\Service\UserService')->encryptPassword($newPassword);
                }
                
                $service->setMemberDetails(
                    $userId, 
                    $details
                );
                
                return $this->redirect()->toRoute('admin-members');
            }
        }
        
        return array('form' => $form);
    }
    
    public function companyOwnersAction()
    {
        return [];
    }
    
}

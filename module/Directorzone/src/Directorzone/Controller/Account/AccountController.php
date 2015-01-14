<?php

namespace Directorzone\Controller\Account;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Netsensia\Service\MessagingService;
use Directorzone\Service\TalentPoolService;
use Directorzone\Service\ExperienceService;

class AccountController extends NetsensiaActionController
{
    /**
     * @var MessagingService
     */
    private $messagingService;
    
    /**
     * @var TalentPoolService
     */
    private $talentPoolService;
    
    /**
     * @var ExperienceService
     */
    private $experienceService;
    
    public function __construct(
        MessagingService $messagingService,
        TalentPoolService $talentPoolService,
        ExperienceService $experienceService
    ) 
    {
        $this->messagingService = $messagingService;
        $this->talentPoolService = $talentPoolService;
        $this->experienceService = $experienceService;
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
        $this->redirect()->toRoute('account-personal');
    }
    
    public function accountAction()
    {
        return $this->userAccountForm('AccountAccountForm', 'User');
    }
        
    public function companyAction()
    {
        return $this->userAccountForm('AccountCompanyForm', 'User');
    }
        
    public function contactAction()
    {
        return $this->userAccountForm('AccountContactForm', 'User');
    }
        
    public function experienceAction()
    {
        return array(
            'history' => $this->experienceService->getHistory($this->getUserId()),
        );
    }
    
    public function inboxAction()
    {
        return $this->userAccountForm('AccountInboxForm', 'User');
    }
    
    public function viewMessageAction()
    {
        $userMessageId = $this->params('id');
        $results = $this->messagingService->getMessageDetails($userMessageId);
        
        return $results;
    }
    
    public function membershipAction()
    {
        return $this->userAccountForm('AccountMembershipForm', 'User');
    }
        
    public function preferencesAction()
    {
        return $this->userAccountForm('AccountPreferencesForm', 'User');
    }

    public function personalAction()
    {
        return $this->userAccountForm('AccountPersonalForm', 'User');
    }
    
    public function profileAction()
    {
        $form = $this->processForm(
                'AccountProfileForm',
                'User',
                $this->getUserId()
            );
        
        $talentPoolDetails = $this->talentPoolService->getTalentPoolDetails(
            $this->getUserId()
        );
        
        return array(
            'form' => $form,
            'footprint' => $talentPoolDetails['footprint'],
            'talentpoolsummary' => $talentPoolDetails['talentpoolsummary'],
            'flashMessages' => $this->getFlashMessages(),
        );
    }

    public function directoryAction()
    {
        return $this->userAccountForm('AccountDirectoryForm', 'User');
    }
    
    public function publishAction()
    {
        $articleId = $this->params('id');
        
        $hasCompany = $this->talentPoolService->hasCompany($this->getUserId());
        
        return array(
            "editId" => $articleId,
            'isAdmin' => $this->isAdmin(),
            'hasCompany' => $hasCompany,
            "form" => $this->processForm(
                'AccountPublishForm',
                'Article',
                $articleId
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function myArticlesAction()
    {
    }
    
    private function userAccountForm($formName, $modelName)
    {
        return array(
            "form" => $this->processForm(
                $formName,
                $modelName,
                $this->getUserId()
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
}

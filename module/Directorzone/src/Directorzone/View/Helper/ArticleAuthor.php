<?php
namespace Directorzone\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArticleAuthor extends AbstractHelper implements ServiceLocatorAwareInterface  
{
    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    public function __invoke()
    {
        $helperPluginManager = $this->getServiceLocator();
        $articleService = $helperPluginManager->getServiceLocator()->get('ArticleService');
        
        $isAnonymous = $this->view->anonymousstatusid == 1;
    	
    	if ($isAnonymous) {
    	    echo '<hr>';
    	    echo 'This is published by a Directorzone member. To make contact with the author, please login as a member and click reply.';
    	    echo '<hr>';
    	    echo '<strong>Anonymous Footprint</strong><br>';
    	    echo $this->view->footprint;
    	    echo '<hr>';
    	} else {
    	    if (empty($this->view->publishertype == 'Company')) {
    	        $link = $this->view->url('directories/company-directory/company-details', ['id' => $this->view->companyid]);
    	    } else {
    	        $link = $this->view->url('directories/talent-pool/talent-pool-details', ['id' => $this->view->userid]);
    	    }
    	    echo 'Published by <a href="' . $link . '">' . $this->view->name . '</a> on ' . date("F j, Y, g:i a", strtotime($this->view->publishdate));
    	}

    }
    
}

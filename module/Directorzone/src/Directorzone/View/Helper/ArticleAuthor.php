<?php
namespace Directorzone\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Directorzone\Service\ArticleService;

class ArticleAuthor extends AbstractHelper 
{
    public function __invoke()
    {
    	$isAnonymous = $this->view->anonymousstatusid == 1;
    	
    	if ($isAnonymous) {
    	    echo 'This is published by a Directorzone member. To make contact with the author, please login as a member and click reply.';
    	} else {
    	    echo 'Published by ' . $this->view->name . ' on ' . date("F j, Y, g:i a", strtotime($this->view->publishdate));
    	}

    }
    
}

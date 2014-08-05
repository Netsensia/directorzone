<?php
namespace Directorzone\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Directorzone\Service\ArticleService;

class ArticleFields extends AbstractHelper 
{
    public function __invoke()
    {
    	if ($this->view->articlecategoryid != ArticleService::ARTICLETYPE_MEETING &&
    		$this->view->articlecategoryid != ArticleService::ARTICLETYPE_EVENT) {
    			return;
    	}
        
    	echo '<div class="articlekeyfacts">';
    	echo '<ul class="list-group">';
    	echo('<li class="list-group-item">Location<span class="badge">' . $this->view->location . '</span></li>');
    	echo('<li class="list-group-item">Start Date<span class="badge">' . $this->prettyDate($this->view->startdate) . '</span></li>');
    	echo('<li class="list-group-item">End Date<span class="badge">' . $this->prettyDate($this->view->enddate) . '</span></li>');
    	echo('</ul>');
    	echo('</div>');

    }
    
    public function prettyDate($dateString)
    {
        $timestamp = strtotime($dateString);
        return date('D, d M y', $timestamp);
    }
}

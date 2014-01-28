<?php

namespace Directorzone\Controller\Article;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\ArticleService;

class ArticleController extends NetsensiaActionController
{
    /**
     * @var ArticleService
     */
    private $articleService;
    
    public function __construct(
        ArticleService $articleService
    ) {
        $this->articleService = $articleService;
    }
      
    public function indexAction()
    {
    }
    
    public function listAction()
    {
    }
}

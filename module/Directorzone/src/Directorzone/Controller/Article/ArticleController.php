<?php

namespace Directorzone\Controller\Article;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\ArticleService;
use Netsensia\Exception\NotFoundResourceException;
use Directorzone\Service\FilterService;

class ArticleController extends NetsensiaActionController
{
    /**
     * @var ArticleService
     */
    private $articleService;
    
    private $filterService;
    
    public function __construct(
        ArticleService $articleService,
        FilterService $filterService
    )
    {
        $this->articleService = $articleService;
        $this->filterService = $filterService;
    }
      
    public function indexAction()
    {
        $articleId = $this->params('id');
        $response = $this->getResponse();
        
        try {
            $article = $this->articleService->getArticle($articleId);
            return $article;
        } catch (NotFoundResourceException $e) {
            $this->getResponse()->setStatusCode(404);   
        }
    }
    
    public function listAction()
    {
        $result = [
            'isLoggedOn' => $this->isLoggedOn(),
            'isAdmin' => $this->isAdmin(),
            'filter' => $this->filterService->getFilterJson()
        ];
        
        return $result;
    }
    
    public function deleteAction()
    {
        $this->articleService->deleteArticle($this->params('id'));
        $this->redirect()->toRoute('articles/article-list');
    }

}

<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\ArticleService;
use Directorzone\Service\ElasticService;

class ArticleController extends NetsensiaActionController
{
    /**
     * @var ArticleService $articleService
     */
    private $articleService;
    
    /**
     * @var ElasticService $elasticService
     */
    private $elasticService;
    
    public function __construct(
        ArticleService $articleService,
        ElasticService $elasticService
    )
    {
        $this->articleService = $articleService;
        $this->elasticService = $elasticService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function articleSearchAction()
    {
        $name = $this->params()->fromQuery('name', null);
        
        $result = $this->elasticService->searchArticles($name);
        
        return new JsonModel(
            $result
        );
    }
    
    public function articleListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $typeArray = $this->params()->fromQuery('type', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
                
        $results = $this->articleService->getArticlesByType(
            $typeArray,
            $start,
            $end
        );
                
        $articles = [
            'results' => [],
        ];
        
        foreach ($results as $result) {
            
            $articles['results'][] = [
                'internalId' => $result['articleid'],
                'author' => '',
                'title' => $result['title'],
                'publishdate' => $result['publishdate'],
                'sectors' => '',
            ];
        }

        return new JsonModel(
            $articles
        );
    }
}

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
    
    public function publishOptionsAction()
    {
        $articleCategoryId = $this->params()->fromRoute('articlecategoryid', null);
        
        $result = $this->articleService->getPublishOptions($articleCategoryId);
        
        return new JsonModel(
            $result
        );  
    }
    
    public function eventsAction()
    {
        $events = [];
        
        $results = $this->articleService->mergeArticles(
            [5,6],
            [2],
            1,
            100
        );
        
        foreach ($results as $result) {
            $events[] = [
                'id' => $result['articleid'],
                'author' => '',
                'url' => '/article/' . $result['articleid'],
                'title' => $result['title'],
                'start' => strtotime($result['startdate']) * 1000,
                'end' => strtotime($result['enddate']) * 1000,
                'class' => 'event-info',
            ];
        }
    
        return new JsonModel(
            [
                'success' => 1,
                'result' => $events,
            ]
        );
    }
    
    public function articleListAction()
    {
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $typeArray = $this->params()->fromQuery('type', null);
        $statusArray = $this->params()->fromQuery('status', null);
        
        if ($statusArray == null) {
            $statusArray = ["2"];    
        }

        $order = $this->params()->fromQuery('order', null);
        $onlyMe = $this->params()->fromQuery('onlyme', null);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
                
        if ($onlyMe == 1) {
            $userId = $this->getUserId();
        } else {
            $userId = null;
        }
        
        $results = $this->articleService->mergeArticles(
            $typeArray,
            $statusArray,
            $start,
            $end,
            $order,
            $userId
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

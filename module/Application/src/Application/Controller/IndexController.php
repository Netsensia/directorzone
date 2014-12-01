<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Directorzone\Service\ArticleService;

class IndexController extends NetsensiaActionController
{
    /**
     * @var ArticleService
     */
    private $articleService;
    
    public function __construct(
        ArticleService $articleService
    )
    {
        $this->articleService = $articleService;
    }
    
    public function indexAction()
    {
        $retArray = [
            'flashMessages' => $this->getFlashMessages(),
            'mediaItems' => [
                'news' => $this->articleService->mergeArticles([7, 10, 18, 9], [2], 1, 4, -3, null),
                'people' => $this->articleService->mergeArticles([8], [2], 1, 4, -3, null),
                'events' => $this->articleService->mergeArticles([5], [2], 1, 4, -3, null),
                'blogs' => $this->articleService->mergeArticles([1], [2], 1, 4, -3, null),
                'meetingrequests' => $this->articleService->mergeArticles([11], [2], 1, 4, -3, null),
                'jobs' => $this->articleService->mergeArticles([6], [2], 1, 4, -3, null),
                'offered' => $this->articleService->mergeArticles([4,13], [2], 1, 4, -3, null),
                'wanted' => $this->articleService->mergeArticles([3, 12], [2], 1, 4, -3, null),
            ],
        ];
        
        return $retArray;
    }

}

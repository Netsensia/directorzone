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
    ) {
        $this->articleService = $articleService;
    }
    
    public function indexAction()
    {
        $mediaItems = [];
        $types = ['news', 'movers', 'wanted', 'offered', 'events', 'movers', 'blogposts'];
        $limit = 2;
        
        foreach ($types as $type) {
            $mediaItems[$type] = $this->articleService->getArticlesByType($type, $limit);
        }
        
        return [
            'flashMessages' => $this->getFlashMessages(),
            'mediaItems' => $mediaItems,
        ];
    }
}

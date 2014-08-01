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
        $types = [1,2,3,4,5,6,7,8];
        $statuses = [2];
        $limit = 4;
        
        foreach ($types as $type) {
            $mediaItems[$type] = $this->articleService->getArticlesByType($type, $statuses, $limit, 0, -2);
        }
        
        return [
            'flashMessages' => $this->getFlashMessages(),
            'mediaItems' => $mediaItems,
        ];
    }
}

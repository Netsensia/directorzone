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
                'news' => $this->mergeMediaItems([7, 10, 18, 9]),
                'people' => $this->mergeMediaItems([8]),
                'events' => $this->mergeMediaItems([5]),
                'blogs' => $this->mergeMediaItems([1]),
                'meetingrequests' => $this->mergeMediaItems([11]),
                'jobs' => $this->mergeMediaItems([6]),
                'offered' => $this->mergeMediaItems([4,13]),
                'wanted' => $this->mergeMediaItems([3, 12]),
            ],
        ];

        return $retArray;
    }
    
    private function mergeMediaItems($typeArray)
    {
        $allTypes = [];
        
        foreach ($typeArray as $parentId) {
            $allTypes = array_merge(
                $allTypes,
                $this->articleService->getAllTypesWithParent($parentId)
            );
        }
        
        return $this->articleService->getArticlesByType($allTypes, [2], 4, 0, -3);
        
    }
}

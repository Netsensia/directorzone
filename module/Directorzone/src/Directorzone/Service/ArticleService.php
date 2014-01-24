<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ArticleService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $articleTable;
    
    public function __construct(
        TableGateway $articleTable
    ) {
        $this->articleTable = $articleTable;
    }

    public function getArticlesByType($type, $limit)
    {
        $articles = [
            [
                'image' => '/img/brand/globe.fw.png',
                'title' => 'Example title',
                'content' => 'This is some example content.  It is a little bit longer than the title.'
            ],
            [
                'image' => '/img/brand/globe.fw.png',
                'title' => 'Another example title',
                'content' => 'This is some more example content.  It is a little bit longer than the title.'
            ],
        ];
        
        return $articles;
    }
}

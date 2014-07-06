<?php
namespace Netsensia\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ArticleComments extends AbstractHelper 
{
    public function __invoke($comments, $addCommentLink)
    {
        echo '<h2>Comments</h2>';
        
        $count = 0;
        foreach ($comments['results'] as $comment) {
            $count ++;
            echo '<h4>' . $comment['author'] . '</h4>';
            echo '<h5>' . $comment['createdtime'] . '</h5>';
            echo '<div>';
            echo $comment['content'];
            echo '</div>';
        }
        
        if ($count == 0) {
            echo 'There are currently comments for this article';
        }
        echo '<div>';
        echo $addCommentLink;
        echo '</div>';
    }
}

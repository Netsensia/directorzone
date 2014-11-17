<?php

namespace spec\Directorzone\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArticleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Directorzone\Model\Article');
    }
    
    function it_returns_its_id()
    {
        $this->setPrimaryKey(['articleid' => 2]);
        $this->getArticleId()->shouldReturn(2);
    }
}

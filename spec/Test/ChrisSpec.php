<?php

namespace spec\Test;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChrisSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Test\Chris');
    }
}

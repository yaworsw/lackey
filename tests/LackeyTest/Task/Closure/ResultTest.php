<?php

namespace LackeyTest\Task\Closure;

use LackeyTest\AbstractTestCase;
use Lackey\Task\Closure\Result;

class ResultTest extends AbstractTestCase
{

    public function testShouldNotBeErrorEvenIfStringIntsArePassedToIt()
    {
        $result = new Result('1');
        $this->assertEquals(0, $result->getStatus());
    }
}

<?php

namespace LackeyTest\Task;

use Lackey\Task\ClosureTask;
use LackeyTest\AbstractTestCase;

class ClosureTest extends AbstractTestCase
{

    public function testRun()
    {
        $exec = new ClosureTask('closure-task', 'description', function ($options) {

        }, array());
        $exec->run();
    }
}

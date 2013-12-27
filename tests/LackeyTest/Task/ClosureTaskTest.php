<?php

namespace LackeyTest\Task;

use Lackey\Task\ClosureTask;
use LackeyTest\AbstractTestCase;

class ClosureTest extends AbstractTestCase
{

    public function testName()
    {
        $exec = new ClosureTask('closure-task', 'description', function ($options) {

        });
        $this->assertEquals('closure-task', $exec->getName());
    }

    public function testRun()
    {
        $exec = new ClosureTask('closure-task', 'description', function ($options) {
            echo 'foo';
        });
        $this->expectOutputString('foo');
        $exec->run(array());
    }
}

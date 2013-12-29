<?php

namespace LackeyTest\Task;

use Lackey\Task\Closure;
use LackeyTest\AbstractTestCase;

class ClosureTest extends AbstractTestCase
{

    public function testName()
    {
        $exec = new Closure('closure-task', 'description', function ($options) {

        });
        $this->assertEquals('closure-task', $exec->getName());
    }

    public function testRun()
    {
        $exec = new Closure('closure-task', 'description', function ($options) {
            echo 'foo';
        });
        $this->expectOutputString('foo');
        $exec->run(array());
    }
}

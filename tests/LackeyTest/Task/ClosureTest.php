<?php

namespace LackeyTest\Task;

use Lackey\Lackey;
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

    public function testShouldAcceptCalliable()
    {
        $lackey = new Lackey(array('quiet' => true));
        $lackey->task('is_int', 'is_int', 'is_int');
        $lackey->run('is_int');
        $this->assertTrue(true);
    }
}

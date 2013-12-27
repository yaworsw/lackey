<?php

namespace LackeyTest\Task;

use Lackey\Task\MultiTask;
use LackeyTest\AbstractTestCase;

class MultiTaskTest extends AbstractTestCase
{

    public function testRun()
    {
        $lackey = $this->getMock('\Lackey\Lackey');
        $lackey->expects($this->at(0))
               ->method('run')
               ->with('one');

        $lackey->expects($this->at(1))
               ->method('run')
               ->with('two');

        $lackey->expects($this->at(2))
               ->method('run')
               ->with('three');

        $task = new MultiTask();
        $task->run(array(
          'one', 'two', 'three'
        ));
    }
}

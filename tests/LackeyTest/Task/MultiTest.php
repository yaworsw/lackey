<?php

namespace LackeyTest\Task;

use Lackey\Task\Multi;
use LackeyTest\AbstractTestCase;

class MultiTest extends AbstractTestCase
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

        $task = new Multi();
        $task->run(array(
          'one', 'two', 'three'
        ));
    }
}

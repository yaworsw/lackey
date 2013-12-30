<?php

namespace LackeyTest\Task;

use Lackey\Task\Alias;
use LackeyTest\AbstractTestCase;

class AliasTest extends AbstractTestCase
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

        $task = new Alias();
        $task->run(array(
          'one', 'two', 'three'
        ));
    }
}

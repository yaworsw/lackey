<?php

namespace LackeyTest\Task;

use LackeyTest\AbstractTestCase;

class AbstractTaskTest extends AbstractTestCase
{

    public function testGetName()
    {
        $stub = $this->getMockForAbstractClass('Lackey\\Task\\AbstractTask', array(), 'ImportantTask');
        $this->assertEquals('important-task', $stub->getName());
    }
}

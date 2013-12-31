<?php

namespace LackeyTest;

class TaskTest extends AbstractTestCase
{

    public function testToMultiTest()
    {
        $stub = $this->getMockForAbstractClass('Lackey\\Task');
        $task = $stub->toMultiTask();
        $this->assertInstanceOf('Lackey\MultiTaskInterface', $task);
    }
}

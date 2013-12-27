<?php

namespace LackeyTest\Task;

use Lackey\Task\Exec;
use LackeyTest\AbstractTestCase;

class ExecTest extends AbstractTestCase
{

    public function testRun()
    {
        $exec   = new Exec();
        $result = $exec->run(array(
            'command' => 'ls'
        ));
        $this->assertContains('composer.json', $result);
    }
}

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
            'command' => 'ls',
            'echo'    => false,
        ));
        $this->assertContains('composer.json', $result);
    }

    public function testOnComplate()
    {
        $this->expectOutputString('0');
        $exec = new Exec();
        $exec->run(array(
            'command'  => 'ls',
            'echo'     => false,
            'complete' => function ($out, $err, $status) {
                echo $status;
            }
        ));
    }

    public function testOnError()
    {
        $this->expectOutputString('fail');
        $exec = new Exec();
        $exec->run(array(
            'command'  => 'owafwa',
            'echo'     => false,
            'error' => function ($out, $err, $status) {
                echo 'fail';
            }
        ));
    }
}

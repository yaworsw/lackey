<?php

namespace LackeyTest\Task;

use Lackey\Task\Exec;
use LackeyTest\AbstractTestCase;

class ExecTest extends AbstractTestCase
{

    public function testRun()
    {
        $result = $this->captureOut(function () {
            $exec   = new Exec();
            $exec->run(array(
                'command' => 'ls',
            ));
        });
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

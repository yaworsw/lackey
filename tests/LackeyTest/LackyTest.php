<?php

namespace LackeyTest;

use Lackey\Lackey;
use Lackey\Task;

class LackyTest extends AbstractTestCase
{

    public function testMultipleSubTasks()
    {
        $lackey = new Lackey(array('quiet' => true));
        $lackey->loadTask(new Task\Exec(), array(
            'quiet' => array(
                'command' => 'ls',
                'echo'    => false
            ),
            'ls' => array(
                'command' => 'ls'
            ),
        ));
        $this->expectOutputString('');
        $lackey->run('exec:quiet');
    }

    public function testSpecificSubTask()
    {
        $lackey = new Lackey(array('quiet' => true));
        $lackey->loadTask(new Task\Exec(), array(
            'quiet' => array(
                'command' => 'ls',
                'echo'    => false
            ),
            'ls' => array(
                'command' => 'ls'
            ),
        ));
        $this->expectOutputString('');
        $lackey->run('exec:quiet');
    }

    public function testLoadTask()
    {
        $lackey = new Lackey();
        $lackey->loadTask('LackeyTest\\ComposerTask', array());
        $this->assertTrue(true);
    }

    public function testDefineClosureTask()
    {
        $var    = false;
        $lackey = new Lackey(array('quiet' => true));
        $lackey->task('hello', function () use (&$var) {
            $var = true;
        });
        $lackey->run('hello');
        $this->assertTrue($var);
    }

    public function testTaskNotDefined()
    {
        $this->setExpectedException('Lackey\\TaskNotFoundException');
        $lackey = new Lackey(array('quiet' => true));
        $lackey->run('hello');
    }
}

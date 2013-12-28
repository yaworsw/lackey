<?php

namespace LackeyTest;

use Lackey\Lackey;
use Lackey\Task;

class LackyTest extends AbstractTestCase
{

    public function testSubTask()
    {
        $lackey = new Lackey(array('silent' => true));
        $lackey->loadTask(new Task\Exec(), array(
            'ls' => array(
                'command' => 'ls',
                'echo'    => false
            ),
        ));
        $lackey->run('exec:ls');
        $this->assertTrue(true);
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

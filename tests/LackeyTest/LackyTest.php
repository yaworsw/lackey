<?php

namespace LackeyTest;

use Lackey\Lackey;
use Lackey\Task;

class LackyTest extends AbstractTestCase
{

    public function testExecutionStopsAfterFailedTask()
    {
        $lackey = new Lackey(array('quiet' => true));
        $lackey->task('one', 'first', function () {
            echo '1';
        });
        $lackey->task('two', function () {
            echo '2';
            return 32432;
        });
        $lackey->task('three', function () {
            echo '3';
        });
        $lackey->alias('test', array('one', 'two', 'three'));
        $this->expectOutputString('12');
        $lackey->run('test');
    }

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

<?php

namespace LackeyTest;

use Lackey\Lackey;
use Lackey\Task;

class LackyTest extends AbstractTestCase
{

    public function testSubTask()
    {
        $lackey = new Lackey();
        $lackey->loadTask(new Task\Exec(), array(
            'ls' => array(
                'command' => 'ls',
                'echo'    => false
            ),
        ));
        $lackey->run('exec:ls');
    }
}

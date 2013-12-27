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
        ob_start();
        $lackey->run('exec:ls');
        ob_end_clean();
        $this->assertTrue(true);
    }

    public function testLoadComposerTask()
    {
        $lackey = new Lackey();
        $lackey->loadTask('LackeyTest\\ComposerTask', array());
        $this->assertTrue(true);
    }
}

<?php

namespace LackeyTest\TextUI;

use Lackey\TextUI\Command;
use LackeyTest\AbstractTestCase;

class CommandTest extends AbstractTestCase
{

    public function testListCommandsWithTOption()
    {
        ob_start();
        $lackey = new \Lackey\Lackey();
        $lackey->task('test', 'This is a task description :) <3', function () {

        });
        $lackey->default(array('test'));
        $command = new Command('default', array('T' => ''));
        $command->run();
        $result = ob_get_clean();
        $this->assertContains('This is a task description :) <3', $result);
    }
}

<?php

namespace Lackey;

use Lackey\Task;

abstract class Task implements TaskInterface
{

    public static function asMultiTask()
    {
        $args    = func_get_args();
        $reflect = new \ReflectionClass(get_called_class());
        $task    = $reflect->newInstanceArgs($args);
        return new Task\Multi($task);
    }

    public function toMultiTask()
    {
        return new Task\Multi($this);
    }
}

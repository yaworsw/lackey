<?php

namespace Lackey;

use Lackey\Task;

abstract class Task implements TaskInterface
{

    public function toMultiTask()
    {
        return new Task\Multi($this);
    }
}

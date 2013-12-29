<?php

namespace Lackey\Task;

use Lackey\Lackey;

/**
 * A task which wraps around multiple other tasks.
 */
class Multi extends AbstractTask
{

    protected $description;

    public function __construct($description = 'Runs multiple commands.')
    {
        $this->description = $description;
    }

    public function run(array $options = array())
    {
        $lackey = Lackey::getInstance();
        foreach ($options as $task) {
            $lackey->run($task);
        }
    }
}

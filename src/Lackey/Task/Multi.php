<?php

namespace Lackey\Task;

use Lackey\Lackey;
use Lackey\Task\Multi\Result;

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

    public function run(array $taskOptions = array(), array $runOptions = array())
    {
        $lackey  = Lackey::getInstance();
        $results = array();
        foreach ($taskOptions as $task) {
            $results[] = $lackey->run($task, $runOptions);
        }
        return new Result($results);
    }
}

<?php

namespace Lackey\Task;

use Lackey\Lackey;

/**
 * A task which wraps around multiple other tasks.
 */
class Alias extends AbstractTask
{

    protected $description;

    public function __construct($description = 'Runs multiple commands.')
    {
        $this->description = $description;
    }

    public function run(array $taskOptions = array(), array $runOptions = array())
    {
        $lackey  = Lackey::getInstance();
        $results = new Alias\Result();
        foreach ($taskOptions as $task) {
            $result = $lackey->run($task, $runOptions);
            $results->add($result);
            if ($results->getStatus() !== 0) {
                break;
            }
        }
        return $results;
    }
}

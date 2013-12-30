<?php

namespace Lackey\Task;

use Lackey\MultiTaskInterface;
use Lackey\TaskInterface;

class Multi extends AbstractMultiTask
{

    protected $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    public function getName()
    {
        return $this->task->getName();
    }

    public function getDescription()
    {
        return $this->task->getDescription();
    }

    public function run(array $taskOptions = array(), array $runOptions = array())
    {
        $this->task->run($taskOptions, $runOptions);
    }
}

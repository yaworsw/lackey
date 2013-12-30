<?php

namespace Lackey;

interface TaskInterface
{

    /**
     * Returns the name of the task
     */
    public function getName();

    /**
     * Returns a description of the task
     */
    public function getDescription();

    /**
     * Runs the task.  Options are given to configure execution.
     */
    public function run(array $taskOptions = array(), array $runOptions = array());
}

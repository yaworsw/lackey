<?php

namespace Lackey\Task;

class MultiTask extends AbstractTask
{

    protected $description;

    public function __construct($description = 'Runs multiple commands.')
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function run(array $options = array())
    {
        $lackey = \Lackey\Lackey::getInstance();
        foreach ($options as $task) {
            $lackey->run($task);
        }
    }
}

<?php

namespace Lackey;

use Colors\Color;

class TaskRunner
{

    protected static $defaults = array(
        'silent'    => false,   // do not output anything, (squelch + quiet)
        'squelch'   => false,   // do not echo any output
        'quiet'     => false,   // do not echo 'Running X task'
    );

    protected $options;

    public function __construct($options)
    {
        $this->options = array_replace_recursive(self::$defaults, $options);
    }

    public function run(TaskInterface $task, array $options = array())
    {
        $this->{'run' . ($task instanceof MultiTaskInterface ? 'Multi' : 'Single') . 'Task'}($task, $options);
    }

    protected function runSingleTask(Task $task, $options, $taskName = null)
    {
        if (!$this->options['silent'] && !$this->options['quiet']) {
            if (is_null($taskName)) {
                $taskName = $task->getName();
            }
            $c = new Color();
            echo $c("Running \"$taskName\" task")->underline() . PHP_EOL . PHP_EOL;
        }
        if ($this->options['silent'] || $this->options['squelch']) {
            ob_start();
        }
        $task->run($options, $this->options);
        if ($this->options['silent'] || $this->options['squelch']) {
            ob_end_clean();
        }
    }

    protected function runMultiTask(MultiTaskInterface $task, $options)
    {
        foreach ($options as $subTask => $taskOptions) {
            $this->runSingleTask($task, $taskOptions, $task->getName() . ':' . $subTask);
        }
    }
}

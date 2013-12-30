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
        $type = $task instanceof MultiTaskInterface ? 'Multi' : 'Single';
        return $this->{'run' . $type . 'Task'}($task, $options);
    }

    protected function announceRunningTask($task, $options, $taskName = null)
    {
        if (!$this->options['silent'] && !$this->options['quiet']) {
            if (is_null($taskName)) {
                $taskName = $task->getName();
            }
            $c = new Color();
            echo $c("Running \"$taskName\" task")->underline() . PHP_EOL . PHP_EOL;
        }
    }

    protected function silence()
    {
        if ($this->options['silent'] || $this->options['squelch']) {
            ob_start();
        }
    }

    protected function unsilence()
    {
        if ($this->options['silent'] || $this->options['squelch']) {
            ob_end_clean();
        }
    }

    protected function runSingleTask(Task $task, $options, $taskName = null)
    {
        $this->announceRunningTask($task, $options, $taskName);
        $this->silence();
        $result = $task->run($options, $this->options);
        $this->unsilence();
        return $result;
    }

    protected function runMultiTask(MultiTaskInterface $task, $options)
    {
        $results = new Task\Alias\Result();
        foreach ($options as $subTask => $taskOptions) {
            $result = $this->runSingleTask($task, $taskOptions, $task->getName() . ':' . $subTask);
            $results->add($result);
            if ($results->getStatus() !== 0) {
                break;
            }
        }
        return $results;
    }
}

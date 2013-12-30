<?php

namespace Lackey;

use Colors\Color;
use Lackey\Task;

class Lackey
{

    protected static $runDefaults = array(
        'silent'    => false,   // do not output anything, (squelch + quiet)
        'squelch'   => false,   // do not echo any output
        'quiet'     => false,   // do not echo 'Running X task'
    );

    private static $instance;

    protected $tasks   = array();

    protected $options = array();

    protected $runOptions;

    public function __construct(array $runDefaults = array())
    {
        $this->runOptions = array_replace_recursive(self::$runDefaults, $runDefaults);
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Create an alias which can refer to multiple other tasks.
     */
    public function alias($name, $description, array $tasks = array())
    {
        if (!isset($tasks) && is_array($description)) {
            $tasks       = $description;
            $description = null;
        }
        $this->tasks[$name]   = new Task\Multi($description);
        $this->options[$name] = array($tasks);
    }

    /**
     * Load a task.  Can be passed either a string which is the class name of
     * the task or an instance of the task's class.
     */
    public function loadTask($name, array $options = array())
    {
        if (!($name instanceof Task)) {
            $name = new $name;
        }
        $task     = $name;
        $taskName = $task->getName();
        $this->tasks[$taskName] = $task;
        if (!isset($options[$taskName])) {
            $this->options[$taskName] = array();
        }
        $this->options[$taskName] = array_replace($this->options[$taskName], $options);
    }

    /**
     * Create a task which calls an anonymous function.
     */
    public function task($name, $description, \Closure $closure = null, array $options = array())
    {
        $task = new Task\Closure($name, $description, $closure);
        $this->loadTask($task, $options);
    }

    private static function notNumeric($in)
    {
        return !is_numeric($in);
    }

    public function getDescriptions()
    {
        $descriptions = array();
        foreach ($this->tasks as $name => $task) {
            $descriptions[$name] = array(
                'subtasks'    => $this->getSubTasks($name),
                'description' => $task->getDescription(),
            );
        }
        ksort($descriptions);
        return $descriptions;
    }

    public function getSubTasks($task)
    {
        $subtasks = array_filter(array_keys($this->options[$task]), array($this, 'notNumeric'));
        sort($subtasks);
        return $subtasks;
    }

    protected static function taskDefenition($taskName)
    {
        if (is_array($taskName)) {
            return $taskName;
        }
        $exploded = explode(':', $taskName);
        $result   = array(
            'task' => $exploded[0],
        );
        if (isset($exploded[1])) {
            $result['sub'] = $exploded[1];
        }
        return $result;
    }

    public function getTask($taskName)
    {
        $def = self::taskDefenition($taskName);
        if (!isset($this->tasks[$def['task']])) {
            throw new TaskNotFoundException("The task \"$taskName\" was not found");
        }
        return $this->tasks[$def['task']];
    }

    public function getTaskOptions($taskName)
    {
        $def     = self::taskDefenition($taskName);
        $options = $this->options[$def['task']];
        if (isset($def['sub'])) {
            if (!isset($options[$def['sub']])) {
                $taskName = implode(':', $def);
                throw new TaskNotFoundException("Task configuration for the task \"$taskName\" was not found");
            }
            $options = $options[$def['sub']];
        } else if (isset($options[0])) {
            $options = $options[0];
        }
        return $options;
    }

    public function run($taskName, array $runOptions = array())
    {
        $c = new Color();

        $runOptions = array_replace_recursive($this->runOptions, $runOptions);

        if (!$runOptions['silent'] && !$runOptions['quiet']) {
            echo $c("Running ($taskName) task")->underline() . PHP_EOL . PHP_EOL;
        }

        $def     = self::taskDefenition($taskName);
        $task    = $this->getTask($taskName);
        $options = $this->getTaskOptions($taskName);

        if ($runOptions['silent'] || $runOptions['squelch']) {
            ob_start();
        }

        if ($task instanceof MultiTaskInterface && !isset($def['sub'])) {
            $this->execMultiTask($task, $options, $runOptions);
        } else {
            $task->run($options, $runOptions);
        }

        if ($runOptions['silent'] || $runOptions['squelch']) {
            ob_end_clean();
        }
    }

    protected function execMultiTask(MultiTaskInterface $task, array $options = array(), array $runOptions = array())
    {
        $taskName = $task->getName();
        $subtasks = array_keys($this->options[$taskName]);
        sort($subtasks);
        foreach ($subtasks as $subTask) {
            $task->run($options[$subTask], $runOptions);
        }
    }
}

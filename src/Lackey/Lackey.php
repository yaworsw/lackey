<?php

namespace Lackey;

use Lackey\Task;

class Lackey
{

    private static $instance;

    protected $tasks   = array();

    protected $options = array();

    protected $runOptions;

    public function __construct(array $runOptions = array())
    {
        $this->runOptions = $runOptions;
        self::$instance   = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function setDefault(array $tasks = array())
    {
        $this->alias('default', 'The default task', $tasks);
    }

    /**
     * Create an alias which can refer to multiple other tasks.
     */
    public function alias($name, $description, array $tasks = null)
    {
        if (!isset($tasks) && is_array($description)) {
            $tasks       = $description;
            $description = null;
        }
        $this->tasks[$name]   = new Task\Alias($description);
        $this->options[$name] = array($tasks);
    }

    /**
     * Load a task.  Can be passed either a string which is the class name of
     * the task or an instance of the task's class.
     */
    public function loadTask($name, array $options = array())
    {
        if (is_string($name)) {
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
    public function task($name, $description, $closure = null, array $options = array())
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
            $task = $def['task'];
            throw new TaskNotFoundException("The task \"$task\" was not found");
        }
        return $this->tasks[$def['task']];
    }

    public function getTaskOptions($taskName)
    {
        $def     = self::taskDefenition($taskName);
        $options = $this->options[$def['task']];
        if (isset($def['sub'])) {
            $temp = array();
            $temp[$def['sub']] = $options[$def['sub']];
            $options = $temp;
        } else if (isset($options[0])) {
            $options = $options[0];
        }
        return $options;
    }

    public function run($taskName, array $runOptions = array())
    {
        $runnerOptions = array_replace_recursive($this->runOptions, $runOptions);

        $taskRunner = new TaskRunner($runnerOptions);

        $def     = self::taskDefenition($taskName);
        $task    = $this->getTask($def);
        $options = $this->getTaskOptions($def);

        $result  = $taskRunner->run($task, $options);

        return is_null($result)
             ? new Task\PositiveResult()
             : $result;
    }

    public function __call($name, $args)
    {
        if ($name === 'default') {
            return call_user_func_array(array($this, 'setDefault'), $args);
        }
    }
}

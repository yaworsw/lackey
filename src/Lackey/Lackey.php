<?php

namespace Lackey;

use Colors\Color;
use Lackey\Task\ClosureTask;

class Lackey
{

    private static $instance;

    protected $tasks   = array();

    protected $options = array();

    public function __construct()
    {

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
        $this->tasks[$name]   = new Task\MultiTask($description);
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
        $task = $name;
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
        $task = new ClosureTask($name, $description, $closure);
        $this->loadTask($task, $options);
    }

    /**
     * Runs a task.
     */
    public function run($taskName)
    {
        $c = new Color();
        echo $c("Running \"$taskName\" task")->underline() . PHP_EOL . PHP_EOL;
        if (strpos($taskName, ':') !== false) {
            $temp     = explode(':', $taskName);
            $taskName = $temp[0];
        }
        if (!isset($this->tasks[$taskName])) {
            throw new TaskNotFoundException("Task \"$taskName\" was not found");
        }
        $task     = $this->tasks[$taskName];
        $subtasks = strpos($taskName, ':') === false
                  ? array_keys($this->options[$taskName])
                  : array_slice(explode(':', $taskName), 0);
        if (count($subtasks) === 0) {
            $options = $this->options[$taskName];
            $task->run($options);
        } else {
            foreach ($subtasks as $subtask) {
                $options = $this->options[$taskName][$subtask];
                $task->run($options);
            }
        }
    }
}

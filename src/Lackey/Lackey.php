<?php

namespace Lackey;

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

    public function alias($name, $description, array $tasks = array())
    {
        if (!isset($tasks) && is_array($description)) {
            $tasks       = $description;
            $description = null;
        }
        $this->tasks[$name]   = new Task\MultiTask($description);
        $this->options[$name] = $tasks;
    }

    public function loadComposerTask($name, array $options = array())
    {

    }

    public function loadTask(Task $task, array $options = array())
    {
        $taskName = $task->getName();
        $this->tasks[$taskName] = $task;
        if (!isset($options[$taskName])) {
            $this->options[$taskName] = array();
        }
        $this->options[$taskName] = array_replace($this->options[$taskName], $options);
    }

    public function task($name, $description, \Closure $closure, array $options = array())
    {

    }

    public function run($taskName, $subtask = null)
    {
        if (isset($subtask) || strpos($taskName, ':') !== false) {
            list($taskName, $subtask) = explode(':', $taskName);
        }
        $task    = $this->tasks[$taskName];
        $options = isset($subtask) ? $this->options[$taskName][$subtask] : $this->options[$taskName];
        $task->run($options);
    }
}

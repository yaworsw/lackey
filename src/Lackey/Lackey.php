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
        $this->options[$name] = array($tasks);
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

    public function run($taskName)
    {
        $task     = $this->tasks[$taskName];
        $subtasks = strpos($taskName, ':') === false
                  ? array_keys($this->options[$taskName])
                  : array_slice(explode(':', $taskName), 0);
        foreach ($subtasks as $subtask) {
            $options = $this->options[$taskName][$subtask];
            $task->run($options);
        }
    }
}

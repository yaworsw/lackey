<?php

namespace Lackey;

class Lackey
{

    private static $instance;

    protected $tasks = array();

    protected $options = array();

    public function __construct()
    {

        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function loadComposerTask($name, array $options = array())
    {

    }

    public function loadTask(Task $task, array $options = array())
    {

    }

    public function task($name, $description, \Closure $closure, array $options = array())
    {

    }
}

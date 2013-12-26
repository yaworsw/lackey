<?php

namespace Lackey;

class Lackey
{

    private static $instance;

    public function __construct()
    {

        self::$instance = $this;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function loadComposerTask($name, array $options = array())
    {

    }

    public function loadTask(Task $task, array $options = array())
    {

    }
}

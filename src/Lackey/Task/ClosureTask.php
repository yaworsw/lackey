<?php

namespace Lackey\Task;

class ClosureTask extends AbstractTask
{

    protected $name;
    protected $description;
    protected $closure;

    public function __construct($name, $description, \Closure $closure)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->closure     = $closure;
    }

    public function run(array $options = array())
    {
        call_user_func($this->closure, $options);
    }
}

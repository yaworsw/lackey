<?php

namespace Lackey\Task;

/**
 * A task which wraps a closure.
 */
class Closure extends AbstractTask
{

    protected $name;
    protected $description;
    protected $closure;

    public function __construct($name, $description, \Closure $closure = null)
    {
        if (is_null($closure)) {
            if (is_callable($description)) {
                $closure     = $description;
                $description = '';
            } else {
                throw new \InvalidArgumentException(
                    'No closure passed to ClosureTask constructor'
                );
            }
        }
        $this->name        = $name;
        $this->description = $description;
        $this->closure     = $closure;
    }

    public function run(array $options = array())
    {
        call_user_func($this->closure, $options);
    }
}

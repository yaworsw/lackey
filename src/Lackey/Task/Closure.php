<?php

namespace Lackey\Task;

use Lackey\Task\Closure\Result;

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

    public function run(array $taskOptions = array(), array $runOptions = array())
    {
        try {
            $result = call_user_func($this->closure, $taskOptions, $runOptions);
            if (is_null($result)) {
                $result = 0;
            }
            return new Result($result);
        } catch (\Exception $ex) {
            return new Result(1, $ex->getMessage());
        }
    }
}

<?php

namespace Lackey\Task;

use Lackey\Task\Closure\Result as ClosureResult;

abstract class AbstractClosureTask extends AbstractTask
{

    protected $name;
    protected $description;
    protected $closure;

    public function __construct($name, $description, $closure = null)
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
            return new ClosureResult($result);
        } catch (\Exception $ex) {
            return new ClosureResult(1, $ex->getMessage());
        }
    }
}

<?php

namespace Lackey\Task\Closure;

use Lackey\Task\AbstractResult;

class Result extends AbstractResult
{

    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function getStatus()
    {
        return is_int($this->result)
             ? $this->result
             : 0;
    }
}

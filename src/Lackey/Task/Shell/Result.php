<?php

namespace Lackey\Task\Shell;

use Lackey\Task\AbstractResult;

class Result extends AbstractResult
{

    protected $status;

    protected $stdout;

    protected $stderr;

    public function __construct($status, $stdout, $stderr)
    {
        $this->status = $status;
        $this->stdout = $stdout;
        $this->stderr = $stderr;
    }

    /* to an array that can be used when calling call user func array */
    public function toCufa()
    {
        return array(
            $this->stdout,
            $this->stderr,
            $this->status
        );
    }

    public function isError()
    {
        return !($this->status === 0);
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function __isset($name)
    {
        return isset($this->{$name});
    }
}

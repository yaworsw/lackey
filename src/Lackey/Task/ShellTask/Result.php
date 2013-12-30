<?php

namespace Lackey\Task\ShellTask;

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

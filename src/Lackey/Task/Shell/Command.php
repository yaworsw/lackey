<?php

namespace Lackey\Task\Shell;

class Command
{

    protected $spec;

    public function __construct(array $spec)
    {
        $this->spec = $spec;
    }

    public function getArgs()
    {
        return isset($this->spec['args'])
             ? $this->spec['args']
             : array();
    }

    public function getCwd()
    {
        return isset($this->spec['cwd'])
             ? $this->spec['cwd']
             : getcwd();
    }

    public function getOptions()
    {
        return isset($this->spec['options'])
             ? $this->spec['options']
             : array();
    }

    public function run()
    {
        $pipeSpec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w"),
        );
        $proc = proc_open($this->__toString(), $pipeSpec, $pipes, $this->getCwd(), null);

        if (!is_resource($proc)) {
            throw new \RuntimeException('The process was unable to be started');
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        array_walk($pipes, array($this, 'closePipe'));

        $status = proc_close($proc);

        return new Result($status, $stdout, $stderr);
    }

    private static function closePipe($pipe)
    {
        fclose($pipe);
    }

    public function __toString()
    {
        $command = array($this->spec['bin']);
        foreach ($this->getOptions() as $key => $val) {
            $command[] = $key . '=' . $val;
        }
        foreach ($this->getArgs() as $arg) {
            $command[] = $arg;
        }
        return implode(' ', $command);
    }
}

<?php

namespace Lackey\Task;

/**
 * A task which runs a shell command.
 */
class Exec extends AbstractTask
{

    protected $defaults;

    protected $description = 'Runs a command in a shell.';

    /**
     * Initialize defaults.
     */
    public function __construct()
    {
        $this->defaults = array(
            'cwd'  => getcwd(),
            'echo' => true
        );
    }

    /**
     * Runs a given shell command.
     */
    public function run(array $options = array())
    {
        $options = array_replace_recursive($this->defaults, $options);

        $proc = proc_open(
            $options['command'],
            array(
               0 => array("pipe", "r"),
               1 => array("pipe", "w"),
               2 => array("pipe", "w"),
            ),
            $pipes,
            $options['cwd'],
            null
        );

        if (!is_resource($proc)) {
            throw new \Exception('Unable to start process');
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status   = proc_close($proc);

        $result = $status !== 0 ? 'error' : 'success';
        if (isset($options[$result])) {
            call_user_func($options[$result], $stdout, $stderr, $status);
        }

        if (isset($options['complete'])) {
            call_user_func($options['complete'], $stdout, $stderr, $status);
        }

        if ($options['echo']) {
            echo $stdout . PHP_EOL;
        }

        return $stdout;
    }
}

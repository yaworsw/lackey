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
        if (is_resource($proc)) {
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);

            foreach ($pipes as $pipe) {
                fclose($pipe);
            }

            $status = proc_close($proc);

            $cufArray = array($stdout, $stderr, $status);

            if ($status !== 0) {
                if (isset($options['error'])) {
                    call_user_func_array($options['error'], $cufArray);
                }
            } else {
                if (isset($options['success'])) {
                    call_user_func_array($options['success'], $cufArray);
                }
            }
            if (isset($options['complete'])) {
                call_user_func_array($options['complete'], $cufArray);
            }

            if ($options['echo']) {
                echo $stdout;
                echo PHP_EOL;
            }

            return $stdout;

        } else {

            throw new \Exception('Unable to start process');

        }
    }
}

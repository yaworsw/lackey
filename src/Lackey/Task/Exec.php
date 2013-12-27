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
        $oldCwd  = getcwd();
        chdir($options['cwd']);

        exec($options['command'], $out, $status);

        chdir($oldCwd);

        $out = implode($out, PHP_EOL);
        $cufArray = array($out, $status);

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
            echo $out;
            echo PHP_EOL;
        }

        return $out;
    }
}

<?php

namespace Lackey\Task;

class Exec extends AbstractTask
{

    protected $defaults;

    public function __construct()
    {
        $this->defaults = array(
            'cwd'  => getcwd(),
            'echo' => true
        );
    }

    public function getDescription()
    {
        return 'Runs a command in a shell.';
    }

    public function run(array $options = array())
    {
        $options = array_replace_recursive($this->defaults, $options);
        $oldCwd  = getcwd();
        chdir($options['cwd']);

        exec($options['command'], $out, $status);

        chdir($oldCwd);

        $out = implode($out, "\n");
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
        }

        return $out;
    }
}

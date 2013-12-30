<?php

namespace Lackey\Task;

use Lackey\MultiTaskInterface;

/**
 * A task which runs a shell command.
 */
class Exec extends AbstractShellTask implements MultiTaskInterface
{

    protected $defaults = array(
        'echo' => true
    );

    protected $description = 'Runs a command in a shell.';

    public function run(array $options = array(), array $runOptions = array())
    {
        $options = array_replace_recursive($this->defaults, $options);
        $options['bin'] = $options['command'];
        $result = parent::exec($options);
        return $result->status;
    }
}

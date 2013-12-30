<?php

namespace Lackey\Task;

use Lackey\TaskInterface;
use Lackey\Task\ShellTask\Command;

abstract class AbstractShellTask extends AbstractTask
{

    protected function exec(array $config = array())
    {
        $command = new Command($config);
        $result  = $command->run();
        $cufa    = array(
            $result->stdout,
            $result->stderr,
            $result->status
        );
        $userFunctions = array(
            $result->isError() ? 'error' : 'success',
            'complete',
        );
        foreach ($userFunctions as $userFunction) {
            if (isset($config[$userFunction])) {
                call_user_func_array($config[$userFunction], $cufa);
            }
        }
        if ($config['echo']) {
            echo $result->stdout . PHP_EOL;
        }
        return $result;
    }
}

<?php

namespace Lackey\Task;

use Lackey\TaskInterface;
use Lackey\Task\Shell\Command;

abstract class AbstractShellTask extends AbstractTask
{

    protected function exec(array $config = array())
    {
        $command = new Command($config);
        $result  = $command->run();
        $cufa    = $result->toCufa();
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

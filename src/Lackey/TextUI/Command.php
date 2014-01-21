<?php

namespace Lackey\TextUI;

use Colors\Color;
use Lackey\Lackey;

class Command
{

    protected static $optOptions = array(
        'T',    // Print the defined tasks
    );

    protected static $optLongopts = array(

    );

    protected $task;

    protected $opts;

    protected $cwd;

    public function __construct($task, array $opts = array(), $cwd = null)
    {
        $this->task = $task;
        $this->opts = $opts;
        $this->cwd  = isset($cwd) ? $cwd : getcwd();
    }

    public static function main($argv = null)
    {
        if (is_null($argv)) {
            $argv = $_SERVER['argv'];
        }
        $task    = isset($argv[1]) ? $argv[1] : 'default';
        $opts    = call_user_func('getopt', implode('', static::$optOptions), static::$optLongopts);
        $command = new static($task, $opts);
        $status  = $command->run();
        return $status;
    }

    public static function getLackeyInstance()
    {
        $lackey = Lackey::getInstance();
        if (is_null($lackey)) {
            throw new LackeyNotInitializedException('A Lackey instance has not yet been initialized');
        }
        return $lackey;
    }

    public static function printTasks()
    {
        $lackey = static::getLackeyInstance();
        echo '-T option received.  Listing available tasks.' . PHP_EOL . PHP_EOL;
        foreach ($lackey->getDescriptions() as $task => $spec) {
            $description = $spec['description'];
            $subtasks    = $spec['subtasks'];
            echo "$task\t\t$description" . PHP_EOL;
            if (!empty($subtasks)) {
                foreach ($subtasks as $subTask) {
                    echo "$task:$subTask" . PHP_EOL;
                }
            }
        }
        echo PHP_EOL;
    }

    public function run()
    {
        $status = 0;
        if ($this->isOptSet('T')) {
            static::printTasks();
        } else {
            $lackey = static::getLackeyInstance();
            $result = $lackey->run($this->task);
            $status = $result->getStatus();
        }
        return $status;
    }

    public function isOptSet($name)
    {
        return isset($this->opts[$name]);
    }

    public function getOpt($name)
    {
        return $this->isOptSet($name) ? $this->opts[$name] : false;
    }
}

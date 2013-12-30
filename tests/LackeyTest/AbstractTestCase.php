<?php

namespace LackeyTest;

use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{

    protected function captureOut(\Closure $closure)
    {
        ob_start();
        call_user_func($closure);
        return ob_get_clean();
    }
}

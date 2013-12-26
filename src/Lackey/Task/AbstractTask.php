<?php

namespace Lackey\Task;

use Doctrine\Common\Inflector\Inflector;
use Lackey\Task;

abstract class AbstractTask implements Task
{

    public function getName()
    {
        return str_replace('_', '-', Inflector::tableize(get_called_class()));
    }
}

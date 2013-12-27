<?php

namespace Lackey\Task;

use Doctrine\Common\Inflector\Inflector;
use Lackey\Task;

abstract class AbstractTask implements Task
{

    public function getDescription()
    {
        if (isset($this->description)) {
            return $this->description;
        } else {
            return '';
        }
    }

    public function getName()
    {
        if (isset($this->name)) {
            return $this->name;
        } else {
            $class = explode('\\', str_replace('_', '-', Inflector::tableize(get_called_class())));
            return end($class);
        }
    }
}

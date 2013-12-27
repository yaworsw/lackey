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
            return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '-$1', @end(explode('\\', get_called_class()))));
        }
    }
}

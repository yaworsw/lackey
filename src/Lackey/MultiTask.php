<?php

namespace Lackey;

abstract class MultiTask extends Task implements MultiTaskInterface
{

    final public function runAll(array $options = array())
    {
        return array_map($options, array($this, 'run'));
    }
}

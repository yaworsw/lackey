<?php

namespace Lackey\Task;

class AbstractResult extends Result
{

    public function getStatus()
    {
        return $this->status;
    }
}

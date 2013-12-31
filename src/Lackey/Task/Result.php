<?php

namespace Lackey\Task;

abstract class Result implements ResultInterface
{

    public function isError()
    {
        return $this->getStatus() !== 0;
    }
}

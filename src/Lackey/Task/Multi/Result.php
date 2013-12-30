<?php

namespace Lackey\Task\Multi;

use Lackey\Task\ResultInterface;

class Result implements ResultInterface
{

    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function getStatus()
    {
        foreach ($this->results as $result) {
            $status = $result->getStatus();
            if ($status !== 0) {
                return $status;
            }
        }
        return 0;
    }
}

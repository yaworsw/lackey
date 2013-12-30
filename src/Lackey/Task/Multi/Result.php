<?php

namespace Lackey\Task\Multi;

use Lackey\Task;

class Result extends Task\AbstractResult
{

    protected $results = array();

    protected $status  = 0;

    public function add(Task\ResultInterface $r = null)
    {
        if (!is_null($r)) {
            $this->results[] = $r;
            if ($this->status == 0) {
                $status = $r->getStatus();
                if ($status != 0) {
                    $this->status = $status;
                }
            }
        }
    }
}

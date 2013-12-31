<?php

namespace Lackey\Task;

interface ResultInterface
{

    public function getStatus();

    public function isError();
}

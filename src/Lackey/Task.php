<?php

namespace Lackey;

interface Task
{

    public function run(array $options = array());

    public function getName();

    public function getDescription();
}

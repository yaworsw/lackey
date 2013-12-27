<?php

namespace Lackey;

interface TaskInterface
{

    public function getName();

    public function getDescription();

    public function run(array $options = array());
}

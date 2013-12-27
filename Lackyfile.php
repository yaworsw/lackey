<?php

include __DIR__ . '/vendor/autoload.php';

use Lackey\Task;

$lackey = new \Lackey\Lackey();

$lackey->loadTask(new Task\Exec(), array(
    'phpunit' => array(
        'command' => './vendor/bin/phpunit -c tests/phpunit.xml',
    ),
));


$lackey->alias('default', 'Builds the application.', array(
    'exec',
));

<?php

include __DIR__ . '/vendor/autoload.php';

use Lackey\Task;

$lackey = new \Lackey\Lackey();

$lackey->loadTask(new Task\Exec(), array(
    'phpunit' => array(
        'command' => 'vendor/bin/phpunit -c tests/phpunit.xml',
    ),
));

$lackey->task('say-hello', 'Says hello to the world.  But really just to yourself.', function () {
    echo 'Hello World!';
});


$lackey->alias('default', 'Builds the application.', array(
    'say-hello', 'exec:phpunit',
));

<?php

include __DIR__ . '/vendor/autoload.php';

use Lackey\Task;

$lackey = new \Lackey\Lackey();

$lackey->loadTask(new Task\Exec(), array(
    'phpunit' => array(
        'command' => 'vendor/bin/phpunit -c tests/phpunit.xml',
    ),
    'ls' => array(
        'command' => 'ls',
    ),
));

$lackey->task('say-hello', 'Says hello to the world.  But really just to yourself.', function () {
    echo "Hello World!\n\n";
});


$lackey->alias('default', 'Default command.', array(
    'say-hello', 'exec:phpunit',
));

$lackey->alias('build', 'Builds the application.', array(
    'exec:phpunit',
));

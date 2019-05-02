<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\GeneratePassword;

$application = new Application();

$application->add(new GeneratePassword());
$application->run();

#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use AppBundle\Command\GetAlbumsCommand;

$application = new Application();

// register app:get-albums commands
$application->add(new GetAlbumsCommand());
$application->run();
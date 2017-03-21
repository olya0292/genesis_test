#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use AppBundle\Command\GetAlbumsCommand;
use AppBundle\Command\ListUserCommand;

$application = new Application();

// register app:get-albums commands
$application->add(new GetAlbumsCommand());

// register app:list-users commands
$application->add(new ListUserCommand());

$application->run();
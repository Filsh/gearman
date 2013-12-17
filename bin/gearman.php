#!/usr/bin/env php
<?php

if(!function_exists("posix_kill")){
    trigger_error("The function posix_kill was not found. Please ensure POSIX functions are installed");
}

if(!function_exists("pcntl_fork")){
    trigger_error("The function pcntl_fork was not found. Please ensure Process Control functions are installed");
}

(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';

use Symfony\Component\Console\Application;
use GearmanHandler\Command\Start as StartCommand;
use GearmanHandler\Command\Start as StopCommand;
use GearmanHandler\Command\Start as RestartCommand;

$application = new Application();
$application->add(new StartCommand);
$application->add(new StopCommand);
$application->add(new RestartCommand);
$application->run();

#!/usr/bin/env php
<?php

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

/**
 * @var ContainerInterface $container
 */
$container = require 'config/container.php';

$cli = new Application('Application console');

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command)
{
	$cli->add($container->get($command));
}

$cli->run();
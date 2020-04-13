<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

return [
	'environments' => [
		'default_migrations_table' => 'migrations',
		'default_database' => 'app',
		'app' => [
			'adapter' => 'sqlite',
			'name' => $container->get('config')['phinx']['db'],
			'connection' => $container->get(PDO::class),
		],
	],
	'paths' => [
		'migrations' => 'db/migrations/',
		'seeds' => 'db/seeds'
	]
];
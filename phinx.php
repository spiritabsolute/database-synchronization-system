<?php

require __DIR__.'/vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__.'/config/container.php';

return [
	'environments' => [
		'default_migrations_table' => 'migrations',
		'default_database' => 'app',
		'app' => [
			'adapter' => 'sqlite',
			'name' => $container->get('config')['phinx'][$dbName],
			'connection' => $container->get($dbName),
		],
	],
	'paths' => [
		'migrations' => 'db/migrations/'.$dbName,
		'seeds' => 'db/seeds'
	]
];
<?php

use App\Console\Command\EmployeeCreateCommand;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			EmployeeCreateCommand::class => function (ContainerInterface $container) {
				return new EmployeeCreateCommand($container);
			},
		],
	],
	'console' => [
		'listDb' => [
			'db1' => 'db1',
			'db2' => 'db2'
		],
		'commands' => [
			EmployeeCreateCommand::class,
		],
	],
];
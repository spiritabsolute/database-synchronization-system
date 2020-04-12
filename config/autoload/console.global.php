<?php

use App\Console\Command\EmployeeCreate;
use App\Console\Command\Migration;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			EmployeeCreate::class => function (ContainerInterface $container) {
				return new EmployeeCreate($container);
			},
			Migration::class => function (ContainerInterface $container) {
				return new Migration($container);
			},
		],
	],
	'console' => [
		'listDb' => [
			'db1' => 'db1',
			'db2' => 'db2'
		],
		'commands' => [
			Migration::class,
			EmployeeCreate::class,
		],
	],
];
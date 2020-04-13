<?php

use App\Command\EmployeeCreate;
use App\Command\Migration;
use App\Command\SyncConsume;
use App\Command\SyncProduce;
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
			SyncProduce::class => function (ContainerInterface $container) {
				return new SyncProduce($container);
			},
			SyncConsume::class => function (ContainerInterface $container) {
				return new SyncConsume($container);
			},
		],
	],
	'console' => [
		'commands' => [
			Migration::class,
			EmployeeCreate::class,
			SyncProduce::class,
			SyncConsume::class
		],
	],
];
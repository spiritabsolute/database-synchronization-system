<?php

use App\Command\EmployeeCreate;
use App\Command\EmployeeDelete;
use App\Command\EmployeeGetList;
use App\Command\EmployeeUpdate;
use App\Command\Migration;
use App\Command\SyncConsume;
use App\Command\SyncGetList;
use App\Command\SyncProduce;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			Migration::class => function (ContainerInterface $container) {
				return new Migration($container);
			},
			SyncGetList::class => function (ContainerInterface $container) {
				return new SyncGetList($container);
			},
			SyncProduce::class => function (ContainerInterface $container) {
				return new SyncProduce($container);
			},
			SyncConsume::class => function (ContainerInterface $container) {
				return new SyncConsume($container);
			},
			EmployeeCreate::class => function (ContainerInterface $container) {
				return new EmployeeCreate($container);
			},
			EmployeeGetList::class => function (ContainerInterface $container) {
				return new EmployeeGetList($container);
			},
			EmployeeUpdate::class => function (ContainerInterface $container) {
				return new EmployeeUpdate($container);
			},
			EmployeeDelete::class => function (ContainerInterface $container) {
				return new EmployeeDelete($container);
			},
		],
	],
	'console' => [
		'commands' => [
			Migration::class,
			SyncGetList::class,
			SyncProduce::class,
			SyncConsume::class,
			EmployeeCreate::class,
			EmployeeGetList::class,
			EmployeeUpdate::class,
			EmployeeDelete::class,
		],
	],
];
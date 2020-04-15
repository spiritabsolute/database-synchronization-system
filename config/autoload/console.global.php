<?php

use App\Command\EmployeeCreate;
use App\Command\EmployeeDelete;
use App\Command\EmployeeGetList;
use App\Command\EmployeeUpdate;
use App\Command\Migration;
use App\Command\OutletCreate;
use App\Command\OutletDelete;
use App\Command\OutletGetList;
use App\Command\OutletUpdate;
use App\Command\SkuCreate;
use App\Command\SkuDelete;
use App\Command\SkuGetList;
use App\Command\SkuUpdate;
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
			OutletCreate::class => function (ContainerInterface $container) {
				return new OutletCreate($container);
			},
			OutletGetList::class => function (ContainerInterface $container) {
				return new OutletGetList($container);
			},
			OutletUpdate::class => function (ContainerInterface $container) {
				return new OutletUpdate($container);
			},
			OutletDelete::class => function (ContainerInterface $container) {
				return new OutletDelete($container);
			},
			SkuCreate::class => function (ContainerInterface $container) {
				return new SkuCreate($container);
			},
			SkuGetList::class => function (ContainerInterface $container) {
				return new SkuGetList($container);
			},
			SkuUpdate::class => function (ContainerInterface $container) {
				return new SkuUpdate($container);
			},
			SkuDelete::class => function (ContainerInterface $container) {
				return new SkuDelete($container);
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
			OutletCreate::class,
			OutletGetList::class,
			OutletUpdate::class,
			OutletDelete::class,
			SkuCreate::class,
			SkuGetList::class,
			SkuUpdate::class,
			SkuDelete::class,
		],
	],
];
<?php

use App\CustomCommand\OwnerDelete;
use App\CustomCommand\OwnerCreate;
use App\CustomCommand\OwnerGetList;
use App\CustomCommand\OwnerUpdate;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			OwnerCreate::class => function (ContainerInterface $container) {
				return new OwnerCreate($container);
			},
			OwnerGetList::class => function (ContainerInterface $container) {
				return new OwnerGetList($container);
			},
			OwnerUpdate::class => function (ContainerInterface $container) {
				return new OwnerUpdate($container);
			},
			OwnerDelete::class => function (ContainerInterface $container) {
				return new OwnerDelete($container);
			},
		],
	],
	'console' => [
		'commands' => [
			OwnerCreate::class,
			OwnerGetList::class,
			OwnerUpdate::class,
			OwnerDelete::class,
		],
	],
];
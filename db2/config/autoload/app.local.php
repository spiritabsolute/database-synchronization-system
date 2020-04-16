<?php

return [
	'app' => 'db2',
	'rabbit' => [
		'queue' => 'db2',
		'target_queue' => 'db1',
		'consumer' => 'db2',
	],
	'migration' => [
		'demo' => [
			'employees' => [
				[
					'name' => 'Diana'
				],
				[
					'name' => 'Darinusya'
				]
			],
			'outlets' => [
				[
					'name' => 'Flowers',
					'owner_name' => 'Marina'
				]
			],
			'sku' => [
				[
					'name' => 'Rose',
					'stock' => '63'
				],
				[
					'name' => 'Tulip',
					'stock' => '327'
				]
			]
		]
	]
];
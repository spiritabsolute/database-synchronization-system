<?php

return [
	'app' => 'db1',
	'rabbit' => [
		'queue' => 'db1',
		'target_queue' => 'db2',
		'consumer' => 'db1',
	],
	'migration' => [
		'demo' => [
			'employees' => [
				[
					'name' => 'Ivan'
				],
				[
					'name' => 'Pavel'
				]
			],
			'outlets' => [
				[
					'name' => 'Steam',
					'owner_name' => 'Valve'
				]
			],
			'sku' => [
				[
					'name' => 'Mount&Blade',
					'stock' => '1'
				],
				[
					'name' => 'PhPStorm',
					'stock' => '3'
				]
			]
		]
	]
];
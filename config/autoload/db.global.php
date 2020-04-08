<?php
use Infrastructure\App\PDOFactory as PDOFactory;

return [
	'dependencies' => [
		'factories' => [
			'db1' => PDOFactory::class,
			'db2' => PDOFactory::class,
		]
	],
	'db1_config' => [
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	],
	'db2_config' => [
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	]
];
<?php
use Infrastructure\App\PDOFactory as PDOFactory;

return [
	'dependencies' => [
		'factories' => [
			PDO::class => PDOFactory::class,
		]
	],
	'db' => [
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	],
];
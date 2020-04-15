<?php

return [
	'db' => [
		'dsn' => 'sqlite:db/db.sq3',
		'username' => '',
		'password' => '',
	],
	'rabbit' => [
		'host' => 'rabbitmq',
		'port' => 5672,
		'user' => 'guest',
		'password' => 'guest',
	],
	'phinx' => [
		'db' => 'db/db',
	]
];
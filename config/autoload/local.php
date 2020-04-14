<?php

return [
	"debug" => true,
	"auth" => [
		"users" => [
			"admin" => "password"
		]
	],
	'db' => [
		'dsn' => 'sqlite:db/db.sqlite3',
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
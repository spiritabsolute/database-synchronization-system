<?php

use App\Http\Middleware\BasicAuth;
use Psr\Container\ContainerInterface;

return [
	"dependencies" => [
		"factories" => [
			BasicAuth::class => function (ContainerInterface $container) {
				return new BasicAuth($container->get("config")["auth"]["users"]);
			},
		]
	],
	"auth" => [
		"users" => []
	]
];
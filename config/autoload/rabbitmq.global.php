<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			AMQPStreamConnection::class => function (ContainerInterface $container) {
				$config = $container->get("config")["rabbit"];
				return new AMQPStreamConnection(
					$config['host'],
					$config['port'],
					$config['user'],
					$config['password']
				);
			},
		]
	]
];
<?php
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
	"dependencies" => [
		"factories" => [
			"factories" => [
				LoggerInterface::class => function (ContainerInterface $container) {
					$logger = new Logger("App");
					$logger->pushHandler(new Monolog\Handler\StreamHandler(
						"logs/application.log",
						($container->get("config")["debug"] ? Logger::DEBUG : Logger::WARNING)
					));
					return $logger;
				},
			]

		]
	]
];
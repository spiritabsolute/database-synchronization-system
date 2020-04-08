<?php
use Infrastructure\Framework\Http\Middleware\ErrorHandler\BaseErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\ErrorHandler;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Template\TemplateRenderer;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
	"dependencies" => [
		"factories" => [
			ErrorHandler::class => function (ContainerInterface $container) {
				return new ErrorHandler(
					$container->get(ErrorResponseGenerator::class),
					$container->get(LoggerInterface::class)
				);
			},
			ErrorResponseGenerator::class => function (ContainerInterface $container) {
				if ($container->get("config")["debug"])
				{
					return new WhoopsErrorResponseGenerator(
						$container->get(Whoops\RunInterface::class),
						new Zend\Diactoros\Response()
					);
				}
				return new BaseErrorResponseGenerator(
					$container->get(TemplateRenderer::class),
					new Zend\Diactoros\Response(),
					["404" => "error/404", "error" => "error/error"]
				);
			},
			Whoops\RunInterface::class => function () {
				$whoops = new Whoops\Run();
				$whoops->writeToOutput(false);
				$whoops->allowQuit(false);
				$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
				$whoops->register();
				return $whoops;
			},
			LoggerInterface::class => function (ContainerInterface $container) {
				$logger = new Logger("App");
				$logger->pushHandler(new Monolog\Handler\StreamHandler(
					"../logs/application.log",
					($container->get("config")["debug"] ? Logger::DEBUG : Logger::WARNING)
				));
				return $logger;
			},
		]
	]
];
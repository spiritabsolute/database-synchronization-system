<?php
use App\Http\Middleware;
use Framework\Http\Application;
use Framework\Http\Pipeline\Resolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Psr\Container\ContainerInterface;
use Laminas\Diactoros\Response;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
	"debug" => true,
	"dependencies" => [
		"abstract_factories" => [
			ReflectionBasedAbstractFactory::class
		],
		"factories" => [
			Application::class => function (ContainerInterface $container) {
				return new Application(
					$container->get(Resolver::class),
					$container->get(Router::class),
					$container->get(Middleware\PageNotFound::class)
				);
			},
			Router::class => function () {
				return new AuraRouterAdapter(new Aura\Router\RouterContainer());
			},
			Resolver::class => function (ContainerInterface $container) {
				return new Resolver($container, $container->get(Response::class));
			},
		]
	]
];
<?php
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
			Router::class => function () {
				return new AuraRouterAdapter(new Aura\Router\RouterContainer());
			},
			Resolver::class => function (ContainerInterface $container) {
				return new Resolver($container, $container->get(Response::class));
			},
		]
	]
];
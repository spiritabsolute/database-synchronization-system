<?php
use Framework\Template\TemplateRenderer;
use Framework\Template\Twig\Extension\Route;
use Framework\Template\Twig\TwigRenderer;
use Psr\Container\ContainerInterface;

return [
	"templates" => [
		"extension" => ".html.twig"
	],
	"twig" => [
		"template_dir" => "../templates/twig",
		"cache_dir" => "../cache/twig",
		"extensions" => [
			Route::class
		]
	],
	"dependencies" => [
		"factories" => [
			TemplateRenderer::class => function (ContainerInterface $container) {
				return new TwigRenderer(
					$container->get(Twig\Environment::class),
					$container->get("config")["templates"]["extension"]
				);
			},
			Twig\Environment::class => function (ContainerInterface $container) {
				$debug = $container->get("config")["debug"];
				$config = $container->get("config")["twig"];

				$loader = new Twig\Loader\FilesystemLoader();
				$loader->addPath($config["template_dir"]);

				$environment = new Twig\Environment($loader, [
					"debug" => $debug,
					"cache" => ($debug ? false : $config["cache_dir"]),
					"strict_variables" => $debug,
					"auto_reload" => $debug
				]);

				if ($debug)
				{
					$environment->addExtension(new Twig\Extension\DebugExtension());
				}

				foreach ($config["extensions"] as $extension)
				{
					$environment->addExtension($container->get($extension));
				}

				return $environment;
			},
		]
	]
];
<?php
namespace Framework\Template\Twig\Extension;

use Framework\Http\Router\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Route extends AbstractExtension
{
	private $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction("generatePath", [$this, "generatePath"])
		];
	}

	public function generatePath($name, array $params = []): string
	{
		return $this->router->generate($name, $params);
	}
}
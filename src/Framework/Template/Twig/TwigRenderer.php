<?php
namespace Framework\Template\Twig;

use Framework\Template\TemplateRenderer;

class TwigRenderer implements TemplateRenderer
{
	/**
	 * @var \Twig\Environment
	 */
	private $twig;
	private $extension;

	public function __construct(\Twig\Environment $twig, $extension)
	{
		$this->twig = $twig;
		$this->extension = $extension;
	}

	public function render($view, $params = []): string
	{
		return $this->twig->render($view.$this->extension, $params);
	}
}
<?php
namespace App\Http\Action;

use App\Http\Middleware\BasicAuth;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class Cabinet implements RequestHandlerInterface
{
	private $templateRenderer;

	public function __construct(TemplateRenderer $templateRenderer)
	{
		$this->templateRenderer = $templateRenderer;
	}

	/**
	 * Handles a request and produces a response.
	 *
	 * May call other collaborating code to generate the response.
	 *
	 * @param ServerRequestInterface $request
	 *
	 * @return ResponseInterface
	 */
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$username = $request->getAttribute(BasicAuth::ATTRIBUTE);
		return new HtmlResponse($this->templateRenderer->render("app/cabinet", [
			"username" => $username
		]));
	}
}
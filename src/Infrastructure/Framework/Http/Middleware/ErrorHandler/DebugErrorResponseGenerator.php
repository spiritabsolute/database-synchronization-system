<?php
namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DebugErrorResponseGenerator implements ErrorResponseGenerator
{
	private $templateRenderer;
	private $response;
	private $view;

	public function __construct(TemplateRenderer $templateRenderer, ResponseInterface $response, string $view)
	{
		$this->templateRenderer = $templateRenderer;
		$this->response = $response;
		$this->view = $view;
	}

	public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
	{
		$response = $this->response->withStatus($this->getStatusCode($exception));

		$response->getBody()->write($this->templateRenderer->render($this->view, [
			"request" => $request,
			"exception" => $exception
		]));

		return $response;
	}

	private function getStatusCode(\Throwable $exception): int
	{
		$code = $exception->getCode();
		if ($code >= 400 && $code < 600)
		{
			return $code;
		}
		return 500;
	}
}
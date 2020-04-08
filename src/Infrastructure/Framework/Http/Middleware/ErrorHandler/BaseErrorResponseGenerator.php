<?php
namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BaseErrorResponseGenerator implements ErrorResponseGenerator
{
	private $templateRenderer;
	private $response;
	private $views = [];

	public function __construct(TemplateRenderer $templateRenderer, ResponseInterface $response, $views)
	{
		$this->templateRenderer = $templateRenderer;
		$this->response = $response;
		$this->views = $views;
	}

	public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
	{
		$code = $this->getStatusCode($exception);

		$response = $this->response->withStatus($code);
		$response->getBody()->write($this->templateRenderer->render($this->getView($code), [
			"request" => $request,
			"exception" => $exception
		]));

		return $response;
	}

	private function getView($code): string
	{
		return (array_key_exists($code, $this->views) ? $this->views[$code] : $this->views["error"]);
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
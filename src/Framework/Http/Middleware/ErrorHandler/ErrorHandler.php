<?php
namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ErrorHandler implements MiddlewareInterface
{
	private $generate;
	private $logger;

	public function __construct(ErrorResponseGenerator $generate, LoggerInterface $logger)
	{
		$this->generate = $generate;
		$this->logger = $logger;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try
		{
			return $handler->handle($request);
		}
		catch (\Throwable $exception)
		{
			$this->logger->error($exception->getMessage(), [
				"exception" => $exception,
				"request" => [
					"method" => $request->getMethod(),
					"url" => $request->getUri(),
					"server" => $request->getServerParams(),
					"cookies" => $request->getCookieParams(),
					"body" => $request->getParsedBody(),
				]
			]);
			return $this->generate->generate($request, $exception);
		}
	}
}
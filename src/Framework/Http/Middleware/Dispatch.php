<?php
namespace Framework\Http\Middleware;

use Framework\Http\Pipeline\Resolver;
use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatch implements MiddlewareInterface
{
	private $resolver;

	public function __construct(Resolver $resolver)
	{
		$this->resolver = $resolver;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		/** @var Result $result */
		if (!$result = $request->getAttribute(Result::class)) {
			return $handler->handle($request);
		}
		$middleware = $this->resolver->resolve($result->getHandler());
		return $middleware->process($request, $handler);
	}
}
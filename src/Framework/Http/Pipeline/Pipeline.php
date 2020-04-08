<?php
namespace Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
	private $queue;

	public function __construct()
	{
		$this->queue = new \SplQueue();
	}

	public function pipe($middleware): void
	{
		$this->queue->enqueue($middleware);
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $default): ResponseInterface
	{
		return $this->next($request, $response, $default);
	}

	private function next(ServerRequestInterface $request, ResponseInterface $response, callable $default): ResponseInterface
	{
		if ($this->queue->isEmpty())
		{
			return $default($request);
		}

		$current = $this->queue->dequeue();

		return $current($request, $response, function (ServerRequestInterface $request) use ($response, $default) {
			return $this->next($request, $response, $default);
		});
	}
}
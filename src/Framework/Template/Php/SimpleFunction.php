<?php
namespace Framework\Template\Php;

class SimpleFunction
{
	private $name;
	private $callback;
	private $needRenderer;

	public function __construct(string $name, callable $callback, bool $needRenderer = false)
	{
		$this->name = $name;
		$this->callback = $callback;
		$this->needRenderer = $needRenderer;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function isNeedRenderer(): bool
	{
		return $this->needRenderer;
	}

	public function getCallback(): callable
	{
		return $this->callback;
	}
}
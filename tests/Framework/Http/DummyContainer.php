<?php
namespace Tests\Framework\Http;

use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceManager;

class DummyContainer extends ServiceManager
{
	public function get($id)
	{
		if (!class_exists($id))
		{
			throw new ServiceNotFoundException($id);
		}
		return new $id();
	}

	public function has($id): bool
	{
		return class_exists($id);
	}
}
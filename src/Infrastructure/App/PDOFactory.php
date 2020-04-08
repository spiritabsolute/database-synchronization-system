<?php
namespace Infrastructure\App;

use PDO;
use PDOException;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class PDOFactory
{
	private $pdo;

	public function __invoke(ContainerInterface $container, $requestedName)
	{
		try
		{
			if ($this->pdo == null)
			{
				$config = $container->get('config')[$requestedName.'_config'];
				$this->pdo = new PDO(
					$config['dsn'],
					$config['username'],
					$config['password'],
					$config['options']
				);
			}
			return $this->pdo;
		}
		catch (PDOException $exception)
		{
			$logger = $container->get(LoggerInterface::class);
			$logger->addError($exception->getMessage());
		}
	}
}
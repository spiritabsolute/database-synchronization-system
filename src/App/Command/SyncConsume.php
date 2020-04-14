<?php
namespace App\Command;

use App\SyncQueueManager;
use App\SyncManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncConsume extends Command
{
	private $container;

	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($name);

		$this->container = $container;
	}

	protected function configure()
	{
		parent::configure();

		$this->setName('app:consume-sync');
		$this->setDescription('Starts synchronization between databases');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Start database synchronization</comment>');

		$pdo = $this->container->get(\PDO::class);

		$config = $this->container->get('config')['rabbit'];

		$syncDataManager = new SyncQueueManager($pdo);
		$syncSourceManager = new SyncManager($config, $syncDataManager);
		$syncSourceManager->consume();

		$output->writeln('<info>Done!</info>');

		return 0;
	}
}
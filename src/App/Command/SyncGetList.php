<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\Storage;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncGetList extends Command
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

		$this->setName('app:get-list-sync');
		$this->setDescription('Get list sync queue');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>List sync queue</comment>');

		$pdo = $this->container->get(\PDO::class);

		$storage = new Storage($pdo, 'sync_queue');

		$table = new Table($output);
		$table->setRows($storage->getList([]));

		$table->render();

		return 0;
	}
}
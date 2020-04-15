<?php
namespace App\Command;

use App\Entity\OutletManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutletGetList extends Command
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

		$this->setName('app:outlet-get-list');
		$this->setDescription('Get list outlets');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>List outlets</comment>');

		$pdo = $this->container->get(\PDO::class);

		$entityManager = new OutletManager($pdo);

		$table = new Table($output);
		$table->setRows($entityManager->getList());

		$table->render();

		return 0;
	}
}
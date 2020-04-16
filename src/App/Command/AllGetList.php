<?php
namespace App\Command;

use App\Entity\SkuManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AllGetList extends Command
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

		$this->setName('app:all-get-list');
		$this->setDescription('Get list all items');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$getListCommand = $this->container->get(SyncGetList::class);
		$getListCommand->execute($input, $output);
		$getListCommand = $this->container->get(EmployeeGetList::class);
		$getListCommand->execute($input, $output);
		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);
		$getListCommand = $this->container->get(SkuGetList::class);
		$getListCommand->execute($input, $output);

		return 0;
	}
}
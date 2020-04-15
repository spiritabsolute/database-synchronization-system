<?php
namespace App\Command;

use App\Entity\SkuManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SkuGetList extends Command
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

		$this->setName('app:sku-get-list');
		$this->setDescription('Get list sku');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>List sku</comment>');

		$pdo = $this->container->get(\PDO::class);

		$skuManager = new SkuManager($pdo);

		$table = new Table($output);
		$table->setRows($skuManager->getList());

		$table->render();

		return 0;
	}
}
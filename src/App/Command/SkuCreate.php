<?php
namespace App\Command;

use App\Entity\SkuManager;
use App\Entity\SkuStockManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SkuCreate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:sku-create');
		$this->setDescription('Creates a new sku');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of sku');
		$this->addArgument('stock', InputArgument::OPTIONAL, 'The stock of sku');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Creating sku</comment>');

		$pdo = $this->container->get(\PDO::class);

		$skuManager = new SkuManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$skuManager->attach($syncQueueManager);

		$name = $this->getInput($input, $output, 'name', 'Input sku name: ');
		$stock = $this->getInput($input, $output, 'stock', 'Input sku stock: ');

		$fields = [
			'name' => $name,
			'stock' => $stock
		];

		if ($skuManager->add($fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(SkuGetList::class);
		$getListCommand->execute($input, $output);

		return 0;
	}
}
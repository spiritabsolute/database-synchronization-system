<?php
namespace App\Command;

use App\Entity\SkuManager;
use App\Entity\SkuStockManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SkuDelete extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:sku-delete');
		$this->setDescription('Delete a sku');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The sku id');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Deleting sku</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(SkuGetList::class);
		$getListCommand->execute($input, $output);

		$skuManager = new SkuManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$skuManager->attach($syncQueueManager);

		$id = $this->getInput($input, $output, 'id', 'Input sku id: ');

		if ($skuManager->delete($id))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand->execute($input, $output);

		return 0;
	}
}
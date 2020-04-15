<?php
namespace App\Command;

use App\Entity\SkuManager;
use App\Entity\SkuStockManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SkuUpdate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:sku-update');
		$this->setDescription('Update a sku');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The sku id');
		$this->addArgument('field', InputArgument::OPTIONAL, 'The field for update');
		$this->addArgument('value', InputArgument::OPTIONAL, 'The new value for field');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Updating sku</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(SkuGetList::class);
		$getListCommand->execute($input, $output);

		$skuManager = new SkuManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$skuManager->attach($syncQueueManager);

		$id = $this->getInput($input, $output, 'id', 'Input sku id: ');

		$field = $this->getChoicedField($skuManager, $input, $output);
		$value = $this->getInput($input, $output, 'value', 'Input value: ');
		$fields = [
			$field => $value
		];

		if ($skuManager->update($id, $fields))
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
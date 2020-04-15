<?php
namespace App\Command;

use App\CustomCommand\OwnerGetList;
use App\Entity\OutletManager;
use App\Entity\OwnerManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutletUpdate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:outlet-update');
		$this->setDescription('Updates an outlet');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of outlet');
		$this->addArgument('ownerName', InputArgument::OPTIONAL, 'The owner name of outlet');
		$this->addArgument('choice', InputArgument::OPTIONAL, 'Create a new owner or bind an existing one?');
		$this->addArgument('ownerId', InputArgument::OPTIONAL, 'The ownerId of outlet');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The owner id');
		$this->addArgument('field', InputArgument::OPTIONAL, 'The field for update');
		$this->addArgument('value', InputArgument::OPTIONAL, 'The new value for field');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Updating outlet</comment>');

		$pdo = $this->container->get(\PDO::class);

		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$outletManager->attach($syncQueueManager);

		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);

		$id = $this->getInput($input, $output, 'id', 'Input owner id: ');
		$field = $this->getChoicedField($outletManager, $input, $output);
		$value = $this->getInput($input, $output, 'value', 'Input value: ');
		$fields = [
			$field => $value
		];

		if ($outletManager->update($id, $fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);

		return 0;
	}
}
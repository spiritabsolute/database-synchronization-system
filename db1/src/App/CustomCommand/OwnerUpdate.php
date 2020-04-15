<?php
namespace App\CustomCommand;

use App\Entity\OutletManager;
use App\Entity\OwnerManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OwnerUpdate extends \App\Command\Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:owner-update');
		$this->setDescription('Updates an owner');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The owner id');
		$this->addArgument('field', InputArgument::OPTIONAL, 'The field for update');
		$this->addArgument('value', InputArgument::OPTIONAL, 'The new value for field');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Updating an owner</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(OwnerGetList::class);
		$getListCommand->execute($input, $output);

		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$outletManager->attach($syncQueueManager);

		$ownerManager = new OwnerManager($pdo, $outletManager);

		$id = $this->getInput($input, $output, 'id', 'Input owner id: ');
		$fields = $ownerManager->getList(['id' => $id]);
		if (empty($fields))
		{
			$output->writeln('<error>The entered owner does not exist!</error>');
			return 0;
		}
		$fields = current($fields);

		$updatedFields = $ownerManager->getUpdatedFields();
		$field = $this->getChoiceInput($input, $output, 'field', 'Select a field: ', $updatedFields);

		$value = $this->getInput($input, $output, 'value', 'Input value: ');

		$fields[$field] = $value;

		if ($ownerManager->update($id, $fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		return 0;
	}
}
<?php
namespace App\Command;

use App\CustomCommand\OwnerGetList;
use App\Entity\OutletManager;
use App\Entity\OwnerManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutletCreate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:outlet-create');
		$this->setDescription('Creates a new outlet');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of outlet');
		$this->addArgument('ownerName', InputArgument::OPTIONAL, 'The owner name of outlet');
		$this->addArgument('choice', InputArgument::OPTIONAL, 'Create a new owner or bind an existing one?');
		$this->addArgument('ownerId', InputArgument::OPTIONAL, 'The ownerId of outlet');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Creating outlet</comment>');

		$pdo = $this->container->get(\PDO::class);

		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);

		$outletManager->attach($syncQueueManager);

		if ($outletManager->isMultipleMode())
		{
			$this->executeMultipleScenario($outletManager, $input, $output);
		}
		else
		{
			$this->executeSingleScenario($outletManager, $input, $output);
		}

		return 0;
	}

	private function executeMultipleScenario(OutletManager $outletManager, InputInterface $input, OutputInterface $output)
	{
		$name = $this->getInput($input, $output, 'name', 'Input outlet name: ');
		$choice = $this->getChoiceInput($input, $output, 'choice',
			'Create a new owner or bind an existing one?: ', ['new' => 'new', 'existing' => 'existing']);

		$fields = [
			'name' => $name,
		];

		if ($choice == 'new')
		{
			$fields['owner_name'] = $this->getInput($input, $output, 'ownerName', 'Input owner name: ');
		}
		else
		{
			$ownerId = $this->getInput($input, $output, 'ownerId', 'Input ownerId: ');

			$pdo = $this->container->get(\PDO::class);
			$ownerManager = new OwnerManager($pdo);
			if (!$ownerManager->existOwner(['owner_id' => $ownerId]))
			{
				$output->writeln('<error>The entered owner does not exist!</error>');
				return 0;
			}
			$fields['owner_id'] = $ownerId;
			$fields['owner_name'] = $ownerManager->getOwnerName($ownerId);
		}

		if ($outletManager->add($fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);
		$getListCommand = $this->container->get(OwnerGetList::class);
		$getListCommand->execute($input, $output);
	}

	private function executeSingleScenario(OutletManager $outletManager, InputInterface $input, OutputInterface $output)
	{
		$name = $this->getInput($input, $output, 'name', 'Input outlet name: ');
		$ownerName = $this->getInput($input, $output, 'ownerName', 'Input owner name: ');

		if ($outletManager->add(['name' => $name, 'owner_name' => $ownerName]))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);
	}
}
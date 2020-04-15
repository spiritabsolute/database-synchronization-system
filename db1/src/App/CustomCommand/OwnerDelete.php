<?php
namespace App\CustomCommand;

use App\Entity\OutletManager;
use App\Entity\OwnerManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OwnerDelete extends \App\Command\Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:owner-delete');
		$this->setDescription('Delete an owner');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The employee id');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Deleting owner</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(OwnerGetList::class);
		$getListCommand->execute($input, $output);

		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$outletManager->attach($syncQueueManager);

		$ownerManager = new OwnerManager($pdo, $outletManager);

		$id = $this->getInput($input, $output, 'id', 'Input owner id: ');

		if ($ownerManager->delete($id))
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
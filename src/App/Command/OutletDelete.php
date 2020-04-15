<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\Entity\OutletManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutletDelete extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:outlet-delete');
		$this->setDescription('Delete an outlet');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The outlet id');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Deleting an outlet</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(OutletGetList::class);
		$getListCommand->execute($input, $output);

		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$outletManager->attach($syncQueueManager);

		$id = $this->getInput($input, $output, 'id', 'Input employee id: ');

		if ($outletManager->delete($id))
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
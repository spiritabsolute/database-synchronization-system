<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmployeeDelete extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:delete-employee');
		$this->setDescription('Delete a employee');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The employee id');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Deleting employee</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(EmployeeGetList::class);
		$getListCommand->execute($input, $output);

		$entityManager = new EmployeeManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$entityManager->attach($syncQueueManager);

		$id = $this->getInput($input, $output, 'id', 'Input employee id: ');

		if ($entityManager->delete($id))
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
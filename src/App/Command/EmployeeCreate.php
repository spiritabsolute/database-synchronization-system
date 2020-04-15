<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmployeeCreate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:employee-create');
		$this->setDescription('Creates a new employee');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of employee');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Creating employee</comment>');

		$pdo = $this->container->get(\PDO::class);

		$entityManager = new EmployeeManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);

		$entityManager->attach($syncQueueManager);

		$name = $this->getInput($input, $output, 'name', 'Input employee name: ');

		$fields = [
			'name' => $name,
		];

		if ($entityManager->add($fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(EmployeeGetList::class);
		$getListCommand->execute($input, $output);

		return 0;
	}
}
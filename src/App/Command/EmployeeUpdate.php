<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\SyncQueueManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmployeeUpdate extends Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:employee-update');
		$this->setDescription('Update a employee');

		$this->addArgument('id', InputArgument::OPTIONAL, 'The employee id');
		$this->addArgument('field', InputArgument::OPTIONAL, 'The field for update');
		$this->addArgument('value', InputArgument::OPTIONAL, 'The new value for field');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Updating employee</comment>');

		$pdo = $this->container->get(\PDO::class);

		$getListCommand = $this->container->get(EmployeeGetList::class);
		$getListCommand->execute($input, $output);

		$entityManager = new EmployeeManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$entityManager->attach($syncQueueManager);

		$id = $this->getInput($input, $output, 'id', 'Input employee id: ');

		$field = $this->getChoicedField($entityManager, $input, $output);
		$value = $this->getInput($input, $output, 'value', 'Input value: ');
		$fields[$field] = $value;

		if ($entityManager->update($id, $fields))
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
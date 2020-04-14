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

		$this->setName('app:update-employee');
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
		$fields = $entityManager->getFields($id);

		$updatedFields = $entityManager->getUpdatedFields();
		$field = $this->getChoiceInput($input, $output, 'field', 'Select a field: ', $updatedFields);

		$value = $this->getInput($input, $output, 'value', 'Input value: ');

		$fields[$field] = $value;

		$entityManager->setFields($fields);
		if ($entityManager->update($id))
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
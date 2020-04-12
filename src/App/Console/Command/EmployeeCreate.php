<?php
namespace App\Console\Command;

use App\EntityManager;
use App\Storage;
use App\SyncDataManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class EmployeeCreate extends Base
{
	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($container, $name);
	}

	protected function configure()
	{
		parent::configure();

		$this->setName('app:create-employee');
		$this->setDescription('Creates a new employee');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of employee');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Creating employee</comment>');

		$db = $this->getDb($input, $output);

		$dbo = $this->container->get($db);

		$syncOutputStorage = new Storage($dbo, 'sync_output');
		$syncDataManager = new SyncDataManager($syncOutputStorage);

		$employeeStorage = new Storage($dbo, 'employee');
		$entityManager = new EntityManager($employeeStorage, $syncDataManager);

		$name = $input->getArgument('name');
		if (empty($name))
		{
			$question = new Question('Input employee name: ');
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$name = $helper->ask($input, $output, $question);
		}

		$employeeClass = '\App\\'.ucfirst($db).'\Employee\Employee';
		$employee = new $employeeClass(time(), time(), $name);

		if ($entityManager->add($employee))
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
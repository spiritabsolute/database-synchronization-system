<?php
namespace App\Console\Command;

use App\EntityManager;
use App\Storage;
use App\SyncDataManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class EmployeeCreateCommand extends Command
{
	private $container;
	private $listDb;

	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($name);

		$this->container = $container;
		$this->listDb = $container->get('config')['console']['listDb'];
	}

	protected function configure()
	{
		$this->setName('app:create-employee');
		$this->setDescription('Creates a new employee');

		$this->addArgument('db', InputArgument::OPTIONAL, 'The list of available db');
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

	private function getDb(InputInterface $input, OutputInterface $output)
	{
		$db = $input->getArgument('db');
		if (empty($db))
		{
			$question = new ChoiceQuestion('Choose db', $this->listDb, 0);
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$db = $helper->ask($input, $output, $question);
		}
		return $db;
	}
}
<?php
namespace App\Command;

use App\EntityManager;
use App\SyncDataManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class EmployeeCreate extends Command
{
	private $container;

	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($name);

		$this->container = $container;
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

		$pdo = $this->container->get($db);

		$employeeManagerClass = '\App\\'.ucfirst($db).'\EmployeeManager';
		/** @var EntityManager $entityManager */
		$entityManager = new $employeeManagerClass($pdo);
		$entityManager->setSyncDataManager(new SyncDataManager($pdo));

		$name = $this->getEmployeeName($input, $output);

		$entityManager->setFields([
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $name,
		]);

		if ($entityManager->add())
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		return 0;
	}

	private function getEmployeeName(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');
		if (empty($name))
		{
			$question = new Question('Input employee name: ');
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$name = $helper->ask($input, $output, $question);
		}
		return $name;
	}
}
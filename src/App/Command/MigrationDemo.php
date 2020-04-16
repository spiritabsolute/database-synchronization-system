<?php
namespace App\Command;

use App\Entity\EmployeeManager;
use App\Entity\OutletManager;
use App\Entity\SkuManager;
use App\SyncQueueManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MigrationDemo extends Command
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

		$this->setName('app:migrate-demo');
		$this->setDescription('Perform migrations that create a demo data');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Migrating demo data</comment>');

		$pdo = $this->container->get(\PDO::class);
		$demoData = $this->container->get('config')['migration']['demo'];

		$this->addEmployees($pdo, $demoData['employees'], $output);
		$this->addOutlets($pdo, $demoData['outlets'], $output);
		$this->addSku($pdo, $demoData['sku'], $output);

		return 0;
	}

	public function addEmployees(\PDO $pdo, array $employees, OutputInterface $output): void
	{
		$employeeManager = new EmployeeManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$employeeManager->attach($syncQueueManager);

		foreach ($employees as $employee)
		{
			$employeeManager->add($employee);
			$output->writeln('<info>'.EmployeeManager::class.': '.$employee['name'].' was created!</info>');
		}
	}

	public function addOutlets(\PDO $pdo, array $outlets, OutputInterface $output): void
	{
		$outletManager = new OutletManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$outletManager->attach($syncQueueManager);

		foreach ($outlets as $outlet)
		{
			$outletManager->add($outlet);
			$output->writeln('<info>'.OutletManager::class.': '.$outlet['name'].' was created!</info>');
		}
	}

	public function addSku(\PDO $pdo, array $listSku, OutputInterface $output): void
	{
		$skuManager = new SkuManager($pdo);
		$syncQueueManager = new SyncQueueManager($pdo);
		$skuManager->attach($syncQueueManager);

		foreach ($listSku as $sku)
		{
			$skuManager->add($sku);
			$output->writeln('<info>'.SkuManager::class.': '.$sku['name'].' was created!</info>');
		}
	}
}
<?php
namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Migration extends Command
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

		$this->setName('app:migrate');
		$this->setDescription('Perform migrations that create a database structure');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Migrating database</comment>');

		$process = new Process([
			'vendor/bin/phinx',
			'migrate',
			'-c',
			'bin/phinx.php'
		]);

		$process->run();

		if (!$process->isSuccessful())
		{
			throw new ProcessFailedException($process);
		}

		echo $process->getOutput();

		return 0;
	}
}
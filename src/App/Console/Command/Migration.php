<?php
namespace App\Console\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Migration extends Base
{
	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($container, $name);
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

		$db = $this->getDb($input, $output);

		$process = new Process([
			'vendor/bin/phinx',
			'migrate',
			'-c',
			$db.'.php'
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
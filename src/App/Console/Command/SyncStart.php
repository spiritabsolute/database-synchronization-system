<?php
namespace App\Console\Command;

use App\Storage;
use App\SyncDataManager;
use App\SyncManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class SyncStart extends Base
{
	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($container, $name);
	}

	protected function configure()
	{
		parent::configure();

		$this->setName('app:start-sync');
		$this->setDescription('Starts synchronization between databases');

		$this->addArgument('sourceDb', InputArgument::OPTIONAL, 'The list of available db');
		$this->addArgument('targetDb', InputArgument::OPTIONAL, 'The list of available db');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Start database synchronization</comment>');

		$sourceDb = $this->getSourceDb($input, $output);
		unset($this->listDb[$sourceDb]);
		$targetDb = $this->getTargetDb($input, $output);

		$sourceDbo = $this->container->get($sourceDb);
		$targetDbo = $this->container->get($targetDb);

		$config = $this->container->get('config')['rabbit'];

		$namespaceMap = [ucfirst($sourceDb) => ucfirst($targetDb)]; //todo tmp delete

		$syncSourceDataManager = new SyncDataManager($sourceDbo, $namespaceMap);
		$syncSourceManager = new SyncManager($config, $syncSourceDataManager);
		$syncSourceManager->send();

		$syncTargetDataManager = new SyncDataManager($targetDbo, $namespaceMap);
		$syncTargetManager = new SyncManager($config, $syncTargetDataManager);
		$syncTargetManager->receive();

		$output->writeln('<info>Done!</info>');

		return 0;
	}

	private function getSourceDb(InputInterface $input, OutputInterface $output)
	{
		$db = $input->getArgument('sourceDb');
		if (empty($db))
		{
			$question = new ChoiceQuestion('Choose source db', $this->listDb, 0);
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$db = $helper->ask($input, $output, $question);
		}
		return $db;
	}

	private function getTargetDb(InputInterface $input, OutputInterface $output)
	{
		$db = $input->getArgument('targetDb');
		if (empty($db))
		{
			$question = new ChoiceQuestion('Choose target db', $this->listDb, 0);
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$db = $helper->ask($input, $output, $question);
		}
		return $db;
	}
}
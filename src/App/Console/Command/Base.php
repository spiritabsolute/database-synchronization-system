<?php
namespace App\Console\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class Base extends Command
{
	protected $container;
	protected $listDb;

	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($name);

		$this->container = $container;
		$this->listDb = $container->get('config')['console']['listDb'];
	}

	protected function configure()
	{
		$this->addArgument('db', InputArgument::OPTIONAL, 'The list of available db');
	}

	protected function getDb(InputInterface $input, OutputInterface $output)
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
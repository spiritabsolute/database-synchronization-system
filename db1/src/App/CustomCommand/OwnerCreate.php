<?php
namespace App\CustomCommand;

use App\Entity\OwnerManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OwnerCreate extends \App\Command\Base
{
	protected function configure()
	{
		parent::configure();

		$this->setName('app:owner-create');
		$this->setDescription('Creates a new owner');

		$this->addArgument('name', InputArgument::OPTIONAL, 'The name of owner');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<comment>Creating owner</comment>');

		$pdo = $this->container->get(\PDO::class);

		$entityManager = new OwnerManager($pdo);

		$name = $this->getInput($input, $output, 'name', 'Input owner name: ');

		$fields = ['owner_name' => $name];

		if ($entityManager->add($fields))
		{
			$output->writeln('<info>Done!</info>');
		}
		else
		{
			$output->writeln('<error>Error!</error>');
		}

		$getListCommand = $this->container->get(OwnerGetList::class);
		$getListCommand->execute($input, $output);

		return 0;
	}
}
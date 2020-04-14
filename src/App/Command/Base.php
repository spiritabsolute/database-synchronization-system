<?php
namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class Base extends Command
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	public function __construct(ContainerInterface $container, string $name = null)
	{
		parent::__construct($name);

		$this->container = $container;
	}

	protected function getInput(InputInterface $input, OutputInterface $output, $argumentName, $message)
	{
		$argument = $input->getArgument($argumentName);
		if (empty($argument))
		{
			$question = new Question($message);
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$argument = $helper->ask($input, $output, $question);
		}
		return $argument;
	}

	protected function getChoiceInput(InputInterface $input, OutputInterface $output, $argumentName, $message, $options)
	{
		$argument = $input->getArgument($argumentName);
		if (empty($argument))
		{
			$question = new ChoiceQuestion($message, $options, current($options));
			/** @var Helper $helper */
			$helper = $this->getHelper('question');
			$argument = $helper->ask($input, $output, $question);
		}
		return $argument;
	}
}
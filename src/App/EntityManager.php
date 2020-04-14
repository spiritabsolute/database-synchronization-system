<?php
namespace App;

abstract class EntityManager
{
	protected $pdo;

	/**
	 * @var SyncDataManager
	 */
	protected $syncDataManager;

	protected $requiredFields = [];

	protected $isFilled = false;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function setSyncDataManager(SyncDataManager $syncDataManager): void
	{
		$this->syncDataManager = $syncDataManager;
	}

	public function add(): bool
	{
		$id = $this->storage->add($this->getFields());

		if ($id)
		{
			$this->id = $id;

			if ($this->syncDataManager)
			{
				$hash = $this->syncDataManager->generateHash($this->getHashInput());

				$outputId = $this->syncDataManager->addSyncOutput($id, static::class, $hash);

				return ($outputId ? true : false);
			}

			return true;
		}

		return false;
	}

	public function setFields(array $fields): void
	{
		foreach ($this->requiredFields as $requiredField)
		{
			if (empty($fields[$requiredField]))
			{
				throw new \Exception('Required parameter "'.$requiredField.'" not filled');
			}
		}
	}

	abstract public function getFields($id = null): array;

	abstract protected function getHashInput(): string;
}
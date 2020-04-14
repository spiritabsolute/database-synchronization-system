<?php
namespace App;

abstract class EntityManager implements \SplSubject
{
	const EVENT_ADD = 0;
	const EVENT_UPDATE = 1;
	const EVENT_DELETE = 2;

	protected $pdo;

	protected $observers;
	protected $syncState = false;
	protected $event = null;

	protected $id = 0;
	protected $requiredFields = [];
	protected $isFilled = false;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;

		$this->observers = new \SplObjectStorage;
	}

	public function isSyncState(): bool
	{
		return $this->syncState;
	}

	public function setSyncState(bool $syncState): void
	{
		$this->syncState = $syncState;
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function attach (\SplObserver $observer): void
	{
		$this->observers->attach($observer);
	}

	public function detach (\SplObserver $observer): void
	{
		$this->observers->detach($observer);
	}

	public function notify (): void
	{
		foreach ($this->observers as $observer)
		{
			$observer->update($this);
		}
	}

	public function add(): bool
	{
		$id = $this->storage->add($this->getFields());

		if ($id)
		{
			$this->id = $id;

			$this->event = self::EVENT_ADD;

			$this->notify();

			return true;
		}

		return false;
	}

	public function update(int $entityId): bool
	{
		$this->id = $entityId;
		return $this->storage->update($this->getFields());
	}

	public function delete(int $entityId): bool
	{
		return $this->storage->delete($entityId);
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

	public function getId(): int
	{
		return $this->id;
	}

	abstract public function getFields($id = null): array;

	abstract public function getHashInput(): string;
}
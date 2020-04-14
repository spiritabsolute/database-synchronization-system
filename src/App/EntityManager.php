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
	protected $createdAt;
	protected $modifiedAt;

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
		$this->createdAt = time();

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

	public function getList(array $filter = []): array
	{
		return $this->storage->getList($filter);
	}

	public function update(int $entityId): bool
	{
		$this->id = $entityId;
		$this->modifiedAt = time();

		if ($this->storage->update(['id' => $entityId], $this->getFields()))
		{
			$this->event = self::EVENT_UPDATE;

			$this->notify();

			return true;
		}

		return false;
	}

	public function delete(int $entityId): bool
	{
		$this->id = $entityId;

		if ($this->storage->delete($entityId))
		{
			$this->event = self::EVENT_DELETE;

			$this->notify();

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

	public function getId(): int
	{
		return $this->id;
	}

	abstract public function getFields($id = null): array;

	abstract public function getUpdatedFields(): array;

	public function getHashInput(): string
	{
		return $this->id.$this->createdAt;
	}
}
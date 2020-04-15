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
	protected $syncHash;
	protected $event = null;

	protected $id = 0;

	protected $isMultipleMode = false;

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

	public function setSyncHash(string $syncHash): void
	{
		$this->syncHash = $syncHash;
	}

	public function getSyncHash()
	{
		return $this->syncHash;
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function attach(\SplObserver $observer): void
	{
		$this->observers->attach($observer);
	}

	public function detach(\SplObserver $observer): void
	{
		$this->observers->detach($observer);
	}

	public function notify(): void
	{
		foreach ($this->observers as $observer)
		{
			$observer->update($this);
		}
	}

	public function getHashString(): string
	{
		return $this->id.static::class.time();
	}

	public function isMultipleMode(): bool
	{
		return $this->isMultipleMode;
	}

	public function add(array $fields): bool
	{
		$id = $this->storage->add($this->getFieldsForAdd($fields));

		if ($id)
		{
			$this->notifyAddEvent($id);
			return true;
		}

		return false;
	}

	protected function notifyAddEvent(int $id): void
	{
		$this->id = $id;
		$this->event = self::EVENT_ADD;
		$this->notify();
	}

	protected function notifyUpdateEvent(): void
	{
		$this->event = self::EVENT_UPDATE;
		$this->notify();
	}

	public function getList(array $filter = []): array
	{
		return $this->storage->getList($filter);
	}

	public function update(int $entityId, array $fields): bool
	{
		$this->id = $entityId;

		if ($this->storage->update(['id' => $entityId], $this->getFieldsForUpdate($fields)))
		{
			$this->notifyUpdateEvent();
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

	public function getId(): int
	{
		return $this->id;
	}

	abstract protected function getFieldsForAdd(array $fields): array;

	abstract protected function getFieldsForUpdate(array $fields): array;

	abstract public function getFieldsForSync(int $entityId): array;

	abstract public function getUpdatedFields(): array;
}
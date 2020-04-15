<?php
namespace App;

use SplSubject;

//todo cache queries; handlers errors; logs
class SyncQueueManager implements \SplObserver
{
	const WAITING_STATUS = 0;
	const DONE_STATUS = 1;

	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function update(SplSubject $entity)
	{
		/** @var EntityManager $entity */

		$event = $entity->getEvent();
		$entityId = $entity->getId();
		$status = ($entity->isSyncState() ? self::DONE_STATUS : self::WAITING_STATUS);

		switch ($event)
		{
			case $entity::EVENT_ADD:
				$hash = ($entity->isSyncState() ? $entity->getSyncHash() : $this->generateHash($entity->getHashString()));
				$syncQueue = new SyncQueue($entityId, get_class($entity), $hash, $status, $event);
				$this->add($syncQueue);
				break;
			case $entity::EVENT_UPDATE:
			case $entity::EVENT_DELETE:
				$queue = $this->getQueueByEntityId($entityId);
				if (empty($queue) || $queue['status'] == self::DONE_STATUS)
				{
					$this->updateEvent($entityId, $event);
					$this->updateStatus($entityId, $status);
				}
				break;
		}
	}

	public function updateStatus(int $entityId, int $status)
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$storage->update(['entity_id' => $entityId], ['status' => $status]);
	}

	public function updateEvent(int $entityId, int $event)
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$storage->update(['entity_id' => $entityId], ['event' => $event]);
	}

	public function consumeQueue(array $row): void
	{
		try
		{
			/** @var EntityManager $entity */
			$entity = new $row['entity_type']($this->pdo);

			$entity->setSyncState(true);
			$entity->setSyncHash($row['hash']);

			$entity->attach($this);

			switch ($row['event'])
			{
				case $entity::EVENT_ADD:
					$entity->add($row);
					break;
				case $entity::EVENT_UPDATE:
					$entityId = $this->getEntityIdByHash($row['hash']);
					$entity->update($entityId, $row);
					break;
				case $entity::EVENT_DELETE:
					$entityId = $this->getEntityIdByHash($row['hash']);
					$entity->delete($entityId);
					break;
			}
		}
		catch (\Exception $exception) {}
	}

	private function getEntityIdByHash(string $hash): int
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$queue = $storage->getList(['hash' => $hash]);
		$queue = $queue ? current($queue) : 0;
		return (int) $queue['entity_id'];
	}

	private function getQueueByEntityId(int $entityId): array
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$queue = $storage->getList(['entity_id' => $entityId]);
		if (!empty($queue))
		{
			return current($queue);
		}
		else
		{
			return [];
		}
	}

	private function add(SyncQueue $queue): bool
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		return $storage->add($queue->getFields());
	}

	public function getQueue(): array
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$queue = $storage->getList(['status' => self::WAITING_STATUS]);

		$entitiesData = [];
		foreach ($queue as $row)
		{
			$employeeManagerClass = $row['entity_type'];
			/** @var EntityManager $entityManager */
			$entityManager = new $employeeManagerClass($this->pdo);

			$fields = $entityManager->getFieldsForSync($row['entity_id']);

			unset($fields['id']);
			$fields['hash'] = $row['hash'];
			$fields['entity_type'] = $row['entity_type'];
			$fields['event'] = $row['event'];

			$entitiesData[] = $fields;

			$this->updateStatus($row['entity_id'], self::DONE_STATUS);
		}

		return $entitiesData;
	}

	private function generateHash(string $string)
	{
		return md5($string);
	}
}
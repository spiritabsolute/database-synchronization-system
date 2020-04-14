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
			$entity->setFields($row);
			$entity->attach($this);

			switch ($row['event'])
			{
				case $entity::EVENT_ADD:
					$entity->add();
					break;
				case $entity::EVENT_UPDATE:
					$entityId = $this->getEntityIdByHash($row['hash']);
					$entity->update($entityId);
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

	public function update(SplSubject $entity)
	{
		/** @var EntityManager $entity */

		$event = $entity->getEvent();
		$entityId = $entity->getId();

		switch ($event)
		{
			case $entity::EVENT_ADD:
				$status = ($entity->isSyncState() ? self::DONE_STATUS : self::WAITING_STATUS);
				$hash = $this->generateHash($entity->getHashInput());
				$syncQueue = new SyncQueue($entityId, get_class($entity), $hash, $status, $event);
				$this->add($syncQueue);
				break;
			case $entity::EVENT_UPDATE:
			case $entity::EVENT_DELETE:
				$queue = $this->getQueueByEntityId($entityId);
				if (empty($queue) || $queue['status'] == self::DONE_STATUS)
				{
					$this->updateEvent($entityId, $event);
					$this->updateStatus($entityId, self::WAITING_STATUS);
				}
				break;
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

			$fields = $entityManager->getFields($row['entity_id']);

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
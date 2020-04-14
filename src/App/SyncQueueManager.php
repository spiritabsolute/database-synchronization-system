<?php
namespace App;

use SplSubject;

class SyncQueueManager implements \SplObserver
{
	const WAITING_STATUS = 0;
	const DONE_STATUS = 1;

	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function setDoneStatus(string $hash)
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$storage->update(['hash' => $hash], ['status' => self::DONE_STATUS]);
	}

	public function setWaitingStatus(string $hash)
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$storage->update(['hash' => $hash], ['status' => self::WAITING_STATUS]);
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
		catch (\Exception $exception)
		{
			//todo log
		}
	}

	private function getEntityIdByHash(string $hash): int
	{
		$storage = new Storage($this->pdo, 'sync_queue');
		$queue = $storage->getList(['hash' => $hash]);
		return (int) $queue['entity_id'];
	}

	public function update(SplSubject $entity)
	{
		/**
		 * @var EntityManager $entity
		 */
		$status = ($entity->isSyncState() ? self::DONE_STATUS : self::WAITING_STATUS);
		$hash = $this->generateHash($entity->getHashInput());
		$event = $entity->getEvent();

		$syncQueue = new SyncQueue($entity->getId(), get_class($entity), $hash, $status, $event);

		switch ($event)
		{
			case $entity::EVENT_ADD:
				$this->add($syncQueue);
				break;
			case $entity::EVENT_UPDATE:
			case $entity::EVENT_DELETE:
				$this->setWaitingStatus($hash);
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

			$this->setDoneStatus($row['hash']);
		}

		return $entitiesData;
	}

	private function generateHash(string $string)
	{
		return md5($string);
	}
}
<?php
namespace App;

class EntityManager
{
	private $storage;
	private $syncDataManager;

	public function __construct(Storage $storage, SyncDataManager $syncDataManager)
	{
		$this->storage = $storage;
		$this->syncDataManager = $syncDataManager;
	}

	public function add(Entity $entity): bool
	{
		$this->storage->beginTransaction();

		$id = $this->storage->add($entity->getFields());

		if ($id)
		{
			$hash = $this->syncDataManager->generateHash($entity->getHashInput());

			$queueId = $this->syncDataManager->addSyncQueue(
				new SyncOutput($id, $entity->getType(), $hash)
			);

			if ($queueId)
			{
				$this->storage->commitTransaction();

				return true;
			}
		}

		$this->storage->rollbackTransaction();

		return false;
	}
}
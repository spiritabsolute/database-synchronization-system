<?php
namespace App;

class SyncDataManager
{
	private $storage;

	public function __construct(Storage $storage)
	{
		$this->storage = $storage;
	}

	public function addSyncQueue(SyncOutput $syncOutput)
	{
		return $this->storage->add([
			'entity_id' => $syncOutput->getEntityId(),
			'entity_type' => $syncOutput->getEntityType(),
			'hash' => $syncOutput->getHash()
		]);
	}

	public function generateHash(string $string)
	{
		return md5($string);
	}
}
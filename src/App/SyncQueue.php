<?php
namespace App;

class SyncQueue
{
	private $id;
	private $entityId;
	private $entityType;
	private $hash;
	private $status;
	private $event;

	public function __construct(int $entityId, string $entityType, string $hash, int $status, int $event)
	{
		$this->entityId = $entityId;
		$this->entityType = $entityType;
		$this->hash = $hash;
		$this->status = $status;
		$this->event = $event;
	}

	public function getFields(): array
	{
		return [
			'id' => $this->id,
			'entity_id' => $this->entityId,
			'entity_type' => $this->entityType,
			'hash' => $this->hash,
			'status' => $this->status,
			'event' => $this->event,
		];
	}
}
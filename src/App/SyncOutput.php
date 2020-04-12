<?php
namespace App;

class SyncOutput
{
	private $id;
	private $entityId;
	private $entityType;
	private $hash;

	public function __construct(int $entityId, int $entityType, string $hash)
	{
		$this->entityId = $entityId;
		$this->entityType = $entityType;
		$this->hash = $hash;
	}

	public function setId($id): void
	{
		$this->id = $id;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getEntityId(): int
	{
		return $this->entityId;
	}

	public function getEntityType(): int
	{
		return $this->entityType;
	}

	public function getHash(): string
	{
		return $this->hash;
	}
}
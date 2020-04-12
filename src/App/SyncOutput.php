<?php
namespace App;

class SyncOutput implements Entity
{
	private $id = null;

	private $entityId;
	private $entityType;
	private $hash;

	public function __construct(int $entityId, string $entityType, string $hash)
	{
		$this->entityId = $entityId;
		$this->entityType = $entityType;
		$this->hash = $hash;
	}

	public function getType(): string
	{
		return self::class;
	}

	public function getFields(): array
	{
		return [
			'id' => $this->id,
			'entityId' => $this->entityId,
			'entityType' => $this->entityType,
			'hash' => $this->hash
		];
	}

	public function getHashInput(): string
	{
		return '';
	}

	public function setId($id): void
	{
		$this->id = $id;
	}

	public function getId(): int
	{
		return $this->id;
	}
}
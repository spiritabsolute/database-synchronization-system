<?php
namespace App\Db1\Employee;

use App\Entity;

class Employee implements Entity
{
	private $id = null;

	private $createdAt;
	private $modifiedAt;
	private $name;

	public function __construct(int $createdAt, int $modifiedAt, string $name)
	{
		$this->createdAt = $createdAt;
		$this->modifiedAt = $modifiedAt;
		$this->name = $name;
	}

	public function getType(): string
	{
		return self::class;
	}

	public function getFields(): array
	{
		return [
			'id' => $this->id,
			'createdAt' => $this->createdAt,
			'modifiedAt' => $this->modifiedAt,
			'name' => $this->name
		];
	}

	public function getHashInput(): string
	{
		return $this->createdAt.$this->modifiedAt.$this->name;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}
}
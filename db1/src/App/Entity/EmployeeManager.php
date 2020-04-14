<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class EmployeeManager extends EntityManager
{
	protected $storage;

	private $name;

	protected $requiredFields = ['name'];

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'employee');
	}

	public function setFields(array $fields): void
	{
		parent::setFields($fields);

		$this->id = $fields['id'] ?? null;
		$this->createdAt = $fields['createdAt'] ?? $this->createdAt;
		$this->modifiedAt = $fields['modifiedAt'] ?? $this->modifiedAt;
		$this->name = $fields['name'];

		$this->isFilled = true;
	}

	public function getFields($id = null): array
	{
		if ($this->isFilled)
		{
			return [
				'id' => $this->id,
				'createdAt' => $this->createdAt,
				'modifiedAt' => $this->modifiedAt,
				'name' => $this->name
			];
		}
		else
		{
			return $this->storage->getById($id);
		}
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name'
		];
	}
}
<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class EmployeeManager extends EntityManager
{
	protected $storage;

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'employee');
	}

	protected function getFieldsForAdd(array $fields = []): array
	{
		return [
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['name'],
		];
	}

	protected function getFieldsForUpdate(array $fields): array
	{
		return [
			'name' => $fields['name']
		];
	}

	public function getFieldsForSync(int $entityId): array
	{
		return $this->storage->getById($entityId);
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name'
		];
	}
}
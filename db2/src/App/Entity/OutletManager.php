<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class OutletManager extends EntityManager
{
	protected $storage;

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'outlet');
	}

	protected function getFieldsForAdd(array $fields = []): array
	{
		return [
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['name'],
			'owner_name' => $fields['owner_name'],
		];
	}

	protected function getFieldsForUpdate(array $fields): array
	{
		$fieldsForUpdate = [
			'modifiedAt' => time(),
		];

		if (empty($fields['name']))
		{
			$fieldsForUpdate['name'] = $fields['name'];
		}
		if (empty($fields['owner_name']))
		{
			$fieldsForUpdate['owner_name'] = $fields['owner_name'];
		}

		return $fieldsForUpdate;
	}

	public function getFieldsForSync(int $outletId): array
	{
		return $this->storage->getById($outletId);
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name',
			'owner_name' => 'owner_name'
		];
	}
}
<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class SkuManager extends EntityManager
{
	protected $storage;

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'sku');
	}

	protected function getFieldsForAdd(array $fields = []): array
	{
		return [
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['name'],
			'stock' => $fields['stock'],
		];
	}

	protected function getFieldsForUpdate(array $fields): array
	{
		$fieldsForUpdate = [
			'modifiedAt' => time(),
		];

		if (!empty($fields['name']))
		{
			$fieldsForUpdate['name'] = $fields['name'];
		}
		if (!empty($fields['stock']))
		{
			$fieldsForUpdate['stock'] = $fields['stock'];
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
			'stock' => 'stock'
		];
	}
}
<?php
namespace App\Entity;

use App\Storage;

class SkuStockManager implements \SplObserver
{
	private $storage;

	public function __construct(\PDO $pdo)
	{
		$this->storage = new Storage($pdo, 'sku_stock');
	}

	public function update(\SplSubject $entity)
	{
		/** @var SkuManager $entity */

		$event = $entity->getEvent();

		switch ($event)
		{
			case $entity::EVENT_ADD:
				$fields = [
					'sku_id' => $entity->getId(),
					'stock' => $entity->getStock(),
				];
				$this->storage->add($this->getFieldsForAdd($fields));
				break;
			case $entity::EVENT_UPDATE:
				$fields = [
					'stock' => $entity->getStock(),
				];
				$this->storage->update(['sku_id' => $entity->getId()], $this->getFieldsForUpdate($fields));
				break;
			case $entity::EVENT_DELETE:
				$this->storage->deleteByFilter(['sku_id' => $entity->getId()]);
				break;
		}
	}

	public function getList(array $filter = []): array
	{
		return $this->storage->getList($filter);
	}

	protected function getFieldsForAdd(array $fields): array
	{
		return [
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'sku_id' => $fields['sku_id'],
			'stock' => $fields['stock'],
		];
	}

	protected function getFieldsForUpdate(array $fields): array
	{
		$fieldsForUpdate = [
			'modifiedAt' => time(),
		];

		if (!empty($fields['sku_id']))
		{
			$fieldsForUpdate['sku_id'] = $fields['sku_id'];
		}

		if (!empty($fields['stock']))
		{
			$fieldsForUpdate['stock'] = $fields['stock'];
		}

		return $fieldsForUpdate;
	}
}
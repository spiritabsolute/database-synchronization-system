<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class SkuManager extends EntityManager
{
	protected $storage;

	private $stock;
	private $skuStockManager;

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'sku');

		$this->isMultipleMode = true;

		$this->skuStockManager = new SkuStockManager($pdo);
		$this->attach($this->skuStockManager);
	}

	public function add(array $fields): bool
	{
		$this->stock = $fields['stock'];

		return parent::add($fields);
	}

	public function update(int $entityId, array $fields): bool
	{
		$this->stock = $fields['stock'];

		return parent::update($entityId, $fields);
	}

	public function getStock()
	{
		return $this->stock;
	}

	public function getList(array $filter = []): array
	{
		$list = [];
		foreach ($this->storage->getList($filter) as $sku)
		{
			$sku['stock'] = $this->getStockBySkuId($sku['id']);
			$list[] = $sku;
		}
		return $list;
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
		$fieldsForUpdate = [
			'modifiedAt' => time(),
		];

		if (!empty($fields['name']))
		{
			$fieldsForUpdate['name'] = $fields['name'];
		}

		return $fieldsForUpdate;
	}

	public function getFieldsForSync(int $skuId): array
	{
		$skuData = $this->storage->getById($skuId);
		$skuData['stock'] = $this->getStockBySkuId($skuId);
		return $skuData;
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name',
			'stock' => 'stock'
		];
	}

	private function getStockBySkuId($skuId): int
	{
		$skuStockData = $this->skuStockManager->getList(['sku_id' => $skuId]);
		if (!empty($skuStockData))
		{
			$skuStockData = current($skuStockData);
			return (int) $skuStockData['stock'];
		}
		return 0;
	}
}
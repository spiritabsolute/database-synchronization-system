<?php
namespace App\Entity;

use App\EntityManager;
use App\Storage;

class OutletManager extends EntityManager
{
	protected $storage;

	private $ownerManager;

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'outlet');

		$this->isMultipleMode = true;

		$this->ownerManager = new OwnerManager($pdo);
	}

	public function add(array $inputFields): bool
	{
		$fields = $this->getFieldsForAdd($inputFields);

		if ($this->ownerManager->existOwner($fields))
		{
			return $this->addOutlet($fields);
		}

		$ownerId = $this->ownerManager->add($inputFields);
		if ($ownerId)
		{
			$fields['owner_id'] = $ownerId;
			return $this->addOutlet($fields);
		}

		return false;
	}

	private function addOutlet($fields): bool
	{
		$outletId =  $this->storage->add([
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['name'],
			'owner_id' => $fields['owner_id'],
		]);
		if ($outletId)
		{
			$this->notifyAddEvent($outletId);

			return true;
		}

		return false;
	}

	public function notifyAboutOwnerChanged(int $ownerId): void
	{
		$outlet = $this->getOutletByOwnerId($ownerId);
		if (!empty($outlet))
		{
			$this->id = $outlet['id'];;
			$this->notifyUpdateEvent();
		}
	}

	public function existOutletByOwnerId(int $ownerId): bool
	{
		$outlet = $this->getOutletByOwnerId($ownerId);
		return !empty($outlet);
	}

	private function getOutletByOwnerId(int $ownerId): array
	{
		$list = $this->storage->getList(['owner_id' => $ownerId]);
		return (count($list) == 1 ? current($list) : $list);
	}

	protected function getFieldsForAdd(array $fields = []): array
	{
		return [
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['name'],
			'owner_id' => $fields['owner_id'],
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
		if (!empty($fields['owner_id']))
		{
			$fieldsForUpdate['owner_id'] = $fields['owner_id'];
		}

		return $fieldsForUpdate;
	}

	public function getFieldsForSync(int $outletId): array
	{
		$outletData = $this->storage->getById($outletId);
		$ownerData = $this->ownerManager->getList(['id' => $outletData['owner_id']]);
		if (!empty($ownerData))
		{
			$ownerData = current($ownerData);
			$outletData['owner_name'] = $ownerData['name'];
		}
		return $outletData;
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name',
			'owner_id' => 'owner_id'
		];
	}
}
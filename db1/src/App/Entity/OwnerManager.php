<?php
namespace App\Entity;

use App\Storage;

class OwnerManager
{
	private $storage;
	private $outletManager;

	public function __construct(\PDO $pdo, OutletManager $outletManager = null)
	{
		$this->storage = new Storage($pdo, 'owner');
		$this->outletManager = $outletManager;
	}

	public function add(array $fields): int
	{
		return $this->storage->add([
			'id' => null,
			'createdAt' => time(),
			'modifiedAt' => time(),
			'name' => $fields['owner_name'],
		]);
	}

	public function existOwner(array $fields): bool
	{
		if (empty($fields['owner_id']))
		{
			return false;
		}

		$owner = $this->storage->getById($fields['owner_id']);

		return !empty($owner);
	}

	public function getOwnerName(int $ownerId): string
	{
		$owner = $this->storage->getById($ownerId);
		if ($owner)
		{
			return $owner['name'];
		}
		return '';
	}

	public function getList(array $filter = []): array
	{
		return $this->storage->getList($filter);
	}

	public function update(int $ownerId, array $fields): bool
	{
		$fields = [
			'modifiedAt' => time(),
			'name' => $fields['name'],
		];

		$result = $this->storage->update(['id' => $ownerId], $fields);

		if ($result && $this->outletManager)
		{
			$this->outletManager->notifyAboutOwnerChanged($ownerId);
		}

		return $result;
	}

	public function delete(int $ownerId): bool
	{
		if ($this->outletManager && $this->outletManager->existOutletByOwnerId($ownerId))
		{
			return false;
		}

		return $this->storage->delete($ownerId);
	}

	public function getUpdatedFields(): array
	{
		return [
			'name' => 'name',
		];
	}
}
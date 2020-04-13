<?php
namespace App\Db1;

use App\EntityManager;
use App\Storage;

class EmployeeManager extends EntityManager
{
	protected $storage;

	protected $id;
	private $createdAt;
	private $modifiedAt;
	private $name;

	protected $requiredFields = ['createdAt', 'modifiedAt', 'name'];

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);

		$this->storage = new Storage($pdo, 'employee');
	}

	public function add(): bool
	{
		$this->storage->beginTransaction();

		if (parent::add())
		{
			$this->storage->commitTransaction();

			return true;
		}
		else
		{
			$this->storage->rollbackTransaction();

			return false;
		}
	}

	public function setFields(array $fields): void
	{
		parent::setFields($fields);

		$this->id = $fields['id'] ?? null;
		$this->createdAt = $fields['createdAt'];
		$this->modifiedAt = $fields['modifiedAt'];
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
			return $this->storage->get($id);
		}
	}

	protected function getHashInput(): string
	{
		return $this->createdAt.$this->modifiedAt.$this->name;
	}
}
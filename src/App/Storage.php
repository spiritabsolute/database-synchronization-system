<?php
namespace App;

class Storage
{
	private $pdo;
	private $tableName;

	public function __construct(\PDO $pdo, string $tableName)
	{
		$this->pdo = $pdo;
		$this->tableName = $tableName;
	}

	public function add(array $fields): int
	{
		$values = $this->prepareValues($fields);

		$statement = $this->pdo->prepare('
			INSERT INTO '.$this->pdo->quote($this->tableName).' VALUES ('.$values.')
		');

		$this->bindValues($statement, $fields);

		$statement->execute();

		return $this->pdo->lastInsertId();
	}

	public function get(int $id): array
	{
		$statement = $this->pdo->prepare('
			SELECT * FROM '.$this->pdo->quote($this->tableName).' WHERE id = :id
		');

		$statement->bindValue(':id', $id, \PDO::PARAM_INT);

		$statement->execute();

		if ($employee = $statement->fetch(\PDO::FETCH_ASSOC))
		{
			return $employee;
		}
		else
		{
			return [];
		}
	}

	public function getAll(int $offset, int $limit): array
	{
		$statement = $this->pdo->prepare('
			SELECT * 
			FROM '.$this->pdo->quote($this->tableName).' 
			ORDER_BY id DESC 
			LIMIT :limit 
			OFFSET :offset
		');

		$statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
		$statement->bindValue(':offset', $offset, \PDO::PARAM_INT);

		$statement->execute();

		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function update(int $id, array $fields): bool
	{
		$values = $this->prepareUpdateValues($fields);

		$statement = $this->pdo->prepare('
			UPDATE '.$this->pdo->quote($this->tableName).' 
			SET '.$values.'
			WHERE id = :id
		');

		$this->bindValues($statement, $fields);

		$statement->execute();

		return ($statement->rowCount() > 0);
	}

	public function delete(int $id): bool
	{
		$statement = $this->pdo->prepare('
			DELETE FROM '.$this->pdo->quote($this->tableName).' 
			WHERE id = :id
		');

		$statement->bindValue(':id', $id, \PDO::PARAM_INT);

		$statement->execute();

		return ($statement->rowCount() > 0);
	}

	public function countAll(): int
	{
		return $this->pdo->query('SELECT COUNT(id) FROM '.$this->pdo->quote($this->tableName))->fetchColumn();
	}

	public function beginTransaction(): void
	{
		$this->pdo->beginTransaction();
	}

	public function commitTransaction(): void
	{
		$this->pdo->commit();
	}

	public function rollbackTransaction(): void
	{
		$this->pdo->rollback();
	}

	private function prepareValues(array $fields): string
	{
		$fieldIds = [];
		foreach ($fields as $fieldId => $fieldValue)
		{
			$fieldIds[] = ':' . $fieldId;
		}
		return implode(',', $fieldIds);
	}

	private function prepareUpdateValues(array $fields): string
	{
		$fieldIds = [];
		foreach ($fields as $fieldId => $fieldValue)
		{
			$fieldIds[] = $fieldId.' = :'.$fieldId;
		}
		return implode(',', $fieldIds);
	}

	private function bindValues($statement, array $fields): void
	{
		foreach ($fields as $fieldId => $fieldValue)
		{
			$dataType = (is_numeric($fieldValue) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
			$statement->bindValue(':' . $fieldId, $fieldValue, $dataType);
		}
	}
}
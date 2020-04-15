<?php
namespace App;

//todo change to Doctrine ORM
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

	public function getById(int $id): array
	{
		$statement = $this->pdo->prepare('
			SELECT * FROM '.$this->pdo->quote($this->tableName).' WHERE id = :id
		');

		$statement->bindValue(':id', $id, \PDO::PARAM_INT);

		$statement->execute();

		if ($entity = $statement->fetch(\PDO::FETCH_ASSOC))
		{
			return $entity;
		}
		else
		{
			return [];
		}
	}

	public function getList(array $filter = []): array
	{
		$whereValues = $this->prepareWhereValues($filter);

		$query = '
			SELECT * 
			FROM '.$this->pdo->quote($this->tableName).' 
			WHERE '.$whereValues.' ORDER BY id DESC
		';
		$statement = $this->pdo->prepare($query);

		$this->bindValues($statement, $filter);

		$statement->execute();

		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function update(array $filter, array $fields): bool
	{
		$whereValues = $this->prepareWhereValues($filter);
		$values = $this->prepareUpdateValues($fields);

		$statement = $this->pdo->prepare('
			UPDATE '.$this->pdo->quote($this->tableName).' 
			SET '.$values.'
			WHERE '.$whereValues.'
		');

		$this->bindValues($statement, $filter);
		$this->bindValues($statement, $fields);

		$statement->execute();

		return ($statement->rowCount() > 0);
	}

	public function deleteByFilter(array $filter): bool
	{
		$whereValues = $this->prepareWhereValues($filter);

		$statement = $this->pdo->prepare('
			DELETE FROM '.$this->pdo->quote($this->tableName).' 
			WHERE '.$whereValues.'
		');

		$this->bindValues($statement, $filter);

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

	private function prepareWhereValues(array $fields): string
	{
		$fieldIds = ['1 = 1'];
		foreach ($fields as $fieldId => $fieldValue)
		{
			$fieldIds[] = $fieldId.' = :'.$fieldId;
		}
		return implode(' AND ', $fieldIds);
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
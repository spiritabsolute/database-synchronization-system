<?php
namespace App;

class SyncDataManager
{
	private $pdo;
	private $namespaceMap;

	public function __construct(\PDO $pdo, $namespaceMap = [])
	{
		$this->pdo = $pdo;
		$this->namespaceMap = $namespaceMap;
	}

	public function addSyncOutput(array $fields): int
	{
		$outputStorage = new Storage($this->pdo, 'sync_output');
		return $outputStorage->add($fields);
	}

	public function addSyncInput(array $fields): int
	{
		$inputStorage = new Storage($this->pdo, 'sync_input');
		return $inputStorage->add($fields);
	}

	public function updateStatusSyncInput(): bool
	{
		//todo
		return true;
	}

	public function getOutputData(): string
	{
		$outputStorage = new Storage($this->pdo, 'sync_output');
		$outputLogs = $outputStorage->getAll();

		$entitiesData = [];
		foreach ($outputLogs as $outputLog)
		{
			$entityId = $outputLog['entity_id'];
			$employeeManagerClass = $outputLog['entity_type'];
			/** @var EntityManager $entityManager */
			$entityManager = new $employeeManagerClass($this->pdo);
			$fields = $entityManager->getFields($entityId);
			$fields['hash'] = $outputLog['hash'];
			$fields['entity_type'] = $outputLog['entity_type'];
			$entitiesData[] = $fields;
		}

		return json_encode($entitiesData);
	}

	public function addInputData(array $inputData): bool
	{
		$this->addSyncInput([
			'id' => null,
			'hash' => $inputData['hash'],
			'status' => 0
		]);

		$entityManagerClass = str_replace(
			array_key_first($this->namespaceMap),
			current($this->namespaceMap),
			$inputData['entity_type']
		);
		/** @var EntityManager $entityManager */
		$entityManager = new $entityManagerClass($this->pdo);
		$entityManager->setFields($inputData);

		if ($entityManager->add())
		{
			$this->updateStatusSyncInput();

			return true;
		}
		else
		{
			return false;
		}
	}

	public function generateHash(string $string)
	{
		return md5($string);
	}
}
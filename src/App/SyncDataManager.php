<?php
namespace App;

class SyncDataManager
{
	const WAITING_STATUS = 0;
	const DONE_STATUS = 1;

	const ADD_ACTION = 0;
	const UPDATE_ACTION = 1;
	const DELETE_ACTION = 2;

	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function addSyncOutput(int $entityId, string $entityType, string $hash): int
	{
		$outputStorage = new Storage($this->pdo, 'sync_output');
		return $outputStorage->add([
			'id' => null,
			'entity_id' => $entityId,
			'entity_type' => $entityType,
			'hash' => $hash,
			'status' => self::WAITING_STATUS,
			'action_type' => self::ADD_ACTION
		]);
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
		/** @var EntityManager $entityManager */
		$entityManager = new $inputData['entity_type']($this->pdo);
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
<?php

use Phinx\Migration\AbstractMigration;

class Employee extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('employee');

		$table->addColumn('createdAt', 'integer');
		$table->addColumn('modifiedAt', 'integer');
		$table->addColumn('name', 'text');

		$table->create();

		$rows = [
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'employee_1'
			],
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'employee_2'
			],
		];
		$table->insert($rows)->save();
	}
}

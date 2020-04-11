<?php

use Phinx\Migration\AbstractMigration;

class Outlet extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('outlet');

		$table->addColumn('createdAt', 'integer');
		$table->addColumn('modifiedAt', 'integer');
		$table->addColumn('name', 'text');

		$table->addColumn('owner_id', 'integer');

		$table->create();

		$rows = [
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'outlet_1',
				'owner_id' => 1
			],
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'outlet_2',
				'owner_id' => 2
			],
		];
		$table->insert($rows)->save();
	}
}

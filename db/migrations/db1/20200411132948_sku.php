<?php

use Phinx\Migration\AbstractMigration;

class Sku extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('sku');

		$table->addColumn('createdAt', 'integer');
		$table->addColumn('modifiedAt', 'integer');
		$table->addColumn('name', 'text');
		$table->addColumn('stock', 'integer');

		$table->create();

		$rows = [
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'sku_1',
				'stock' => 245,
			],
			[
				'createdAt' => time(),
				'modifiedAt' => time(),
				'name' => 'sku_2',
				'stock' => 246,
			],
		];
		$table->insert($rows)->save();
	}
}

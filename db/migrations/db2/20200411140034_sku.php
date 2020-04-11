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

		$table->create();
	}
}

<?php

use Phinx\Migration\AbstractMigration;

class Owner extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('owner');

		$table->addColumn('createdAt', 'integer');
		$table->addColumn('modifiedAt', 'integer');
		$table->addColumn('name', 'text');

		$table->create();
	}
}

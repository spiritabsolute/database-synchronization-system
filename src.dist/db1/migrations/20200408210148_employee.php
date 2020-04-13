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
	}
}

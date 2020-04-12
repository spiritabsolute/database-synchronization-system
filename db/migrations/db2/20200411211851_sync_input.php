<?php

use Phinx\Migration\AbstractMigration;

class SyncInput extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('sync_input');

		$table->addColumn('hash', 'text');
		$table->addColumn('status', 'integer');

		$table->create();
	}
}

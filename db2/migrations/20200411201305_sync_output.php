<?php

use Phinx\Migration\AbstractMigration;

class SyncOutput extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('sync_output');

		$table->addColumn('entity_id', 'integer');
		$table->addColumn('entity_type', 'integer');
		$table->addColumn('hash', 'text');
		$table->addColumn('status', 'integer');
		$table->addColumn('action_type', 'integer');

		$table->create();
	}
}

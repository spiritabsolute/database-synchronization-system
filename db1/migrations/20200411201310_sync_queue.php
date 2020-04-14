<?php

use Phinx\Migration\AbstractMigration;

class SyncQueue extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('sync_queue');

		$table->addColumn('entity_id', 'integer');
		$table->addColumn('entity_type', 'integer');
		$table->addColumn('hash', 'text');
		$table->addColumn('status', 'integer');
		$table->addColumn('event', 'integer');

		$table->create();
	}
}

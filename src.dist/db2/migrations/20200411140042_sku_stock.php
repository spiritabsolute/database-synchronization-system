<?php

use Phinx\Migration\AbstractMigration;

class SkuStock extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('sku_stock');

		$table->addColumn('createdAt', 'integer');
		$table->addColumn('modifiedAt', 'integer');
		$table->addColumn('sku_id', 'integer');
		$table->addColumn('stock', 'integer');

		$table->create();
	}
}

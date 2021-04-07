<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JeopardyCategory extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('jeopardy_category');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('jeopardy_category');
	}
}

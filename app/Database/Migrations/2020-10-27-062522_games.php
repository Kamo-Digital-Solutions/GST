<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Games extends Migration
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
				'constraint' => 50,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('games');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('games');
	}
}

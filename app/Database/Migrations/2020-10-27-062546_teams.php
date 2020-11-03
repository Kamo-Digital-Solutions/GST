<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Teams extends Migration
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
			'team_name' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,

			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('teams');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('teams');
	}
}

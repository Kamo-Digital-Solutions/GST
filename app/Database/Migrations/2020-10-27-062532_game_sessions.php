<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GameSessions extends Migration
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
			'game_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,

			],
			'session_id' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => true,
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('game_sessions');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('game_sessions');
	}
}

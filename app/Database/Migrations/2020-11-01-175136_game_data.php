<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GameData extends Migration
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
			'owner_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'data' => [
				'type' => 'TEXT',
			],
			'current_data' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'game_session_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('game_data');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('game_data');
	}
}

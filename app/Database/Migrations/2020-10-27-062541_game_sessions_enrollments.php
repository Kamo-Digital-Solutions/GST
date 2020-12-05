<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GameSessionsEnrollments extends Migration
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
			'game_session_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'team_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => true,
			],
			'user_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'null' => true,
			],
			'score' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'rank' => [
				'type' => 'INT',
				'constraint' => 6,
				'unsigned' => true,
				'null' => true,
			],
			'is_host' => [
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => true,
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('game_sessions_enrollements');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('game_sessions_enrollements');

	}
}

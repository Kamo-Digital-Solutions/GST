<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JeopardyGame extends Migration
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

			'scores_r1' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'categoryid_1' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_2' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_3' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_4' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_5' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],

			'scores_r2' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
			],
			'categoryid_6' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_7' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_8' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_9' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'categoryid_10' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],

			'final_jeopardy_question' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'final_jeopardy_answer' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'final_jeopardy_score' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'final_jeopardy_category' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'final_jeopardy_media_attachement' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'double_jeopardy_r1' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'double_jeopardy_r2' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('jeopardy_game');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('jeopardy_game');
	}
}

<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Questions extends Migration
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
			'question_text' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
			],
			'media_attachement' => [
				'type' => 'VARCHAR',
				'constraint' => 1024,
			],
			'answer' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('questions');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('questions');
	}
}

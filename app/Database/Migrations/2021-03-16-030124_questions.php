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
				'null' => true,
			],
			'media_attachement' => [
				'type' => 'VARCHAR',
				'constraint' => 1024,
				'null' => true,
			],
			'answer' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
			],

			'category_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
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

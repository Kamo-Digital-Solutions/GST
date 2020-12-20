<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
			'firstname' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'lastname' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
			],
			'country' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'state' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'city' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'picture' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}

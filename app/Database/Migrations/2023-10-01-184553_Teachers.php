<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Teachers extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nim'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'created_at' => [
				'type'           => 'datetime'
			],
			'updated_at' => [
				'type'           => 'datetime'
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('teachers');
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}

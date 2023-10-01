<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Schedulles extends Migration
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
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
			'date' => [
				'type' => 'DATE',
			],
			'time' => [
				'type' => 'TIME',
			],
            'place' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
            'description' => [
				'type' => 'TEXT',
			],

            'change_date' => [
				'type' => 'TEXT',
                'null' => true,
			],
			'change_time' => [
				'type' => 'TIME',
			],
            'change_description' => [
				'type' => 'TEXT',
                'null' => true,
			],

			'created_at' => [
				'type'           => 'datetime'
			],
			'updated_at' => [
				'type'           => 'datetime'
			],
		]);
		$this->forge->addKey('id', true);
        $this->forge->addForeignKey('teacher_id', 'teachers', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('schedulles');
    }

    public function down()
    {
        $this->forge->dropTable('schedulles');
    }
}

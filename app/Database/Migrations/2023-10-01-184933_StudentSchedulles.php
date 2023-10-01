<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StudentSchedulles extends Migration
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
			
            'student_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'schedulle_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],

			'created_at' => [
				'type'           => 'datetime'
			],
			'updated_at' => [
				'type'           => 'datetime'
			],
		]);
		$this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('schedulle_id', 'schedulles', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('student_schedulles');
    }

    public function down()
    {
        $this->forge->dropTable('student_schedulles');
    }
}

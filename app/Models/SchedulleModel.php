<?php

namespace App\Models;

use CodeIgniter\Model;

class SchedulleModel extends Model
{
    // THESE LINES
    protected $table   = 'schedulles';
    protected $protectFields = false;
    protected $allowedFields = [
        'teacher_id',
        'date',
        'time',
        'place',
        'description',

        'change_date',
        'change_time',
        'change_description',
        
        'created_at',
        'updated_at',
    ];

	public function get($ID = false)
    {
        if ($ID) {
            return $this->db->table('schedulles')
            ->where(['schedulles.id' => $ID])
            ->get()->getRowArray();
        } else {
            return $this->db->table('schedulles')
            ->get()->getResultArray();
        }
    }

	public function createData($data)
    {
        $model = new TeacherModel();
        $model->insert([
            'name'     	    => $data['name'],
            'email'     	    => $data['email'],

            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
        ]);
        
        return $model;
    }

    public function updateData($data)
    {
        $model = new TeacherModel();
        $model->update(
            [
                'id' => $data['id']
            ], [
            'name'     	    => $data['name'],
            'email'     	    => $data['email'],
            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
            ]
        );
        
        return $model;
    }
}

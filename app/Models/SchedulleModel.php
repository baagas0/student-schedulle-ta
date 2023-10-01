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
            ->join('teachers', 'teachers.id = schedulles.teacher_id')
            ->where(['schedulles.id' => $ID])
            ->select(['schedulles.*', 'teachers.name as teacher_name'])
            ->get()->getRowArray();
        } else {
            return $this->db->table('schedulles')
            ->join('teachers', 'teachers.id = schedulles.teacher_id')
            ->select(['schedulles.*', 'teachers.name as teacher_name'])
            ->get()->getResultArray();
        }
    }

	public function createData($data)
    {
        $model = new SchedulleModel();
        $model->insert([

            'teacher_id'    => $data['teacher_id'],
            'date'          => $data['date'],
            'time'          => $data['time'],
            'place'         => $data['place'],
            'description'   => $data['description'],

            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
        ]);
        
        return $model;
    }

    public function updateData($data)
    {
        $model = new SchedulleModel();
        $model->update(
            [
                'id' => $data['id']
            ], [
            
                'change_date'       => $data['change_date'],
                'change_time'       => $data['change_time'],
                'change_description'      => $data['change_description'],

                'created_at'     	=> date('Y-m-d h:i:s'),
                'updated_at'     	=> date('Y-m-d h:i:s'),
            ]
        );
        
        return $model;
    }
}

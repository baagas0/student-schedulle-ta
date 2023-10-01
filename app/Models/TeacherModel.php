<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    // THESE LINES
    protected $table   = 'teachers';
    protected $protectFields = false;
    protected $allowedFields = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

	public function get($ID = false)
    {
        if ($ID) {
            return $this->db->table('teachers')
            ->where(['teachers.id' => $ID])
            ->get()->getRowArray();
        } else {
            return $this->db->table('teachers')
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
        
        // CREATE USER
        $this->db->table('users')->insert([
			'teacher_id'    => $model->getInsertID(),
			'fullname'		=> $data['name'],
			'username' 		=> $data['email'],
			'password' 		=> password_hash($data['password'], PASSWORD_DEFAULT),
			'role' 			=> 2,
			'created_at'    => date('Y-m-d h:i:s')
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

        // UPDATE USER
        if ($data['password']) {
			$password = password_hash($data['password'], PASSWORD_DEFAULT);
		} else {
            $userModel = new UserModel();
			$user 		= $userModel->getUser(teacherID: $data['id']);
			$password 	= $user['password'];
		}
        $this->db->table('users')->update(
            [
			'fullname'		=> $data['name'],
			'username' 		=> $data['email'],
			'password' 		=> $password,
			'role' 			=> 2,
			'created_at'    => date('Y-m-d h:i:s')
		], [
            'teacher_id'    => $data['id']
        ]
    );
        
        return $model;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class studentsModel extends Model
{
    // THESE LINES
    protected $table   = 'students';
    protected $protectFields = false;
    protected $allowedFields = [
        'nim',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

	public function get($ID = false)
    {
        if ($ID) {
            return $this->db->table('students')
            ->where(['students.id' => $ID])
            ->get()->getRowArray();
        } else {
            return $this->db->table('students')
            ->get()->getResultArray();
        }
    }

	public function createData($data)
    {
        $model = new studentsModel();
        $model->insert([
            'nim'     	    => $data['nim'],
            'name'     	    => $data['name'],
            'email'     	    => $data['email'],
            'created_at'     	=> date('Y-m-d h:i:s'),
            'updated_at'     	=> date('Y-m-d h:i:s'),
        ]);
        
        // CREATE USER
        $this->db->table('users')->insert([
			'student_id'    => $model->getInsertID(),
			'fullname'		=> $data['name'],
			'username' 		=> $data['email'],
			'password' 		=> password_hash($data['password'], PASSWORD_DEFAULT),
			'role' 			=> 3,
			'created_at'    => date('Y-m-d h:i:s')
		]);
        
        return $model;
    }

    public function updateData($data)
    {
        $model = new studentsModel();
        $model->update(
            [
                'id' => $data['id']
            ], [
            'nim'     	    => $data['nim'],
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
			$user 		= $userModel->getUser(studentID: $data['id']);
			$password 	= $user['password'];
		}
        $this->db->table('users')->update(
            [
			'fullname'		=> $data['name'],
			'username' 		=> $data['email'],
			'password' 		=> $password,
			'role' 			=> 3,
			'created_at'    => date('Y-m-d h:i:s')
		], [
            'student_id'    => $data['id']
        ]
    );
        
        return $model;
    }
}

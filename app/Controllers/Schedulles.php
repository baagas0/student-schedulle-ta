<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use App\Models\UserModel;

class Schedulles extends BaseController
{
	public $Model;

	function __construct()
	{
		$this->Model = new TeacherModel();
	}

	public function index()
	{
		$data = array_merge($this->data, [
			'title'         => 'Dosen',
			'data'			=> $this->Model->get()
		]);
		return view('teachers/teachersList', $data);
	}

	public function create()
	{
		$create = $this->Model->createData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url('teachers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url('teachers'));
		}
	}

	public function update()
	{
		$update = $this->Model->updateData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($update) {
			session()->setFlashdata('notif_success', '<b>Successfully update </b>');
			return redirect()->to(base_url('teachers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update </b>');
			return redirect()->to(base_url('teachers'));
		}
	}

	public function delete($ID)
	{
		if (!$ID) {
			return redirect()->to(base_url('teachers'));
		}
		$delete = $this->Model->delete($ID);

		// ALSO DELETE USER
		$userModel = new UserModel();
		$user	   = $userModel->getUser(studentID: $ID);
		$userModel->delete($user['userID']);
		
		if ($delete) {
			session()->setFlashdata('notif_success', '<b>Successfully delete </b>');
			return redirect()->to(base_url('teachers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete </b>');
			return redirect()->to(base_url('teachers'));
		}
	}
}

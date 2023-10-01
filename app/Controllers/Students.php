<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\studentsModel;
use App\Models\UserModel;

class Students extends BaseController
{
	public $Model;

	function __construct()
	{
		$this->Model = new studentsModel();
	}

	public function index()
	{
		$data = array_merge($this->data, [
			'title'         => 'Mahasiswa',
			'data'			=> $this->Model->get()
		]);
		return view('students/studentsList', $data);
	}

	public function form()
	{
		$data = array_merge($this->data, [
			'title'         => 'Mahasiswa'
		]);
		return view('students/studentsForm', $data);
	}

	public function create()
	{
		$create = $this->Model->createData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url('students'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url('students'));
		}
	}

	public function update()
	{
		$update = $this->Model->updateData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($update) {
			session()->setFlashdata('notif_success', '<b>Successfully update </b>');
			return redirect()->to(base_url('students'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update </b>');
			return redirect()->to(base_url('students'));
		}
	}

	public function delete($ID)
	{
		if (!$ID) {
			return redirect()->to(base_url('students'));
		}
		$delete = $this->Model->delete($ID);

		// ALSO DELETE USER
		$userModel = new UserModel();
		$user	   = $userModel->getUser(studentID: $ID);
		$userModel->delete($user['userID']);
		
		if ($delete) {
			session()->setFlashdata('notif_success', '<b>Successfully delete </b>');
			return redirect()->to(base_url('students'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete </b>');
			return redirect()->to(base_url('students'));
		}
	}
}

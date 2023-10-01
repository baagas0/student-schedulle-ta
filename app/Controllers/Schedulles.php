<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SchedulleModel;
use App\Models\UserModel;
use DateTime;

class Schedulles extends BaseController
{
	public $Model;
	public $userModel;

	function __construct()
	{
		$this->Model = new SchedulleModel();
		$this->userModel = new UserModel();
	}

	public function index()
	{
		$data = array_merge($this->data, [
			'title'         => 'Dosen',
			'user'			=> $this->userModel->getUser(username: session()->get('username')),
			'data'			=> $this->Model->get()
		]);

		if($data['user']['student_id']) {
			$student_id = $data['user']['student_id'];

			foreach ($data['data'] as $key => &$item) {
				$item['is_available'] = $this->isSchedulleAvailable($item['id'], $student_id);
			}

			dd($data['data']);
		}

		return view('schedulles/schedullesList', $data);
	}

	public function create()
	{
		$create = $this->Model->createData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($create) {
			session()->setFlashdata('notif_success', '<b>Successfully added new </b>');
			return redirect()->to(base_url('schedulles'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new </b>');
			return redirect()->to(base_url('schedulles'));
		}
	}

	public function update()
	{
		$update = $this->Model->updateData($this->request->getPost(null, FILTER_UNSAFE_RAW));
		if ($update) {
			session()->setFlashdata('notif_success', '<b>Successfully update </b>');
			return redirect()->to(base_url('schedulles'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update </b>');
			return redirect()->to(base_url('schedulles'));
		}
	}

	public function delete($ID)
	{
		if (!$ID) {
			return redirect()->to(base_url('schedulles'));
		}
		$delete = $this->Model->delete($ID);

		// ALSO DELETE USER
		$userModel = new UserModel();
		$user	   = $userModel->getUser(studentID: $ID);
		$userModel->delete($user['userID']);
		
		if ($delete) {
			session()->setFlashdata('notif_success', '<b>Successfully delete </b>');
			return redirect()->to(base_url('schedulles'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete </b>');
			return redirect()->to(base_url('schedulles'));
		}
	}
	
	public function isSchedulleAvailable ($schedulle_id, $student_id) {
		$schedulle = $this->Model->get($schedulle_id);
		$schedulle_actual_date = $schedulle['change_date'] ? $schedulle['change_date'] : $schedulle['date'];
		$schedulle_actual_time = $schedulle['change_time'] ? $schedulle['change_time'] : $schedulle['time'];

		$check = $this->db->table('student_schedulles')
			->where('schedulle_id', $schedulle_id)
			->where('student_id', $student_id)
			->get()
			->getResultArray();
		if (count($check)) return false;
		
		$student_schedulles = $this->db->table('student_schedulles')
			->join('schedulles', 'schedulles.id = student_schedulles.schedulle_id')
			->where('student_id', $student_id)
			->select("
				schedulles.date,
				schedulles.change_date,
				schedulles.time,
				schedulles.change_time
			")
			->get()
			->getResultArray();
			
		foreach ($student_schedulles as $key => $item) {
			$actual_date = $item['change_date'] ? $item['change_date'] : $item['date'];
			$actual_time = $item['change_time'] ? $item['change_time'] : $item['time'];

			if($this->checkBeetwenDate($schedulle_actual_date, [
				$this->findFirstWeek($actual_date),
				$this->findLastWeek($actual_date)
			])) {
				return true;
			}
		}

		return false;
	}

	public function findFirstWeek($date) {
		$tanggal_input = $date;
		$tanggal_input_obj = new DateTime($tanggal_input);
		$hari_dalam_seminggu = $tanggal_input_obj->format('w');
		$selisih_hari = $hari_dalam_seminggu;
		$tanggal_awal_minggu = $tanggal_input_obj->modify("-$selisih_hari days");
		return $tanggal_awal_minggu->format('Y-m-d');
	}
	public function findLastWeek($date) {
		$tanggal_input = $date;
		$tanggal_input_obj = new DateTime($tanggal_input);
		$hari_dalam_seminggu = $tanggal_input_obj->format('w');
		$selisih_hari = 6 - $hari_dalam_seminggu;
		$tanggal_akhir_minggu = $tanggal_input_obj->modify("+$selisih_hari days");
		return $tanggal_akhir_minggu->format('Y-m-d');
	}
	public function checkBeetwenDate($date, $beetwen) {
		$tanggal_pertama = $beetwen[0];
		$tanggal_kedua = $beetwen[1];
		$tanggal_ketiga = $date;

		$tanggal_pertama_obj = new DateTime($tanggal_pertama);
		$tanggal_kedua_obj = new DateTime($tanggal_kedua);
		$tanggal_ketiga_obj = new DateTime($tanggal_ketiga);

		if ($tanggal_ketiga_obj >= $tanggal_pertama_obj && $tanggal_ketiga_obj <= $tanggal_kedua_obj) {
			return true;
		} else {
			return false;
		}
	}

	public function takeSchedulle ($schedulle_id, $student_id) {

	}
}

<?php
		namespace App\Controllers;
		use App\Controllers\BaseController;
		class Teachers extends BaseController
		{
			public function index()
			{
				$data = array_merge($this->data, [
					'title'         => 'Dosen'
				]);
				return view('dosenList', $data);
			}
			public function form()
			{
				$data = array_merge($this->data, [
					'title'         => 'Dosen'
				]);
				return view('dosenForm', $data);
			}
		}
		
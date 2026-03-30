<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rental_spv extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Meload model
		$this->load->model('Main_model', 'model');

		//Jika session tidak ditemukan
		if (!$this->session->userdata('id_user')) {
			//Kembali ke halaman Login
			$this->session->set_flashdata('status1', 'expired');
			redirect('login');
		}
	}

	public function index()
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
      	if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Rental Vehicle Supervisor";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalSpv/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			// var_dump($id_dept);
			// var_dump($id_user);

			$data['rental'] = $this->model->rentalSpv($id_dept)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function approveRequest()
	{
		
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
      	if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Request";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalSpv/approveRequest";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			$data['dd_dept'] = $this->model->dropdown_request();
			$data['id_dept'] = "";

			$data['dd_vehicle'] = $this->model->dropdown_vehicle('');
			$data['id_vehicle'] = "";

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function submit()
	{
		$this->form_validation->set_rules(
			'id_dept',
			'id_dept',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'id_vehicle',
			'id_vehicle',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'driver_yn',
			'driver_yn',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'req_date',
			'req_date',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'keterangan',
			'keterangan',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);


		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
					$data['title'] 	= "Request";
					$data['navbar']   = "navbar";
					$data['sidebar']  = "sidebar";
					$data['body']     = "rental/buatRequest";

					//Session
					$id_dept 	= $this->session->userdata('id_dept');
					$id_user 	= $this->session->userdata('id_user');

					$data['profile'] = $this->model->profile($id_user)->row_array();

					$data['dd_dept'] = $this->model->dropdown_request();
					$data['id_dept'] = "";

					$data['dd_vehicle'] = $this->model->dropdown_vehicle('');
					$data['id_vehicle'] = "";

					$data['error'] = "";

					//Load template
					$this->load->view('template', $data);
				} else {
					redirect('Errorpage');
				}
			} else {
				//Session
				$id_user 	= $this->session->userdata('id_user');
				$id_req 		= $this->model->getIdReq($this->input->post('id_vehicle'));
				$date       = date("Y-m-d  H:i:s");

				//Konfigurasi Upload Gambar
				$config['upload_path'] 		= './uploads/';		//Folder untuk menyimpan gambar
				$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
				$config['max_size'] 			= '25600';			//Ukuran maksimum file gambar yang diizinkan
				$config['max_width']       = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
				$config['max_height']      = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('path_photo')) {

					if ($_FILES['path_photo']['error'] != 4) {
						$data['title'] 	= "Request";
						$data['navbar']   = "navbar";
						$data['sidebar']  = "sidebar";
						$data['body']     = "rental/buatRequest";
						//Session
						$id_dept 	= $this->session->userdata('id_dept');
						$id_user 	= $this->session->userdata('id_user');

						$data['profile'] = $this->model->profile($id_user)->row_array();

						$data['dd_dept'] = $this->model->dropdown_request();
						$data['id_dept'] = "";

						$data['dd_vehicle'] = $this->model->dropdown_vehicle('');
						$data['id_vehicle'] = "";

						$data['error'] = $this->upload->display_errors();

						$this->load->view('template', $data);
					} else {
						$data = array(
							'id_req'			=> $id_req,
							'user_req'		=> $id_user,
							'target_dept'	=> $this->input->post('id_dept'),
							'vehicle'		=> $this->input->post('id_vehicle'),
							'driver_yn'		=> $this->input->post('driver_yn'),
							'desc'			=> ucfirst($this->input->post('keterangan')),
							'path_photo'	=> 'no-image.jpg',
							'req_date'		=> ucfirst($this->input->post('req_date')),
							'dept'			=> $id_dept,
							'status'			=> '1'
						);

						$this->db->insert('request_vehicle', $data);
						// $this->model->emailbuatticket($ticket);
						$this->session->set_flashdata('status', 'Dikirim');

						redirect('rental_spv');
					}
				} else {
					$gambar = $this->upload->data();
					$data = array(
						'id_req'			=> $id_req,
						'user_req'		=> $id_user,
						'target_dept'	=> $this->input->post('id_dept'),
						'vehicle'		=> $this->input->post('id_vehicle'),
						'driver_yn'		=> $this->input->post('driver_yn'),
						'desc'			=> ucfirst($this->input->post('keterangan')),
						'path_photo'	=> 'no-image.jpg',
						'req_date'		=> ucfirst($this->input->post('req_date')),
						'dept'			=> $id_dept,
						'status'			=> '1'
					);

					$this->db->insert('request_vehicle', $data);
					// $this->model->emailbuatticket($ticket);
					$this->session->set_flashdata('status', 'Dikirim');

					redirect('rental_spv');
				}
			}
	}


	public function approve($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {

			$data['title'] 	= "Approve Request Supervisor";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalSpv/approveRequest";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			$data['vehicle'] = $this->model->detail_request($id)->row_array();

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}


	public function process($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {

			$action = $this->input->post('action_type');
			$desc = $this->input->post('spv_desc_input');

			if ($action === 'approve') {

				$this->model->approveSpvVehicle($id, $desc);
				$this->session->set_flashdata('status', 'Diteruskan');

			} elseif ($action === 'reject') {

				$this->model->rejectSpvVehicle($id, $desc);
				$this->session->set_flashdata('status', 'Ditolak');

			}

			redirect('rental_spv');
		} else {
			redirect('Errorpage');
		}
	}

}

<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rental extends CI_Controller
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
			$data['title'] 	= "Rental Vehicle";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rental/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['rental'] = $this->model->rental($id_user)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function buatRequest()
	{
		
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
      if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Request";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rental/buatRequest";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			//$data['ticket'] = $this->model->getkodeticket();
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
			'req_time',
			'req_time',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'end_date',
			'end_date',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'end_time',
			'end_time',
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
					$status = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? 2 : 1;
					$user_spv = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? $this->session->userdata('id_user') : "";
					$spv_desc = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? "Automatically By System" : "";

					$req_date = $this->input->post('req_date');
					$req_time = $this->input->post('req_time');
					$req_datetime = date('Y-m-d H:i:s', strtotime("$req_date $req_time"));

					$end_date = $this->input->post('end_date');
					$end_time = $this->input->post('end_time');
					$end_datetime = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));

					$data = array(
						'id_req'			=> $id_req,
						'user_req'		=> $id_user,
						'target_dept'	=> $this->input->post('id_dept'),
						'vehicle'		=> $this->input->post('id_vehicle'),
						'driver_yn'		=> $this->input->post('driver_yn'),
						'desc'			=> ucfirst($this->input->post('keterangan')),
						'path_photo'	=> 'no-image.jpg',
						'req_date'		=> $req_datetime,
						'end_date'		=> $end_datetime,
						'dept'			=> $this->session->userdata('id_dept'),
						'status'			=> $status,
						'user_spv'		=> $user_spv,
						'spv_desc'		=> $spv_desc
					);

					$this->db->insert('request_vehicle', $data);
					$this->model->email_rental($id_req);
					$this->session->set_flashdata('status', 'Dikirim');

					redirect('rental');
				}
			} else {
				$status = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? 2 : 1;
				$user_spv = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? $this->session->userdata('id_user') : "";
				$spv_desc = in_array($this->session->userdata('level'),["SPV", "SPVU", "SPVM", "MGR", "MGRD"]) ? "Automatically By System" : "";
				$gambar = $this->upload->data();

				$req_date = $this->input->post('req_date');
				$req_time = $this->input->post('req_time');
				$req_datetime = date('Y-m-d H:i:s', strtotime("$req_date $req_time"));

				$end_date = $this->input->post('end_date');
				$end_time = $this->input->post('end_time');
				$end_datetime = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));

				$data = array(
					'id_req'			=> $id_req,
					'user_req'		=> $id_user,
					'target_dept'	=> $this->input->post('id_dept'),
					'vehicle'		=> $this->input->post('id_vehicle'),
					'driver_yn'		=> $this->input->post('driver_yn'),
					'desc'			=> ucfirst($this->input->post('keterangan')),
					'path_photo'	=> $gambar['file_name'],
					'req_date'		=> $req_datetime,
					'end_date'		=> $end_datetime,
					'dept'			=> $this->session->userdata('id_dept'),
					'status'			=> $status,
					'user_spv'		=> $user_spv,
					'spv_desc'		=> $spv_desc
				);

				$this->db->insert('request_vehicle', $data);
				$this->model->email_rental($id_req);
				$this->session->set_flashdata('status', 'Dikirim');

				redirect('rental');
			}
		}
	}

	public function return($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Return Vehicle";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rental/return";

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

	public function returned($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {

			//Konfigurasi Upload Gambar
			$config['upload_path'] 		= './uploads/';		//Folder untuk menyimpan gambar
			$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
			$config['max_size'] 			= '25600';			//Ukuran maksimum file gambar yang diizinkan
			$config['max_width']       = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
			$config['max_height']      = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('path_return')) {

				if ($_FILES['path_return']['error'] != 4) {
					$data['title'] 	= "Return Vehiclex";
					$data['navbar']   = "navbar";
					$data['sidebar']  = "sidebar";
					$data['body']     = "rental/return";
					//Session
					$id_dept 	= $this->session->userdata('id_dept');
					$id_user 	= $this->session->userdata('id_user');

					$data['vehicle'] = $this->model->detail_request($id)->row_array();

					$data['error'] = $this->upload->display_errors();

					$this->load->view('template', $data);
				} else {

					$photo = 'no-image.jpg';
					$desc = $this->input->post('return_desc');

					$this->model->returnVehicle($id, $photo, $desc);
					$this->session->set_flashdata('status', 'Dikembalikan');
					redirect('rental');
				}
			} else {

				$gambar = $this->upload->data();
				$desc = $this->input->post('return_desc');

				$this->model->returnVehicle($id, $gambar['file_name'], $desc);
				$this->session->set_flashdata('status', 'Dikembalikan');
				redirect('rental');
			}

		} else {
			redirect('Errorpage');
		}
	}

	public function detail($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {

			$data['title'] 	= "Detail Request";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rental/detailRequest";

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

	// //Export to Excel
   //  public function export_excel()
   //  {
	// 	  $id_user 	= $this->session->userdata('id_user');
   //      $listticket = $this->model->list_ticket_spv($id_user)->result();

   //      header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   //      header("Content-Disposition: attachment; filename=work_order.xls");
   //      header("Pragma: no-cache");
   //      header("Expires: 0");

   //      $output = fopen("php://output", "w");

   //      // UTF-8 BOM (biar Excel rapi & tidak rusak karakter)
   //      fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

   //      // HEADER KOLOM (SAMA DENGAN TABEL)
   //      fputcsv($output, [
   //          'No',
   //          'No Work Order',
   //          'Tanggal',
   //          'Nama',
   //          'Sub Kategori',
   //          'Prioritas',
   //          'Status'
   //      ], ';');

   //      $no = 1;
   //      foreach ($listticket as $row) {

   //          $prioritas = ($row->id_prioritas == 0) 
   //              ? 'Not set yet' 
   //              : $row->nama_prioritas;

   //          $status = $this->_status_text($row->status);

   //          fputcsv($output, [
   //              $no++,
   //              $row->id_ticket,
   //              date('Y-m-d', strtotime($row->tanggal)),
   //              $row->nama,
   //              $row->nama_sub_kategori,
   //              $prioritas,
   //              $status
   //          ], ';');
   //      }

   //      fclose($output);
   //      exit;
   //  }

   //  private function _status_text($status)
   //  {
   //      $list = [
   //          0 => 'Work Order Rejected',
   //          1 => 'Work Order Submitted',
   //          2 => 'Category Changed',
   //          3 => 'Assigned to Technician',
   //          4 => 'On Process',
   //          5 => 'Waiting Sparepart',
   //          6 => 'Solve',
   //          7 => 'Late Finished',
   //          8 => 'Approved Supervisor',
   //          9 => 'Assign by Manager',
   //          10 => 'Work Order Returned',
   //          11 => 'Approved Manager',
   //          12 => 'Closed',
   //          13 => 'Return to Technician'
   //      ];
   //      return $list[$status] ?? '-';
   //  }
}

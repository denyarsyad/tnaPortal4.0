<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rental_pic extends CI_Controller
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
			$data['title'] 	= "Rental Vehicle PIC";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalPic/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			// var_dump($id_dept);
			// var_dump($id_user);

			$data['rental'] = $this->model->rentalPic($id_dept)->result(); //id tidak dipakai

			//Load template
			$this->load->view('template', $data);
		} else {
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function approve($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Approve Request PIC";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalPic/approveRequest";

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
			$driver_name = $this->input->post('driver_name');
			$vehicle_name = $this->input->post('vehicle_name');
			$desc = $this->input->post('pic_desc');

			if ($action === 'approve') {

				$this->model->approvePicVehicle($id, $driver_name, $vehicle_name, $desc);
         		$this->session->set_flashdata('status', 'Disetujui');

			} elseif ($action === 'reject') {

				$this->model->rejectPicVehicle($id, $desc);
				$this->session->set_flashdata('status', 'Ditolak');

			}

			redirect('rental_pic');
		} else {
			redirect('Errorpage');
		}
	}

	public function finish($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Finishing";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "rentalPic/finished";

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

	public function finished($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$desc = $this->input->post('pic_dreturn_desc');
			$this->model->finishedVehicle($id, $desc);
			$this->session->set_flashdata('status', 'Selesai');
			redirect('rental_pic');
		} else {
			redirect('Errorpage');
		}
	}

	public function giveBack($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$desc = $this->input->post('pic_dreturn_desc');
			$this->model->giveBackVehicle($id, $desc);
			$this->session->set_flashdata('status', 'Dikembalikan');
			redirect('rental_pic');
		} else {
			redirect('Errorpage');
		}
	}
	
}

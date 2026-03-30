<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends CI_Controller
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
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {

			$data['title'] 	= "Assets";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "asset/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['assets'] = $this->model->assets()->result();

			$data['dd_pegawai'] = $this->model->dropdown_pegawai();
			$data['id_pegawai'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function tambah()
	{
		$this->form_validation->set_rules(
			'category',
			'category',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'id_pegawai',
			'id_pegawai',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				$data['title'] 	  = "Assets";
				$data['navbar']     = "navbar";
				$data['sidebar']    = "sidebar";
				$data['modal_show'] = "$('#modal-fade').modal('show');";
				$data['body']       = "asset/index";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				$data['assets'] = $this->model->assets()->result();

				$data['dd_pegawai'] = $this->model->dropdown_pegawai();
				$data['id_pegawai'] = "";

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {

			$code_id = $this->model->getCodeAsset($this->input->post('id_pegawai'));
			$data = array(
				'id_asset'			=> $code_id,
				'category' 			=> $this->input->post('category'),
				'id_user'  			=> $this->input->post('id_pegawai'),
				'computer_name'  	=> $this->input->post('computer_name'),
				'manufacturing'  	=> $this->input->post('manufacturing'),
				'device_model'   	=> $this->input->post('device_model'),
				'serial_number'  	=> strtoupper($this->input->post('serial_number')),
				'year'  				=> $this->input->post('year'),
				'desc'  				=> $this->input->post('desc'),
				'os_name'  			=> $this->input->post('os_name'),
				'status'  			=> $this->input->post('status'),
				'location'  		=> $this->input->post('location'),
				'priority'  		=> $this->input->post('priority')
			);

			$this->db->insert('assets', $data);

			$this->session->set_flashdata('status', 'Ditambahkan');

			redirect('asset');
		}
	}

	public function hapus($id)
	{
		$this->db->where('id_asset', $id);
		$this->db->delete('assets');

		$this->session->set_flashdata('status', 'Dihapus');

		redirect('asset');
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {

			$data['title'] 	= "Edit Asset";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "asset/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['asset'] = $this->model->getAsset($id)->row_array();
			$data['dd_user'] = $this->model->dropdown_pegawai();
			$data['id_user'] = "";
			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function update($id)
	{

		$this->form_validation->set_rules(
			'category',
			'category',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'id_user',
			'id_user',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit departemen
				$data['title'] 	= "Edit Asset";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "asset/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				$data['asset'] = $this->model->getAsset($id)->row_array();
				$data['dd_user'] = $this->model->dropdown_pegawai();
				$data['id_user'] = "";

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {

				$data = array(
					'computer_name'  	=> $this->input->post('computer_name'),
					'manufacturing'  	=> $this->input->post('manufacturing'),
					'device_model'   	=> $this->input->post('device_model'),
					'serial_number'  	=> strtoupper($this->input->post('serial_number')),
					'year'  				=> $this->input->post('year'),
					'desc'  				=> $this->input->post('desc'),
					'os_name'  			=> $this->input->post('os_name'),
					'status'  			=> $this->input->post('status'),
					'location'  		=> $this->input->post('location'),
					'priority'  		=> $this->input->post('priority')
				);

				$this->db->where('id_asset', $id);
				$this->db->update('assets', $data);

				$this->session->set_flashdata('status', 'Diperbarui');

				redirect('asset');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}

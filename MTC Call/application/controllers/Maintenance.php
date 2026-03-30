<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller
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
			$data['title'] 	  = "Downtime";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "maintenance/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['maintenance'] = $this->model->maintenance($id_user)->result();

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
			$data['title'] 	  = "Create Downtime";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "maintenance/buatRequest";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			$data['dd_dept'] = $this->model->dropdown_request();
			$data['id_dept'] = "";

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

    public function getMachineById()
    {
        $machine_id = $this->input->post('machine_id');
        //$machine = $this->db->get_where('machines', ['machine_id' => $machine_id])->row();
        $machine = $this->model->getMachineById($machine_id);

        if ($machine) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'machine_name' => $machine->machine_name
                ]
            ]);
        } else {
            echo json_encode(['success' => false]);
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
			'note',
			'note',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

      $this->form_validation->set_rules(
			'machine_id',
			'machine_id',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'machine_name',
			'machine_name',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];

			if (in_array($this->session->userdata('level'), $level)) {
				$id_user = $this->session->userdata('id_user');
				$data = [
						'title'    => "Work Order Management",
						'navbar'   => "navbar",
						'sidebar'  => "sidebar",
						'body'     => "maintenance/buatRequest",
						'profile'  => $this->model->profile($id_user)->row_array(),
						'dd_dept'  => $this->model->dropdown_request(),
						'id_dept'  => "",
						'error'    => ""
				];

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$count = $this->model->checkRepairingMachine(strtoupper($this->input->post('machine_id')));
			if ($count > 0) {
				$this->session->set_flashdata('error', 'Mesin ' . strtoupper($this->input->post('machine_id')) . ' masih dalam perbaikan.');
				redirect('maintenance/buatRequest');
			}

			// ===============================
			// CONFIG UPLOAD
			// ===============================
			$config = [
				'upload_path'   => './uploads/',
				'allowed_types' => 'gif|jpg|jpeg|png|pdf',
				'max_size'      => 25600,
				'max_width'     => 0,
				'max_height'    => 0
			];

			// Default jika tidak upload
			$gambar1 = "no-image.jpg";
			$gambar2 = "no-image.jpg";

			// ===============================
			// UPLOAD FOTO 1
			// ===============================
			if (!empty($_FILES['path_photo_1']['name'])) {

				// Instance upload #1
				$this->load->library('upload', $config, 'photo1');

				if ($this->photo1->do_upload('path_photo_1')) {
						$gambar1 = $this->photo1->data('file_name');
				} else {
						$this->loadUploadError();
						return;
				}
			}

			// ===============================
			// UPLOAD FOTO 2
			// ===============================
			if (!empty($_FILES['path_photo_2']['name'])) {

				// Instance upload #2
				$this->load->library('upload', $config, 'photo2');

				if ($this->photo2->do_upload('path_photo_2')) {
						$gambar2 = $this->photo2->data('file_name');
				} else {
						$this->loadUploadError();
						return;
				}
			}
			// ===============================
			// GET USER NAME
			// ===============================
			$id_user = $this->session->userdata('id_user');

			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();

			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			// ===============================
			// DATETIME
			// ===============================
			$req_date     = $this->input->post('req_date');
			$req_time     = $this->input->post('req_time');
			$req_datetime = date('Y-m-d H:i:s', strtotime("$req_date $req_time"));

			// ===============================
			// WO ID
			// ===============================
			$wo_id = $this->model->getIdWo($id_user);

			// ===============================
			// DATA INSERT
			// ===============================
			$dataInsert = [
				'wo_id'         => strtoupper($wo_id),
				'machine_id'    => strtoupper($this->input->post('machine_id')),
				'machine_name'  => $this->input->post('machine_name'),
				'req_id'        => $id_user,
				'req_name'      => $user_name,
				'wo_date'       => date("Y-m-d"),
				'req_message'   => $this->input->post('req_message'),
				'req_time'      => $req_datetime,
				'status'        => "0",
				'sound_yn'      => "N",
				'path_photo_1'  => $gambar1,
				'path_photo_2'  => $gambar2
			];

			// Save ke DB
			$this->db->insert('work_order_management', $dataInsert);
			$this->session->set_flashdata('status', 'Dikirim');
			redirect('maintenance/index');
		}
	}

	private function loadUploadError()
	{
		$id_user  = $this->session->userdata('id_user');
		$data = [
			'title'    => "Work Order Management",
			'navbar'   => "navbar",
			'sidebar'  => "sidebar",
			'body'     => "maintenance/buatRequest",
			'profile'  => $this->model->profile($id_user)->row_array(),
			'dd_dept'  => $this->model->dropdown_request(),
			'id_dept'  => "",
			'error'    => $this->upload->display_errors()
		];
		$this->load->view('template', $data);
	}




	
}

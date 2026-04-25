<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance_act extends CI_Controller
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
			$data['title'] 	= "Work Order Management";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "maintenanceAct/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['maintenanceAct'] = $this->model->maintenanceAct($id_user)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

public function actCheck($id)
	{
	  $level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
      if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Maintenance Action";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "maintenanceAct/actCheck";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();
			$data['maintenanceAct'] = $this->model->act($id)->row_array();

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

   public function act($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
      if (in_array($this->session->userdata('level'), $level)) {
			$data['title'] 	= "Maintenance Action";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "maintenanceAct/act";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();
			$data['maintenanceAct'] = $this->model->act($id)->row_array();

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

    public function getMachineById()
    {
        $machine_id = $this->input->post('machine_idScan');
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

	public function actCheckSubmit($id)
	{
		$this->form_validation->set_rules(
			'machine_idScan', 
			'Machine ID', 
			'required',
			array('required' => 'Scan Machine ID tidak boleh kosong!')
		);
		$this->form_validation->set_rules(
			'machine_name', 
			'Machine Name', 
			'required',
			array('required' => 'Nama Mesin harus terisi otomatis setelah scan!')
		);

		if ($this->form_validation->run() == FALSE) {
			$this->form_validation->set_error_delimiters('', '');
			$this->session->set_flashdata('status', validation_errors()); 
			
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actCheck";

				$id_user = $this->session->userdata('id_user');
				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$cekMachineId  = $this->input->post('machine_idScan'); 
			$realMachineId = $this->input->post('machine_id');

			if ($cekMachineId !== $realMachineId) {
				$this->session->set_flashdata('status', 'Gagal! Machine ID yang di-scan (' . $cekMachineId . ') tidak sesuai dengan WO (' . $realMachineId . ')');
				redirect('maintenance_act/actCheck/'.$id);
			} else {
				$id_user = $this->session->userdata('id_user');
				
				$query = $this->db->select('p.nama')
								->from('pegawai p')
								->where('p.nik', $id_user)
								->get();
				$user_name = ($query->num_rows() > 0) ? $query->row()->nama : "Unknown";

				$update_data = array(
					'checker_id'   => $id_user,
					'checker_name' => $user_name,
					'checker_time' => date("Y-m-d H:i:s"),
					'sound_yn'     => "Y",
					'status'       => "6" // Contoh status CHECKED
				);

				$this->db->where('wo_id', $id);
				$this->db->update('work_order_management', $update_data);

				// Berhasil!
				$this->session->set_flashdata('status', 'Data Berhasil di-Check!');
				redirect('maintenance_act/index');
			}
		}
	}

    public function submit($id)
	{
		$mtc_id2 = $this->input->post('mtc_id2');
		$mtc_name2 = $this->input->post('mtc_name2');

		if (!empty($mtc_id2) && empty($mtc_name2)) {
			$this->session->set_flashdata('error', 'Tolong NIKnya tekan enter agar nama teknisi muncul.');
			redirect('maintenance_act/index');
			return; 
		}

		$note = $this->input->post('note');
		if ($note == 'Y') {
			redirect('maintenance_act/actDone/'.$id. '/' . $mtc_id2. '/'. $mtc_name2);
		} 
		else if ($note == 'N') {
			redirect('maintenance_act/actDoneWS/'.$id. '/' . $mtc_id2. '/'. $mtc_name2);
		} 
		else if ($note == 'P') {
			redirect('maintenance_act/actPending/'.$id. '/' . $mtc_id2. '/'. $mtc_name2);
		} 
		else if ($note == 'C') {
			redirect('maintenance_act/actChanged/'.$id. '/' . $mtc_id2. '/'. $mtc_name2);
		}
		else {
			echo "Kamu gak pilih combo";
		}
	}

	public function actDone($id, $mtcID, $mtcName)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Done";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actDone";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";
			
			//2026.04.25
			$data['mtcID']   = $mtcID;
    		$data['mtcName'] = $mtcName;

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actDoneWS($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Done With Spare Part";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actDoneWS";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actPending($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Pending";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actPending";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actConfirm($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"]; //ini di atur sesuai jabatan
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Confirm";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actConfirm";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actDetail($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"]; //ini di atur sesuai jabatan
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Detail";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actDetail";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actShow($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"]; //ini di atur sesuai jabatan
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Detail";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actShow";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function done($mtcID, $mtcName)
	{
		$this->form_validation->set_rules(
			'root_cause',
			'root_cause',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'temp_act',
			'temp_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		$this->form_validation->set_rules(
			'prev_act',
			'prev_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action - Done";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actDone";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['status'] = "done";  
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$data = array(
				// 'checker_id'    => $id_user,
				// 'checker_name' => $user_name,
				// 'checker_time'  => date("Y-m-d H:i:s"),
				'mtc_id'    	 => $id_user,
				'mtc_name' 		 => $user_name,
				'mtc_time'  	 => date("Y-m-d H:i:s"),
				'root_cause'    => $this->input->post('root_cause'),
				'temp_act'   	 => $this->input->post('temp_act'),
				'prev_act'   	 => $this->input->post('prev_act'),
				'mtc_id2'		=> $mtcID,
				'mtc_name2'		=> urldecode($mtcName),
				'sound_yn'		 => "Y",
				'status'        => "2" //REPAIRED OR DONE
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Data Berhasil Diselesaikan (Done)!');
			redirect('maintenance_act/index');
		}
	}

	public function doneWS()
	{
		$this->form_validation->set_rules(
			'mtc_message',
			'mtc_message',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'root_cause',
			'root_cause',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'temp_act',
			'temp_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'prev_act',
			'prev_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action - Done With Spare Part";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actDoneWS";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['status'] = "done";  
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$data = array(
				// 'checker_id'    => $id_user,
				// 'checker_name' => $user_name,
				// 'checker_time'  => date("Y-m-d H:i:s"),
				'mtc_id'    	 => $id_user,
				'mtc_name' 		 => $user_name,
				'mtc_time'  	 => date("Y-m-d H:i:s"),
				'mtc_message'   => $this->input->post('mtc_message'),
				'root_cause'    => $this->input->post('root_cause'),
				'temp_act'   	 => $this->input->post('temp_act'),
				'prev_act'   	 => $this->input->post('prev_act'),
				'sound_yn'		 => "Y",
				'status'        => "2" //REPAIRED OR DONE
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Berhasil (Done With Spare Part)');
			redirect('maintenance_act/index');
		}
	}

	public function pending()
	{
		$this->form_validation->set_rules(
			'mtc_message',
			'mtc_message',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'root_cause',
			'root_cause',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'temp_act',
			'temp_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'prev_act',
			'prev_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action - Pending";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actPending";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['status'] = "done";  
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$data = array(
				// 'checker_id'    	=> $id_user,
				// 'checker_name' 	=> $user_name,
				// 'checker_time'  	=> date("Y-m-d H:i:s"),
				// 'checker_message' => $this->input->post('mtc_message'),
				'root_cause'    	=> $this->input->post('root_cause'),
				'temp_act'   	 	=> $this->input->post('temp_act'),
				'prev_act'   	 	=> $this->input->post('prev_act'),
				'sound_yn'		 	=> "Y",
				'status'        	=> "1" //PENDING
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Berhasil Pending');
			redirect('maintenance_act/index');
		}
	}

	public function action()
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"]; //atur sesuai jabatan
		if (in_array($this->session->userdata('level'), $level)) {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$action = $this->input->post('action');
			if ($action == 'confirm') {
				$data = array(
					'approver_id'   	 => $id_user,
					'approver_name'    	 => $user_name,
					'approve_time' 	 	 => date("Y-m-d H:i:s"),
					//'approver_message'   => $this->input->post('approver_message'),
					'sound_yn'		 	 => "Y",
					'status'        	 => "3" //APPROVED OR CONFIRMED
				);

				$this->db->where('wo_id', $this->input->post('wo_id'));
				$this->db->update('work_order_management', $data);
				$this->session->set_flashdata('status', "Berhasil Approved");
			} else {
				$data = array(
					// 'checker_id'   	 => "",
					// 'checker_name' 	 => "",
					// 'checker_time' 	 => "",
					'mtc_id'    		 => "",
					'mtc_name' 			 => "",
					'mtc_time'  		 => "",
					'mtc_message'  	 => "",
					'root_cause'   	 => "",
					'temp_act'   		 => "",
					'prev_act'   	 	 => "",
					'approver_id'   	 => $id_user,
					'approver_name'    => $user_name,
					'approve_time' 	 => date("Y-m-d H:i:s"),
					'approver_message' => $this->input->post('approver_message'),
					'sound_yn'		 	 => "Y",
					'status'        	 => "0" //RETURN TO SUBMITTED
				);

				$this->db->where('wo_id', $this->input->post('wo_id'));
				$this->db->update('work_order_management', $data);
				$this->session->set_flashdata('status', 'Returned');
			}
			redirect('maintenance/index');
			
		} else {
			redirect('Errorpage');
		}
		
	}

	public function actChanged($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Changed Machine";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actChanged";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function actChangedDone($id)
	{
		$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
		if (in_array($this->session->userdata('level'), $level)) {
			$data['title']   = "Maintenance Action - Changed Machine Done";
			$data['navbar']  = "navbar";
			$data['sidebar'] = "sidebar";
			$data['body']    = "maintenanceAct/actChangedDone";

			// Session
			$id_dept  = $this->session->userdata('id_dept');
			$id_user  = $this->session->userdata('id_user');

			$data['profile'] = $this->model->profile($id_user)->row_array();

			// ambil data maintenance berdasarkan id
			$data['maintenanceAct'] = $this->model->act($id)->row_array();
			// boleh beri indikator bahwa ini status DONE
			$data['status'] = "done";  
			$data['error'] = "";

			// load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function doneChanged()
	{
		$this->form_validation->set_rules(
			'machine_name_change',
			'machine_name_change',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action - Done With Change Machine";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actChanged";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['status'] = "done";  
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$data = array(
				'mtc_id'    	 => $id_user,
				'mtc_name' 		 => $user_name,
				'mtc_time'  	 => date("Y-m-d H:i:s"),
				'change_mc'   	 => $this->input->post('machine_idScan'),
				'sound_yn'		 => "Y",
				'status'         => "7" //Changed machine
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Berhasil (Chaged Machine)');
			redirect('maintenance_act/index');
		}
	}

	public function doneChangedDone()
	{
		$this->form_validation->set_rules(
			'root_cause',
			'root_cause',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'temp_act',
			'temp_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		$this->form_validation->set_rules(
			'prev_act',
			'prev_act',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action - Change Machine Done";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actChangedDone";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();
				$data['status'] = "done";  
				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user  = $this->session->userdata('id_user');
			$query = $this->db->select('p.nama')
									->from('pegawai p')
									->where('p.nik', $id_user)
									->get();
			$user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			$data = array(
				'repair_id'    	 => $id_user,
				'repair_name' 	 => $user_name,
				'repair_time'  	 => date("Y-m-d H:i:s"),
				'root_cause'     => $this->input->post('root_cause'),
				'temp_act'   	 => $this->input->post('temp_act'),
				'prev_act'   	 => $this->input->post('prev_act'),
				'sound_yn'		 => "Y",
				'status'         => "2" //Done
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Data Berhasil Diselesaikan (Done)!');
			redirect('maintenance_act/index');
		}
	}

	public function actUpdate($id)
	{
		$config = array(
			array('field' => 'root_cause', 'label' => 'Root Cause', 'rules' => 'required'),
			array('field' => 'temp_act', 'label' => 'Temporary Action', 'rules' => 'required'),
			array('field' => 'prev_act', 'label' => 'Preventive Action', 'rules' => 'required'),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '<strong>Failed!</strong> Field %s harus diisi.');

		if ($this->form_validation->run() == FALSE) {
			$allowed_levels = ["Admin", "SPVU"];
			if (in_array($this->session->userdata('level'), $allowed_levels)) {
				$id_user = $this->session->userdata('id_user');
				$data = [
					'title'          => "Maintenance Action - Detail",
					'navbar'         => "navbar",
					'sidebar'        => "sidebar",
					'body'           => "maintenanceAct/actDetail",
					'profile'        => $this->model->profile($id_user)->row_array(),
					'maintenanceAct' => $this->model->act($id)->row_array(),
					'error'          => ""
				];

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$id_user = $this->session->userdata('id_user');
			$user = $this->db->get_where('pegawai', ['nik' => $id_user])->row();

			$update_data = [
				//'mtc_id'     => $id_user,
				//'mtc_name'   => ($user) ? $user->nama : 'Unknown',
				//'mtc_time'   => date("Y-m-d H:i:s"),
				'root_cause' => $this->input->post('root_cause'),
				'temp_act'   => $this->input->post('temp_act'),
				'prev_act'   => $this->input->post('prev_act'),
				'status'     => "2" //Done
			];

			$this->db->where('wo_id', $id);
			$this->db->update('work_order_management', $update_data);

			$this->session->set_flashdata('status', 'Berhasil Update');
			redirect('maintenance_act/index');
		}
	}

	public function actNoted($id)
	{
		$config = array(
			array('field' => 'mgr_note', 'label' => 'Manager Note', 'rules' => 'required'),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '<strong>Failed!</strong> %s harus diisi.');

		if ($this->form_validation->run() == FALSE) {
			$allowed_levels = ["MGR"];
			if (in_array($this->session->userdata('level'), $allowed_levels)) {
				$id_user = $this->session->userdata('id_user');
				
				$data = [
					'title'          => "Maintenance Action - Detail",
					'navbar'         => "navbar",
					'sidebar'        => "sidebar",
					'body'           => "maintenanceAct/actDetail",
					'profile'        => $this->model->profile($id_user)->row_array(),
					'maintenanceAct' => $this->model->act($id)->row_array(),
					'error'          => ""
				];

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {
			$update_data = [
				'mgr_note' => $this->input->post('mgr_note'),
			];

			$this->db->where('wo_id', $id);
			$this->db->update('work_order_management', $update_data);

			$this->session->set_flashdata('status', 'Berhasil menambahkan Note Manager');
			redirect('maintenance_act/index');
		}
	}

	//2026.04.24
	public function getNameById()
    {
        $mtc_id = $this->input->post('mtc_id2');
        $name = $this->model->getNameById($mtc_id);

        if ($name) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'mtc_name' => $name->mtc_name
                ]
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }


}

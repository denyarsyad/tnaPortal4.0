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
		$this->session->set_flashdata("IYE KAH?");
		// $this->form_validation->set_rules(
		// 	'machine_idScan',
		// 	'machine_idScan',
		// 	'required',
		// 	array(
		// 		'required' => '<strong>Failed!</strong> Field Harus diisi.'
		// 	)
		// );
		// $this->form_validation->set_rules(
		// 	'machine_name',
		// 	'machine_name',
		// 	'required',
		// 	array(
		// 		'required' => '<strong>Failed!</strong> Field Harus diisi.'
		// 	)
		// );

		if ($this->form_validation->run() == FALSE) {
			$level = ["Admin", "Technician", "User", "SPV", "MGR", "SPVU", "SPVM", "MGRD"];
			if (in_array($this->session->userdata('level'), $level)) {
				$data['title']   = "Maintenance Action";
				$data['navbar']  = "navbar";
				$data['sidebar'] = "sidebar";
				$data['body']    = "maintenanceAct/actCheck";

				// Session
				$id_dept  = $this->session->userdata('id_dept');
				$id_user  = $this->session->userdata('id_user');

				$data['profile'] = $this->model->profile($id_user)->row_array();
				$data['maintenanceAct'] = $this->model->act($id)->row_array();

				$data['error'] = "";

				$this->load->view('template', $data);
			} else {
				redirect('Errorpage');
			}
		} else {

			$cekMachineId = $this->input->post('machine_idScan'); 
			$realMachineId = $this->input->post('machine_id');

			$this->session->set_flashdata("cek = " . $cekMachineId . "dan ini : " . $realMachineId);
			redirect('maintenance_act/actCheck/'.$id);


			// $id_user  = $this->session->userdata('id_user');
			// $query = $this->db->select('p.nama')
			// 						->from('pegawai p')
			// 						->where('p.nik', $id_user)
			// 						->get();
			// $user_name = ($query->num_rows() > 0) ? $query->row()->nama : null;

			// $data = array(
			// 	'checker_id'    => $id_user,
			// 	'checker_name'  => $user_name,
			// 	'checker_time'  => date("Y-m-d H:i:s"),
			// 	'sound_yn'		=> "Y",
			// 	'status'        => "6" //CHECKED
			// );

			// $this->db->where('wo_id', $this->input->post('wo_id'));
			// $this->db->update('work_order_management', $data);
			// $this->session->set_flashdata('Checked');
			// redirect('maintenance_act/index');
		}

	}

    public function submit($id)
	{
		$note = $this->input->post('note');
		if ($note == 'Y') {
			redirect('maintenance_act/actDone/'.$id);
		} 
		else if ($note == 'N') {
			redirect('maintenance_act/actDoneWS/'.$id);
		} 
		else if ($note == 'P') {
			redirect('maintenance_act/actPending/'.$id);
		} 
		else {
			echo "Kamu gak pilih combo";
		}
	}

	public function actDone($id)
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

	public function done()
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
				'sound_yn'		 => "Y",
				'status'        => "2" //REPAIRED OR DONE
			);

			$this->db->where('wo_id', $this->input->post('wo_id'));
			$this->db->update('work_order_management', $data);
			$this->session->set_flashdata('status', 'Done');
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
			$this->session->set_flashdata('status', 'Done With Spare Part');
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
			$this->session->set_flashdata('status', 'Pending');
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
					'approver_name'    => $user_name,
					'approve_time' 	 => date("Y-m-d H:i:s"),
					'approver_message' => $this->input->post('approver_message'),
					'sound_yn'		 	 => "Y",
					'status'        	 => "3" //APPROVED OR CONFIRMED
				);

				$this->db->where('wo_id', $this->input->post('wo_id'));
				$this->db->update('work_order_management', $data);
				$this->session->set_flashdata('status', "Approved");
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
			redirect('maintenance_act/index');
			
		} else {
			redirect('Errorpage');
		}
		
	}

	


}

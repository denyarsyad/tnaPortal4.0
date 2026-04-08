<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Statistik extends CI_Controller
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
		//if ($this->session->userdata('level') == "Admin") {
		if (in_array($this->session->userdata('level'), ["Admin", "MGR", "SPVU", "SPVM"])) {
			//Menyusul template dashboard
			$data['title'] 		= "Statistik &amp; Laporan";
			$data['navbar']     = "navbar";
			$data['sidebar']	= "sidebar";
			$data['body'] 		= "statistik/statistik";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['stat_tahun'] = $this->model->Stat_Tahun()->result();

			$data['dd_tahun'] = $this->model->pilih_tahun();
			$data['id_tahun'] = "";

			$data['dd_bulan'] = $this->model->pilih_bulan('');
			$data['id_bulan'] = "";

			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function report()
	{
		if ($this->session->userdata('level') == "Admin") {
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');

			$report = $this->model->report($tgl1, $tgl2)->result();

			$spreadsheet = new Spreadsheet;

			$spreadsheet->getProperties()
				->setCreator("ITS")
				->setLastModifiedBy("ITS")
				->setTitle("Report of ticket")
				->setSubject("Report of ticket")
				->setDescription("Report document of ticket, generated using PHP classes.")
				->setCategory("Report document");

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'No. Ticket');
			$sheet->setCellValue('C1', 'Nama');
			$sheet->setCellValue('D1', 'Tanggal Submit');
			$sheet->setCellValue('E1', 'Tanggal Deadline');
			$sheet->setCellValue('F1', 'Last Update');
			$sheet->setCellValue('G1', 'Prioritas');
			$sheet->setCellValue('H1', 'Status');
			$sheet->setCellValue('I1', 'Lokasi');
			$sheet->setCellValue('J1', 'Kategori');
			$sheet->setCellValue('K1', 'Sub Kategori');
			$sheet->setCellValue('L1', 'Teknisi');
			$sheet->setCellValue('M1', 'Work Detail');
			$sheet->setCellValue('N1', 'Progress');
			$sheet->setCellValue('O1', 'Tanggal Proses');
			$sheet->setCellValue('P1', 'Solved');

			$nomor = 1;
			$baris = 2;
			$status = "";

			foreach ($report as $key) {
				if ($key->status == 0) {
					$status = "Ticket Rejected";
				} else if ($key->status == 1) {
					$status = "Ticket Submited";
				} else if ($key->status == 2) {
					$status = "Category Changed";
				} else if ($key->status == 3) {
					$status = "Technician selected";
				} else if ($key->status == 4) {
					$status = "On Process";
				} else if ($key->status == 5) {
					$status = "Pending";
				} else if ($key->status == 6) {
					$status = "Solve";
				} else if ($key->status == 7) {
					$status = "Late Finished";
				}
				$sheet->setCellValue('A' . $baris, $nomor);
				$sheet->setCellValue('B' . $baris, $key->id_ticket);
				$sheet->setCellValue('C' . $baris, $key->nama);
				$sheet->setCellValue('D' . $baris, $key->tanggal);
				$sheet->setCellValue('E' . $baris, $key->deadline);
				$sheet->setCellValue('F' . $baris, $key->last_update);
				$sheet->setCellValue('G' . $baris, $key->nama_prioritas);
				$sheet->setCellValue('H' . $baris, $status);
				$sheet->setCellValue('I' . $baris, $key->lokasi);
				$sheet->setCellValue('J' . $baris, $key->nama_kategori);
				$sheet->setCellValue('K' . $baris, $key->nama_sub_kategori);
				$sheet->setCellValue('L' . $baris, $key->nama_teknisi);
				$sheet->setCellValue('M' . $baris, $key->problem_detail);
				$sheet->setCellValue('N' . $baris, $key->progress . '%');
				$sheet->setCellValue('O' . $baris, $key->tanggal_proses);
				$sheet->setCellValue('P' . $baris, $key->tanggal_solved);

				$nomor++;
				$baris++;
			}

			$writer = new Xlsx($spreadsheet);

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Report.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function reportPdf()
	{
		if ($this->session->userdata('level') == "Admin") {
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');

			$data['tgl1'] = $tgl1;
			$data['tgl2'] = $tgl2;
			$data['report'] = $this->model->report($tgl1, $tgl2)->result();
			
			$html =$this->load->view('statistik/report_pdf', $data, true);
			$pdfFilePath = "report-" . time() . "-download.pdf";
			// create new PDF document
			$pdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8',
				'format' => 'A4-L',
				'orientation' => 'L'
			]);
			// Print text using writeHTMLCell()
			$pdf->WriteHTML($html);
			header('Content-Type: application/pdf');
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$pdf->Output($pdfFilePath, 'I');  // display on the browser
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	// public function downloadReport()
	// {
	// 	if ($this->input->method(TRUE) !== 'POST') {
	// 		show_404();
	// 	}

	// 	$jenis   = $this->input->post('jenis', TRUE);
	// 	$dtStart = $this->input->post('dtStart', TRUE);
	// 	$dtEnd   = $this->input->post('dtEnd', TRUE);

	// 	if (!$jenis || !$dtStart || !$dtEnd) {
	// 		show_error('Parameter tidak lengkap');
	// 	}

	// 	$tgl1 = date('Y-m-d', strtotime($dtStart));
	// 	$tgl2 = date('Y-m-d', strtotime($dtEnd));

	// 	if ($jenis === 'work_order') {

	// 		$data = $this->db->query("SELECT A.id_ticket,
	// 													A.status,
	// 													G.nama_prioritas,
	// 													A.tanggal,
	// 													A.deadline,
	// 													D.nama,
	// 													C.nama_kategori,
	// 													H.lokasi,
	// 													A.problem_summary,
	// 													A.last_update,
	// 													K.nama AS nama_teknisi
	// 											FROM ticket A
	// 											LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
	// 											LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
	// 											LEFT JOIN pegawai D ON D.nik = A.reported
	// 											LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept
	// 											LEFT JOIN departemen F ON F.id_dept = E.id_dept 
	// 											LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
	// 											LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
	// 											LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
	// 											LEFT JOIN pegawai K ON K.nik = A.teknisi
	// 											WHERE DATE(A.tanggal) BETWEEN ? AND ?
	// 											ORDER BY A.tanggal DESC", [$tgl1, $tgl2])->result_array();
				
	// 			//debuging
	// 			// echo '<pre>';
	// 			// print_r($data);
	// 			// exit;
	// 			$filename = 'Laporan_' . strtoupper($jenis) . '_' . date('YmdHis') . '.csv';
	// 			header("Content-Type: text/csv; charset=UTF-8");
	// 			header("Content-Disposition: attachment; filename=\"$filename\"");
	// 			header("Pragma: no-cache");
	// 			header("Expires: 0");
	// 			$output = fopen('php://output', 'w');

	// 			// UTF-8 BOM (Excel aman)
	// 			fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
	// 			fputcsv($output, [
	// 				'Ticket ID',
	// 				'Status',
	// 				'Prioritas',
	// 				'Tanggal',
	// 				'Deadline',
	// 				'Nama',
	// 				'Kategori',
	// 				'Lokasi',
	// 				'Subjek',
	// 				'Diperbarui',
	// 				'Teknisi'
	// 			], ';');

	// 			foreach ($data as $row) {
	// 				fputcsv($output, [
	// 						$row['id_ticket'],
	// 						$this->_status_text($row['status']),
	// 						$row['nama_prioritas'] ?: 'Not set yet',
	// 						$row['tanggal'] ? date('Y-m-d', strtotime($row['tanggal'])) : '',
	// 						$row['deadline'],
	// 						$row['nama'],
	// 						$row['nama_kategori'],
	// 						$row['lokasi'],
	// 						$row['problem_summary'],
	// 						$row['last_update'],
	// 						$row['nama_teknisi']
	// 				], ';');
	// 			}

	// 			fclose($output);
	// 			exit;
	// 	} else {
	// 		$data = $this->db->query("SELECT wom.wo_id,
	// 										DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') AS wo_date,
	// 										wom.machine_id,
	// 										wom.machine_name,
	// 										wom.req_message,
	// 										CASE wom.status
	// 											WHEN 0 THEN 'Request Submited'
	// 											WHEN 1 THEN 'Request Pending'
	// 											WHEN 2 THEN 'Request Done'
	// 											WHEN 3 THEN 'Request Approved'
	// 											WHEN 5 THEN 'Finished'
	// 											WHEN 6 THEN 'Checked'
	// 											WHEN 7 THEN 'Change Machine'
	// 											ELSE wom.status 
	// 										END AS status,
	// 										IFNULL(TIMEDIFF(wom.checker_time, wom.req_time), '00:00:00') AS respone_time,
	// 										IFNULL(TIMEDIFF(wom.mtc_time , wom.req_time), '00:00:00') AS down_time
	// 									FROM work_order_management wom
	// 									WHERE DATE(wom.wo_date) BETWEEN ? AND ?
	// 								ORDER BY DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s')  DESC", 
	// 								[$tgl1, $tgl2])->result_array();

	// 			$filename = 'Laporan_' . strtoupper($jenis) . '_' . date('YmdHis') . '.csv';
	// 			header("Content-Type: text/csv; charset=UTF-8");
	// 			header("Content-Disposition: attachment; filename=\"$filename\"");
	// 			header("Pragma: no-cache");
	// 			header("Expires: 0");
	// 			$output = fopen('php://output', 'w');

	// 			// UTF-8 BOM (Excel aman)
	// 			fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
	// 			fputcsv($output, [
	// 				'ID',
	// 				'WO DATE',
	// 				'MACHINE ID',
	// 				'MACHINE NAME',
	// 				'REQ MESSAGE',
	// 				'STATUS',
	// 				'RESPONE TIME',
	// 				'DOWN TIME'
	// 			], ';');

	// 			foreach ($data as $row) {
	// 				fputcsv($output, [
	// 						$row['wo_id'],
	// 						$row['wo_date'],
	// 						$row['machine_id'],
	// 						$row['machine_name'],
	// 						$row['req_message'],
	// 						// $this->_status_text_down($row['status']),
	// 						$row['status'],
	// 						$row['respone_time'],
	// 						$row['down_time']							
	// 				], ';');
	// 			}

	// 			fclose($output);
	// 			exit;
	// 	}
	// }

	public function downloadReport()
	{
		// 1. Bersihkan semua output buffer di awal
		if (ob_get_level()) ob_end_clean();

		if ($this->input->method(TRUE) !== 'POST') {
			redirect('statistik');
		}

		$jenis   = $this->input->post('jenis', TRUE);
		$dtStart = $this->input->post('dtStart', TRUE);
		$dtEnd   = $this->input->post('dtEnd', TRUE);

		$tgl1 = date('Y-m-d', strtotime($dtStart));
		$tgl2 = date('Y-m-d', strtotime($dtEnd));

		// 2. Query Data (Gunakan query yang sudah teruji)
		if ($jenis === 'work_order') {
			$data = $this->db->query("SELECT A.id_ticket, A.status, G.nama_prioritas, A.tanggal,
											A.deadline, D.nama, C.nama_kategori, H.lokasi,
											A.problem_summary, A.last_update, K.nama AS nama_teknisi
									FROM ticket A
									LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
									LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
									LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
									LEFT JOIN pegawai D ON D.nik = A.reported
									LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
									LEFT JOIN pegawai K ON K.nik = A.teknisi
									WHERE DATE(A.tanggal) BETWEEN ? AND ?
									ORDER BY A.tanggal DESC", [$tgl1, $tgl2])->result_array();
			$headers = ['Ticket ID', 'Status', 'Prioritas', 'Tanggal', 'Deadline', 'Nama', 'Kategori', 'Lokasi', 'Subjek', 'Diperbarui', 'Teknisi'];
		} else {
			$data = $this->db->query("SELECT wom.wo_id, DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') AS wo_date,
											wom.machine_id, wom.machine_name, wom.req_message,
											CASE wom.status
												WHEN 0 THEN 'Submited' WHEN 1 THEN 'Pending'
												WHEN 2 THEN 'Done' WHEN 5 THEN 'Finished'
												ELSE wom.status END AS status_label,
											IFNULL(TIMEDIFF(wom.checker_time, wom.req_time), '00:00:00') AS response,
											IFNULL(TIMEDIFF(wom.mtc_time , wom.req_time), '00:00:00') AS down
									FROM work_order_management wom
									WHERE DATE(wom.req_time) BETWEEN ? AND ?
									ORDER BY wom.req_time DESC", [$tgl1, $tgl2])->result_array();
			$headers = ['ID', 'WO DATE', 'MACHINE ID', 'MACHINE NAME', 'REQ MESSAGE', 'STATUS', 'RESPONSE', 'DOWN'];
		}

		if (empty($data)) {
			$this->session->set_flashdata('error', 'Data tidak ditemukan.');
			redirect('statistik');
		}

		// 3. Gunakan Metode XML Spreadsheet (Sangat Ringan & Anti-Crash)
		$filename = 'Laporan_' . strtoupper($jenis) . '_' . date('YmdHis') . '.xls';

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		// Membuat table HTML yang bisa dibaca Excel
		echo '<table border="1">';
		echo '<tr>';
		foreach ($headers as $h) {
			echo '<th style="background-color:#cccccc;">' . $h . '</th>';
		}
		echo '</tr>';

		foreach ($data as $row) {
			echo '<tr>';
			foreach ($row as $key => $val) {
				// Jika kolom status pada ticket, ubah jadi teks
				if ($jenis === 'work_order' && $key === 'status') {
					$val = $this->_status_text($val);
				}
				echo '<td>' . $val . '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		exit;
	}
	
	private function _status_text($status)
	{
		$map = [
			0 => 'Work Order Rejected',
			1 => 'Work Order Submitted',
			2 => 'Category Changed',
			3 => 'Assigned to Technician',
			4 => 'On Process',
			5 => 'Waiting Sparepart',
			6 => 'Solve',
			7 => 'Late Finished',
			8 => 'Approved Supervisor',
			9 => 'Assign by Manager',
			10 => 'Work Order Returned',
			11 => 'Approved Manager',
			12 => 'Closed',
			13 => 'Return to Technician'
		];
		return $map[$status] ?? 'Unknown';
	}

	private function _status_text_down($status)
	{
		$map = [
			0 => 'Request Submited',
			1 => 'Request Pending',
			2 => 'Request Done',
			3 => 'Request Approved'
		];
		return $map[$status] ?? 'Unknown';
	}

}

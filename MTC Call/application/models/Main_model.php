<?php


class Main_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('email');
    $config = array(
      'protocol'  => $this->settings->info['protocol'], // 'mail', 'sendmail', or 'smtp'
      'smtp_host' => $this->settings->info['smtp_host'], // 'mail.domain.com'
      'smtp_port' => $this->settings->info['smtp_port'], // '465', '587'
      'smtp_user' => $this->settings->info['smtp_user'], // 'your@email.com
      'smtp_pass' => $this->settings->info['smtp_pass'], // 'password'
      'mailtype'  => 'html', //plaintext 'text' mails or 'html'
      'starttls'  => true,
      'newline'   => "\r\n",
      'smtp_timeout' => '4', //in seconds
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE,
    );

    $this->email->initialize($config);
  }


  //Function Global Crud
  function all($table)
  {
    return $this->db->get($table);
  }

  function get($table, $id)
  {
    return $this->db->get_where($table, $id);
  }

  function insert($table, $query = [])
  {
    return $this->db->insert($table, $query);
  }

  function delete($table, $column, $id)
  {
    $this->db->where($column, $id);
    return $this->db->delete($table);
  }

  function update($table, $query, $column, $id)
  {
    $this->db->where($column, $id);
    return $this->db->update($table, $query);
  }

  function count_table($table)
  {
    return $this->db->count_all($table);
  }
  //

  //Bagian Admin

  //Bagian Menu Ticket
  //Method untuk mendapatkan semua ticket
  public function all_ticket()
  {
    //Query untuk mendapatkan semua ticket dengan diurutkan berdasarkan tanggal tiket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.last_update, A.id_prioritas, A.deadline, A.due_date, A.teknisi, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, G.waktu_respon, H.lokasi, I.nama_jabatan, K.nama AS nama_teknisi FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen F ON F.id_dept = E.id_dept 
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    LEFT JOIN pegawai K ON K.nik = A.teknisi
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang belum dilakukan approval
  public function approve_ticket()
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang belum dilakukan approval by LIMIT
  public function new_ticket($limit)
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC
    LIMIT $limit");
    return $query;
  }

  //Method yang digunakan untuk proses reject ticket dengan parameter id_ticket
  public function reject($id, $alasan = null)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 0, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'      => 0,
      'last_update' => date("Y-m-d  H:i:s"),
      'reject'      => $alasan,
      'reject_id'   => $id_user
    );

    //Melakukan insert data tracking ticket bahwa ticket di-reject oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Rejected",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  public function rejectMgr($id, $alasan = null)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 0, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'      => 0,
      'last_update' => date("Y-m-d  H:i:s"),
      'mgr_reject'      => $alasan,
      'mgr_reject_id'   => $id_user
    );

    //Melakukan insert data tracking ticket bahwa ticket di-reject oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Rejected",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //Method yang digunakan untuk proses approve ticket dengan parameter (id_ticket)
  public function approve($id)
  {
    $prioritas    = $this->input->post('id_prioritas');
    $sql        = $this->db->query("SELECT tanggal FROM ticket WHERE id_ticket = '$id'")->row();
    $sql2       = $this->db->query("SELECT nama_prioritas FROM prioritas WHERE id_prioritas = '$prioritas'")->row();
    //Data
    $prio       = $sql2->nama_prioritas;
    $date       = $sql->tanggal;
    $date2      = $this->input->post('waktu_respon');
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 2, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'id_prioritas' => $prioritas,
      'deadline'   => date('Y-m-d H:i:s', strtotime($date . ' + ' . $date2 . ' days')),
      'status'     => 3,
      'last_update' => date("Y-m-d  H:i:s"),
      'teknisi'    => $this->input->post('id_teknisi')
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Received",
      'deskripsi'  => "Priority of the Work Order is set to " . $prio . " and assigned to technician.",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method untuk menaruh data user teknisi sesuai dengan kategori yang dipilih pada dropdown
  function dropdown_teknisi()
  {
    //Query untuk mengambil data user yang memiliki level 'Technician'
    $query = $this->db->query("SELECT A.username, B.nama FROM user A LEFT JOIN pegawai B ON B.nik = A.username WHERE A.level = 'Technician'");

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data user teknisi ke dalam dropdown, value yang akan diambil adalah value id_user yang memiliki level 'Technician'
    foreach ($query->result() as $row) {
      $value[$row->username] = $row->nama;
    }
    return $value;
  }

  //Method yang digunakan untuk proses memilih teknisi untuk ticket dengan parameter (id_ticket)
  public function input_tugas($id)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 3 dan memasukkan teknisi yang telah diinput, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'teknisi'    => $this->input->post('id_teknisi'),
      'status'     => 3,
      'last_update' => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket sudah ditugaskan kepada teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order is assigned to technician",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Bagian Menu Office
  //Method untuk mengambil semua data departemen
  public function departemen()
  {
    //Query untuk mengambil semua data departemen dan diurutkan berdasarkan nama_dept
    $query = $this->db->query("SELECT * FROM departemen ORDER BY id_dept, nama_dept");
    return $query;
  }

  //Method untuk mengambil data departemen yang akan diedit dengan parameter id_dept
  public function getdepartemen($id)
  {
    //Query untuk mengambil data departemen berdasarkan id_dept untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM departemen WHERE id_dept = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data sub departemen
  public function subdepartemen()
  {
    //Query untuk mengambil semua data sub departemen dan diurutkan berdasarkan nama_bagian_dept
    $query = $this->db->query("SELECT * FROM departemen_bagian A LEFT JOIN departemen B ON B.id_dept = A.id_dept ORDER BY nama_bagian_dept");
    return $query;
  }

  //Method untuk mengambil semua data jabatan
  public function jabatan()
  {
    //Query untuk mengambil semua data jabatan dan diurutkan berdasarkan nama_jabatan
    $query = $this->db->query("SELECT * FROM jabatan ORDER BY nama_jabatan");
    return $query;
  }

  //Method untuk mengambil data jabatan yang akan diedit dengan parameter id_jabatan
  public function getjabatan($id)
  {
    //Query untuk mengambil data jabtan berdasarkan id_jabatan untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data pegawai
  public function pegawai()
  {
    //Query untuk mengambil semua data pegawai dan diurutkan berdasarkan nik
    $query = $this->db->query("SELECT A.nama, A.email, A.telp, A.nik, B.nama_jabatan, C.nama_bagian_dept, D.nama_dept FROM pegawai A 
    LEFT JOIN jabatan B ON B.id_jabatan = A.id_jabatan
    LEFT JOIN departemen_bagian C ON C.id_bagian_dept = A.id_bagian_dept
    LEFT JOIN departemen D ON D.id_dept = C.id_dept ORDER BY A.nik");
    return $query;
  }

  //Method untuk mengambil semua data lokasi
  public function lokasi()
  {
    //Query untuk mengambil semua data lokasi dengan diurutkan berdasarkan lokasi
    $query = $this->db->query("SELECT * FROM lokasi ORDER BY lokasi");
    return $query;
  }

  //Method untuk mengambil data lokasi yang akan diedit dengan parameter id_lokasi
  public function getlokasi($id)
  {
    //Query untuk mengambil data lokasi berdasarkan id_lokasi untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM lokasi WHERE id_lokasi = '$id'");
    return $query;
  }

  //Method untuk menaruh data departemen pada dropdown
  public function dropdown_departemen()
  {
    //Query untuk mengambil data departemen dan diurutkan berdasarkan nama departemen
    $sql = "SELECT * FROM departemen ORDER BY nama_dept";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data departemen ke dalam dropdown, value yang akan diambil adalah value id_dept
    foreach ($query->result() as $row) {
      $value[$row->id_dept] = $row->nama_dept;
    }
    return $value;
  }

  //Method untuk menaruh data jabatan pada dropdown
  public function dropdown_jabatan()
  {
    //Query untuk mengambil data jabatan dan diurutkan berdasarkan nama jabatan
    $sql = "SELECT * FROM jabatan ORDER BY nama_jabatan";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data jabatan ke dalam dropdown, value yang akan diambil adalah value id_jabatan
    foreach ($query->result() as $row) {
      $value[$row->id_jabatan] = $row->nama_jabatan;
    }
    return $value;
  }

  //Method untuk menaruh data sub departemen sesuai dengan departemen yang dipilih pada dropdown
  public function dropdown_bagian_departemen($id_departemen)
  {
    //Query untuk mengambil data sub departemen dan diurutkan berdasarkan nama sub departemen
    $sql = "SELECT * FROM departemen_bagian where id_dept ='$id_departemen' ORDER BY nama_bagian_dept";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data sub departemen ke dalam dropdown, value yang akan diambil adalah value id_bagian_dept
    foreach ($query->result() as $row) {
      $value[$row->id_bagian_dept] = $row->nama_bagian_dept;
    }
    return $value;
  }

  //Bagian Menu Configuration
  //Method untuk mengambil semua data user 
  public function user()
  {
    //Query untuk mengambil semua data user dan diurutkan berdasarkan level user
    $query = $this->db->query("SELECT A.username, A.level, A.id_user, A.password, B.nik, B.nama, B.email, C.nama_bagian_dept, C.id_dept, D.nama_dept FROM user A 
    LEFT JOIN pegawai B ON B.nik = A.username 
    LEFT JOIN departemen_bagian C ON C.id_bagian_dept = B.id_bagian_dept 
    LEFT JOIN departemen D ON D.id_dept = C.id_dept ORDER BY A.level");
    return $query;
  }

  //Method yang digunakan untuk membuat kode user secara otomatis
  public function getkodeuser()
  {
    //Query untuk mengembalikan value terbesar yang ada di kolom id_user
    $query = $this->db->query("SELECT max(id_user) AS max_code FROM user");

    //Menampung fungsi yang akan mengembalikan hasil 1 baris dari query ke dalam variabel $row
    $row = $query->row_array();

    //Menampung hasil kode user terbesar dari query
    $max_id = $row['max_code'];

    //Membuat format kode user dengan dengan memulai kode dari posisi 1 dan panjang kode 4
    $max_fix = (int) substr($max_id, 1, 4);

    //Hasil dari kode terbesar yang sudah didapatkan ditambah dengan 1, hasil dari penjumlahan ini akan digunakan sebagai kode user terbaru
    $max_id_user = $max_fix + 1;

    //Membuat id_user dengan format U + kode user terbaru
    $id_user = "U" . sprintf("%04s", $max_id_user);
    return $id_user;
  }

  //Method untuk menaruh data pegawai pada dropdown
  public function dropdown_pegawai()
  {
    //Query untuk mengambil data pegawai dan diurutkan berdasarkan nama
    $sql = "SELECT A.nama, A.nik FROM pegawai A 
        LEFT JOIN departemen_bagian B ON B.id_bagian_dept = A.id_bagian_dept
        LEFT JOIN departemen C ON C.id_dept = B.id_dept 
        ORDER BY nama";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data pegawai ke dalam dropdown, value yang akan diambil adalah value nik
    foreach ($query->result() as $row) {
      $value[$row->nik] = $row->nama;
    }
    return $value;
  }

  //Method untuk membuat level userGETka
  public function dropdown_level()
  {
    //Menyusun value pada dropdown
    $value[''] = '--Pilih--';
    $value['Admin'] = 'Admin';
    $value['Technician'] = 'Technician';
    $value['User'] = 'User';
    $value['SPV'] = 'Supervisor Dept';
    $value['MGR'] = 'Manager Maintenance';
    $value['SPVU'] = 'Supervisor Maintenance & Utility';
    $value['SPVM'] = 'Dies,Workshop Officer';
    $value['MGRD'] = 'Manager Dept';

    return $value;
  }

  //Method untuk mengambil semua data prioritas 
  public function prioritas()
  {
    //Query untuk mengambil semua data prioritas dengan diurutkan berdasarkan waktu respon
    $query = $this->db->query("SELECT * FROM prioritas ORDER BY waktu_respon");
    return $query;
  }

  //Method untuk mengambil data prioritas yang akan diedit dengan parameter id_prioritas
  public function getprioritas($id)
  {
    //Query untuk mengambil data prioritas berdasarkan id_prioritas untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM prioritas WHERE id_prioritas = '$id'");
    return $query;
  }

  //Method untuk menaruh data prioritas pada dropdown
  public function dropdown_prioritas()
  {
    //Query untuk mengambil data prioritas dan diurutkan berdasarkan nama prioritas
    $sql = "SELECT * FROM prioritas ORDER BY waktu_respon";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data prioritas ke dalam dropdown, value yang akan diambil adalah value id_prioritas
    foreach ($query->result() as $row) {
      $value[$row->id_prioritas] = $row->nama_prioritas . "  -  (Process Target " . $row->waktu_respon . " " . "Day)";
    }
    return $value;
  }

  //Method untuk mengambil semua data kategori
  public function kategori()
  {
    //Query untuk mengambil semua data kategori dengan diurutkan berdasarkan nama kategori
    $query = $this->db->query("SELECT * FROM kategori ORDER BY id_kategori");
    return $query;
  }

  //Method untuk mengambil data kategori yang akan diedit dengan parameter id_kategori
  public function getkategori($id)
  {
    //Query untuk mengambil data kategori berdasarkan id_kategori untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM kategori WHERE id_kategori = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data sub kategori
  public function subkategori()
  {
    //Query untuk mengambil semua data sub kategori yang di-join dengan tabel kategori berdasarkan id_kategori dan diurutkan berdasarkan nama_kategori
    $query = $this->db->query("SELECT * FROM kategori_sub A LEFT JOIN kategori B ON B.id_kategori = A.id_kategori ORDER BY B.id_kategori, A.nama_sub_kategori");
    return $query;
  }

  //Method untuk mengambil semua data informasi
  public function informasi()
  {
    //Query untuk mengambil semua data informasi yang diuurutkan berdasarkan tanggal
    $query = $this->db->query("SELECT A.tanggal, A.subject, A.pesan, A.id_informasi, C.nama FROM informasi A 
    LEFT JOIN pegawai C ON C.nik =  A.id_user
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data informasi yang akan diedit dengan parameter id_informasi
  public function getinformasi($id)
  {
    //Query untuk mengambil data informasi berdasarkan id_informasi untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM informasi WHERE id_informasi = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data settings
  public function setting()
  {
    //Query untuk mengambil semua data settings dengan diurutkan berdasarkan settings
    $query = $this->db->query("SELECT * FROM settings ORDER BY id");
    return $query;
  }

  //Method untuk mengambil data setting yang akan diedit dengan parameter id
  public function getsetting($id)
  {
    //Query untuk mengambil data setting berdasarkan id untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM settings WHERE id = '$id'");
    return $query;
  }
  //Selesai Bagian Admin


  //Bagian Teknisi

  //Method untuk mendapatkan semua ticket yang ditugaskan kepada teknisi dan belum dilakukan approval oleh teknisi
  public function approve_tugas($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 3 (Technician selected) atau 5 (Pending waiting sparepart) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    WHERE F.nik = '$id' AND A.status IN (3,5) ORDER BY A.deadline ASC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang ditugaskan kepada teknisi dan sudah dilakukan approval oleh teknisi
  public function daftar_tugas($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 4 (On Process) atau 6 (Solve) dengan diurutkan berdasarkan tanggal tiket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.tanggal_solved, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept, K.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    LEFT JOIN jabatan K ON K.id_jabatan = D.nik
    WHERE F.nik = '$id' AND A.status IN (4,6,7,13) ORDER BY G.waktu_respon ASC");
    return $query;
  }

  //Method yang digunakan untuk melakukan approval ticket oleh teknisi
  public function approve_tiket($id)
  {
    //Mengambil session teknisi
    $id_user = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 4 dan memasukkan tanggal tiket mulai diproses, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'         => 4,
      'tanggal_proses' => date("Y-m-d  H:i:s"),
      'last_update'    => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket sedang dikerjakan oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "On Process",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method yang digunakan untuk melakukan pending ticket oleh teknisi
  public function pending_tugas($id)
  {
    //Mengambil session teknisi
    $id_user = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 5, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 5,
      'last_update' => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket di-pending oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Pending waiting sparepart",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method yang digunakan untuk melakukan update progress ticket oleh teknisi
  public function update_progress($id)
  {
    //Mengambil session teknisi
    $id_user  = $this->session->userdata('id_user');

    //Mengambil data progress dan deskripsi untuk update system tracking ticket
    $progress = $this->input->post('progress');
    $date     = date("Y-m-d  H:i:s");
    $sql      = $this->db->query("SELECT deadline FROM ticket WHERE id_ticket='$id'")->row();

    //Konfigurasi Upload Gambar
    $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
    $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
    $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
    $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
    $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

    //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
    $this->load->library('upload', $config);

    //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
    if (!$this->upload->do_upload('fileupdate')) {
      $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
      redirect('ticket_teknisi/detail_update/' . $id);
    } else {
      //Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
      //Menampung file gambar ke variable 'gambar'
      $gambar   = $this->upload->data();

      //Signature pad
      $folderPath = './files/teknisi/signature/';
      $image_parts = explode(";base64,", $this->input->post('signed'));
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $fileName = uniqid() . '.' . $image_type;
      $file = $folderPath . $fileName;
      file_put_contents($file, $image_base64);

      //prioritas jika progress yang sudah selesai, maka status ticket pada system tracking ticket menjadi ticket closed dengan keterangan progress ticketnya juga
      if ($progress == 100) {
        if (date("Y-m-d  H:i:s") > $sql->deadline) {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 7,
            'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress,
            'memo_teknisi'   => $this->input->post('desk')
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Work Order Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        } else {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 6,
            'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress,
            'memo_teknisi'   => $this->input->post('desk')
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Work Order Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        }
      } else {
        //Bagian ini jika prioritasnya progress ticket belum selesai dikerjakan, maka data yang diupdate hanya status dan progress
        //Melakukan update data ticket dengan mengubah status ticket menjadi 4, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
        $data = array(
          'status'       => 4,
          'last_update'  => date("Y-m-d  H:i:s"),
          'progress'     => $progress,
          'memo_teknisi'   => $this->input->post('desk')
        );

        //Melakukan insert data tracking ticket progress oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
        $datatracking = array(
          'id_ticket'  => $id,
          'tanggal'    => date("Y-m-d  H:i:s"),
          'status'     => "Progress: " . $progress . " %",
          'deskripsi'  => ucfirst($this->input->post('desk')),
          'id_user'    => $id_user,
          'filefoto'   => $gambar['file_name'],
          'signature'  => $fileName
        );
      }
      //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
      $this->db->where('id_ticket', $id);
      $this->db->update('ticket', $data);

      //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
      $this->db->insert('tracking', $datatracking);
    }
  }

  public function changekategori($id)
  {
    $kat      = $this->input->post('id_kategori');
    $subkat   = $this->input->post('id_sub_kategori');
    $row      = $this->db->query("SELECT * FROM kategori WHERE id_kategori = '$kat'")->row();
    $key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();
    $sql      = $this->db->query("SELECT id_sub_kategori FROM ticket WHERE id_ticket = '$id'")->row();
    $id_user  = $this->session->userdata('id_user');

    if ($subkat == $sql->id_sub_kategori) {
      $this->session->set_flashdata('status1', 'Sub Kategori tidak diubah atau masih sama!');
      redirect('ticket_teknisi/change/' . $id);
    } else {
      //Konfigurasi Upload Gambar
      $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
      $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
      $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
      $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
      $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

      //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
      $this->load->library('upload', $config);
      //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
      if (!$this->upload->do_upload('filediagnosa')) {
        $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
        redirect('ticket_teknisi/change/' . $id);
      } else {
        $gambar = $this->upload->data();
        $data = array(
          'id_sub_kategori'   => $subkat,
          'last_update'       => date("Y-m-d  H:i:s"),
          'status'            => 2,
          'teknisi'           => NULL,
          'problem_detail'    => ucfirst($this->input->post('diagnos'))
        );

        $datatracking = array(
          'id_ticket'  => $id,
          'tanggal'    => date("Y-m-d  H:i:s"),
          'status'     => "Kategori diubah menjadi " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
          'deskripsi'  => ucfirst($this->input->post('diagnos')),
          'id_user'    => $id_user,
          'filefoto'   => $gambar['file_name']
        );
        $this->db->where('id_ticket', $id);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $datatracking);
      }
    }
  }
  //Selesai Bagian Teknisi

  //
  //Bagian User

  //Method yang digunakan untuk membuat kode ticket secara otomatis
  public function getkodeticket()
  {
    //Query untuk mengembalikan value terbesar yang ada di kolom id_ticket
    $query = $this->db->query("SELECT max(id_ticket) AS max_code FROM ticket");

    //Menampung fungsi yang akan mengembalikan hasil 1 baris dari query ke dalam variabel $row
    $row = $query->row_array();

    //Menampung hasil kode ticket terbesar dari query
    $max_id = $row['max_code'];
    //Mengambil kode ticket pada database posisi 9 dan panjang kode 4
    $max_fix = (int) substr($max_id, 9, 4);

    //Hasil dari kode terbesar yang sudah didapatkan ditambah dengan 1, hasil dari penjumlahan ini akan digunakan sebagai kode ticket terbaru
    $max_ticket = $max_fix + 1;

    //Mengambil tanggal sekarang
    $tanggal = date("d");
    //Mengambil bulan sekarang
    $bulan = date("m");
    //Mengambil tahun sekarang
    $tahun = date("Y");

    //Membuat id_ticket dengan format T + tahun + bulan + tanggal + kode user terbaru (%04s merupakan fungsi untuk menentukan lebar minimum yang dimiliki nilai variable serta mengubah int menjadi string, %04s menandakan lebar minimum dari tiket yaitu 4 dengan padding berupa angka 0)
    $ticket = "T" . $tahun . $bulan . $tanggal . sprintf("%04s", $max_ticket);
    return $ticket;
  }

  //Membuat id_ticket dengan format Random
  public function getkodeticketnew()
  {
    $this->load->helper('string');
    $tanggal = date('Y'); // Format tanggal: YYYY
    $random = strtoupper(random_string('alnum', 3)); // 3 digit alfanumerik acak
    $ticket = 'WO' . $tanggal . '' . $random;
    return $ticket;
  }

  //Method untuk mengambil semua ticket yang dimiliki user dengan parameter id_user
  public function myticket($id)
  {
    //Query untuk mendapatkan semua ticket yang dimiliki user dengan diurutkan berdasarkan tanggal
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.last_update, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, A.teknisi, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept, K.nama AS nama_teknisi FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.id_user = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    LEFT JOIN pegawai K ON K.nik = A.teknisi
    WHERE A.reported = '$id' ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data detail dari setiap ticket dengan parameter id_ticket
  public function detail_ticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, A.id_prioritas, A.id_sub_kategori, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas, J.warna, J.waktu_respon, K.nama_jabatan, 
    CASE WHEN A.assign_to = 'SPVU' THEN 'Supervisor Utility' 
	  WHEN A.assign_to = 'SPVM' THEN 'Supervisor Maintenance'
	  ELSE A.assign_to
    END AS assign_to,
    (SELECT MAX(z.email) FROM pegawai z WHERE z.id_jabatan = 5 AND z.id_bagian_dept = D.id_bagian_dept) AS mail,
    z.deskripsi AS returned_reason,
    z.nama AS manager_name,
    z.tanggal AS tanggal_reason,
    A.id_lokasi,
    A.user_mail,
    A.mgr_id,
    A.mgr_date,
    A.mgr_noted,
    A.mgrd_id,
    A.mgrd_date,
    A.mgrd_noted,
    A.mgr_reject,
    A.mgr_reject_id,
    A.mgrd_reject,
    A.mgrd_reject_id,
    A.last_update,
    A.memo_teknisi,
    A.answerfoto,
    A.memo_teknisi,
    A.notes
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = A.teknisi
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    LEFT JOIN jabatan K ON K.id_jabatan = D.id_jabatan
    LEFT JOIN (SELECT a.id_ticket, a.deskripsi, b.nama, a.tanggal FROM tracking a LEFT JOIN pegawai b ON a.id_user = b.nik  WHERE a.tanggal = (SELECT max(b.tanggal) FROM tracking b WHERE b.id_ticket = a.id_ticket) AND a.status = 'Ticket Returned') z
    ON A.id_ticket = z.id_ticket
    WHERE A.id_ticket = '$id'");
    return $query;
  }

  //Method untuk mengambil data tracking dari setiap ticket dengan parameter id_ticket
  public function tracking_ticket($id)
  {
    //Query untuk mendapatkan data tracking dari setiap ticket
    $query = $this->db->query("SELECT A.tanggal, A.status, A.deskripsi, A.filefoto, A.signature, B.nama, A.answerfoto FROM tracking A 
    LEFT JOIN pegawai B ON B.nik = A.id_user
    WHERE A.id_ticket ='$id'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data tracking dari setiap ticket_message dengan parameter id_ticket
  public function message_ticket($id)
  {
    //Query untuk mendapatkan data tracking dari setiap ticket
    $query = $this->db->query("SELECT A.tanggal, A.status, A.message, A.filefoto, B.nama, C.level FROM ticket_message A 
    LEFT JOIN pegawai B ON B.nik = A.id_user
    LEFT JOIN user C ON C.username = A.id_user
    WHERE A.id_ticket ='$id'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil profile dari setiap user
  public function profile($id)
  {
    //Query untuk mengambil data profile dari setiap user
    $query = $this->db->query("SELECT A.nik, A.nama, A.email, A.telp, A.id_jabatan, A.id_bagian_dept, B.level, C.nama_jabatan, D.id_dept, D.nama_bagian_dept, E.nama_dept FROM pegawai A 
    LEFT JOIN user B ON B.username = A.nik 
    LEFT JOIN jabatan C ON C.id_jabatan = A.id_jabatan 
    LEFT JOIN departemen_bagian D ON D.id_bagian_dept = A.id_bagian_dept 
    LEFT JOIN departemen E ON E.id_dept = D.id_dept WHERE A.nik ='$id'");
    return $query;
  }

  //Method untuk menaruh data kategori pada dropdown
  public function dropdown_kategori()
  {
    //Query untuk mengambil data kategori dan diurutkan berdasarkan nama kategori
    $sql = "SELECT * FROM kategori WHERE nama_menu = 'WORK ORDER' ORDER BY nama_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data kategori ke dalam dropdown, value yang akan diambil adalah value id_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_kategori] = $row->nama_kategori;
    }
    return $value;
  }

  public function dropdown_kategori_incident()
  {
    //Query untuk mengambil data kategori dan diurutkan berdasarkan nama kategori
    $sql = "SELECT * FROM kategori WHERE nama_menu = 'INCIDENT' ORDER BY nama_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data kategori ke dalam dropdown, value yang akan diambil adalah value id_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_kategori] = $row->nama_kategori;
    }
    return $value;
  }

  public function dropdown_kategori_input_sub()
  {
    //Query untuk mengambil data kategori dan diurutkan berdasarkan nama kategori
    $sql = "SELECT * FROM kategori ORDER BY id_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data kategori ke dalam dropdown, value yang akan diambil adalah value id_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_kategori] = $row->nama_kategori;
    }
    return $value;
  }

  //Method untuk menaruh data lokasi pada dropdown
  public function dropdown_lokasi()
  {
    //Query untuk mengambil data lokasi dan diurutkan berdasarkan nama lokasi
    $sql = "SELECT * FROM lokasi ORDER BY lokasi";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data lokasi ke dalam dropdown, value yang akan diambil adalah value id_lokasi
    foreach ($query->result() as $row) {
      $value[$row->id_lokasi] = $row->lokasi;
    }
    return $value;
  }

  //Method untuk menaruh data sub ketegori sesuai dengan kategori yang dipilih pada dropdown
  public function dropdown_sub_kategori($id_kategori)
  {
    //Query untuk mengambil data sub kategori dan diurutkan berdasarkan nama sub kategori
    $sql = "SELECT * FROM kategori_sub where id_kategori ='$id_kategori' ORDER BY nama_sub_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data sub kategori ke dalam dropdown, value yang akan diambil adalah value id_sub_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_sub_kategori] = $row->nama_sub_kategori;
    }
    return $value;
  }
  //Selesai Bagian User


  //Bagian Dashboard

  //Method untuk mengambil data semua ticket
  public function getTicket()
  {
    //Query untuk mengambil data semua ticket
    return $this->db->get('ticket');
  }

  //Method untuk mengambil data teknisi dan jumlah tugasnya
  public function getTek()
  {
    $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $query = $this->db->query("SELECT A.id_user, B.nama, SUM(C.status NOT IN (1,2,6,7)) as total FROM user A 
    LEFT JOIN pegawai B ON B.nik = A.username 
    LEFT JOIN ticket C ON C.teknisi = B.nik 
    WHERE A.level = 'technician' GROUP BY B.nama ");
    return $query;
  }

  public function allassignment($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    WHERE A.teknisi = '$id' AND A.status IN (3,4,5) ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data semua ticket berdasarkan statusnya
  public function getStatusTicket($status)
  {
    //Query untuk mengambil data semua ticket berdasarkan status
    $this->db->where('status', $status);
    return $this->db->get('ticket');
  }

  //Method untuk mengambil data semua user dengan level 'Technician'
  public function getTeknisi()
  {
    //Query untuk mengambil data semua user dengan level 'Technician'
    $this->db->where('level', 'Technician');
    return $this->db->get('user');
  }

  //Method untuk mengambil data semua user dengan level 'User'
  public function getUser()
  {
    //Query untuk mengambil data semua user dengan level 'User'
    $this->db->where('level', 'User');
    return $this->db->get('user');
  }

  public function Bar_Ticket()
  {
    $query = $this->db->query("SELECT B.nama_sub_kategori, COUNT(*) AS total FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    WHERE YEAR(A.tanggal)=YEAR(NOW()) AND A.status NOT IN (0)
    GROUP BY A.id_sub_kategori");
    return $query;
  }

  public function pie_prioritas()
  {
    $query = $this->db->query("SELECT B.nama_prioritas, B.warna, A.id_prioritas, COUNT(*) AS jumprioritas FROM ticket A 
    LEFT JOIN prioritas B ON B.id_prioritas = A.id_prioritas 
    WHERE YEAR(A.tanggal)=YEAR(NOW()) AND A.status NOT IN (0)
    GROUP BY A.id_prioritas ORDER BY A.id_prioritas ASC");
    return $query;
  }

  public function line_bulan()
  {
    $query = $this->db->query("SELECT MONTHNAME(tanggal) AS bulan, COUNT(*) AS jumbulan FROM ticket 
    WHERE YEAR(tanggal)=YEAR(NOW())
    GROUP BY MONTHNAME(tanggal) 
    ORDER BY MONTH(tanggal) ASC");

    return $query;
  }

  public function pie_status()
  {
    $query = $this->db->query("SELECT status, COUNT(*) AS jumstat FROM ticket 
    WHERE YEAR(tanggal)=YEAR(NOW()) 
    GROUP BY status ORDER BY status ASC");
    return $query;
  }
  //Selesai Bagian Dashboard


  //Bagian Statistik
  public function Stat_Tahun()
  {
    $query = $this->db->query("SELECT YEAR(tanggal) AS tahun, COUNT(*) AS jumtahun FROM ticket 
    GROUP BY YEAR(tanggal)");
    return $query;
  }

  public function pilih_tahun()
  {
    $query = $this->db->query("SELECT YEAR(tanggal) AS tahun FROM ticket ORDER BY YEAR(tanggal) ASC ");

    $value[''] = '-- Pilih Tahun --';
    foreach ($query->result() as $row) {
      $value[$row->tahun] = $row->tahun;
    }
    return $value;
  }

  public function pilih_bulan($id_tahun)
  {
    $query = $this->db->query("SELECT DATE_FORMAT(tanggal, '%Y/ %M') AS bulan FROM ticket WHERE DATE_FORMAT(tanggal, '%Y') = '$id_tahun'  ORDER BY MONTH(tanggal) ASC ");

    $value[''] = '-- Pilih Bulan --';
    foreach ($query->result() as $row) {
      $value[$row->bulan] = $row->bulan;
    }
    return $value;
  }

  public function report($tgl1, $tgl2)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.last_update, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, A.id_prioritas, A.deadline, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE DATE(A.tanggal) BETWEEN '$tgl1' AND '$tgl2'");
    return $query;
  }

  //Bagian Notifikasi Email
  public function emailbuatticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        WHERE p.id_jabatan = 5
        AND d.id_dept = I.id_dept) AS mail_to
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Submited</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been submited by " . $query->nama . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Submited</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Submited');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      // show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', 'Dikirim');
      //Dialihkan ke halaman my ticket
      redirect('ticket_user');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }

  public function emailapprove($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Work Order (" . $query->id_ticket . ") Has Been Received</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>Your Work Order will be processed according to predetermined priorities. You can track your Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Received</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Work Order (' . $query->id_ticket . ') Has Been Received');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
      $this->session->set_flashdata('status', 'Ditugaskan');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailreject($id)
  {
    $message  = $this->input->post('message');
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Sorry, Your Work Order (" . $query->id_ticket . ") Has Been Rejected</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>" . $message . "</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Rejected</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Work Order (' . $query->id_ticket . ') Has Been Rejected');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-reject
      $this->session->set_flashdata('status', 'Ditolak');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailtugas($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>You Are Assigned To The Work Order (" . $query->id_ticket . ")</h1>";
    $isiEmail .= "<div>Dear " . $query->nama_teknisi . "</div>";
    $isiEmail .= "<div>Please check your <code>Work Order Assigned</code> menu on <b>Work Order Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Assigned to you</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $this->input->post('email');
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Are Assigned To The Work Order (' . $query->id_ticket . ')');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
      $this->session->set_flashdata('status', 'Ditugaskan');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emaildiproses($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Work Order (" . $query->id_ticket . ") being processed</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>You can track your Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>processed by ' . $query->nama_teknisi . '</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Work Order (' . $query->id_ticket . ') being processed by technician');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-approve
      $this->session->set_flashdata('status', 'Process');
      //Kembali ke halaman List approval ticket (Ticket Assigned)
      redirect('ticket_teknisi/index_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emaildipending($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Work Order (" . $query->id_ticket . ") is Pending waiting sparepart </h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>Your Work Order will be handled soon</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Pending waiting sparepart by ' . $query->nama_teknisi . '</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Work Order (' . $query->id_ticket . ') is Pending waiting sparepart by technician');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-pending
      $this->session->set_flashdata('status', 'Hold');
      //Kembali ke halaman List approval ticket (Ticket Assigned)
      redirect('ticket_teknisi/index_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailselesai($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();
    if ($query->progress > 0 || $query->progress < 100) {
      $isiEmail  = "<h1>Your Work Order (" . $query->id_ticket . ") is On Process</h1>";
      $isiEmail  .= "<div>Dear " . $query->nama . "</div>";
      $isiEmail .= "<div>Your Work Order is On Process by Technician. You can track your Work Order in <b>TNA PORTAL Web Application</b></div>";
      $isiEmail .= "<div>Thank You.</div>";
      $isiEmail .= '<div>
                         <table>
                           <tbody>
                             <tr>
                               <td>ID Work Order</td>
                               <td>:</td>
                               <td>' . $query->id_ticket . '</td>
                             </tr>
                             <tr>
                               <td>Nama</td>
                               <td>:</td>
                               <td>' . $query->nama . '</td>
                             </tr>
                             <tr>
                               <td>Email</td>
                               <td>:</td>
                               <td>' . $query->email . '</td>
                             </tr>
                             <tr>
                               <td>Category</td>
                               <td>:</td>
                               <td>' . $query->nama_kategori . '</td>
                             </tr>
                             <tr>
                               <td>Sub Category</td>
                               <td>:</td>
                               <td>' . $query->nama_sub_kategori . '</td>
                             </tr>
                             <tr>
                               <td>Priority</td>
                               <td>:</td>
                               <td>' . $query->nama_prioritas . '</td>
                             </tr>
                             <tr>
                               <td>Location</td>
                               <td>:</td>
                               <td>' . $query->lokasi . '</td>
                             </tr>
                             <tr>
                               <td>Status</td>
                               <td>:</td>
                               <td>On Process</td>
                             </tr>
							 <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                             <tr>
                               <td>Problem</td>
                               <td>:</td>
                               <td>' . $query->problem_summary . '</td>
                             </tr>
                             <tr>
                               <td>Detail</td>
                               <td>:</td>
                               <td>' . nl2br($query->problem_detail) . '</td>
                             </tr>
                          </tbody>
                         </table>
                       </div>';
      $from = $this->settings->info['smtp_user'];
      $name = $this->settings->info['perusahaan'];
      $to = $query->email;
      $this->email->set_newline("\r\n");
      $this->email->from($from, $name);
      $this->email->to($to);
      $this->email->subject('Your Work Order (' . $query->id_ticket . ') is On Process');
      $this->email->attach('uploads/' . $query->filefoto);
      $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
      $this->email->message($isiEmail);
      if (!$this->email->send()) {
        //Set pemberitahuan bahwa ticket berhasil di-update
        $this->session->set_flashdata('status', 'Updated');
        //Kembali ke halaman List ticket (Assignment Ticket)
        redirect('ticket_teknisi/index_tugas');
      } else {
        echo 'Success to send email';
      }
    } else if ($query->progress == 100) {
      $isiEmail  = "<h1>Your Work Order (" . $query->id_ticket . ") is Done</h1>";
      $isiEmail  .= "<div>Dear " . $query->nama . "</div>";
      $isiEmail .= "<div>Your Work Order is done of progress. The Work Order will be closed.</div>";
      $isiEmail .= "<div>Thank You.</div>";
      $isiEmail .= '<div>
                            <table>
                              <tbody>
                                <tr>
                                  <td>ID Work Order</td>
                                  <td>:</td>
                                  <td>' . $query->id_ticket . '</td>
                                </tr>
                                <tr>
                                  <td>Nama</td>
                                  <td>:</td>
                                  <td>' . $query->nama . '</td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>:</td>
                                  <td>' . $query->email . '</td>
                                </tr>
                                <tr>
                                  <td>Category</td>
                                  <td>:</td>
                                  <td>' . $query->nama_kategori . '</td>
                                </tr>
                                <tr>
                                  <td>Sub Category</td>
                                  <td>:</td>
                                  <td>' . $query->nama_sub_kategori . '</td>
                                </tr>
                                <tr>
                                  <td>Priority</td>
                                  <td>:</td>
                                  <td>' . $query->nama_prioritas . '</td>
                                </tr>
                                <tr>
                                  <td>Location</td>
                                  <td>:</td>
                                  <td>' . $query->lokasi . '</td>
                                </tr>
                                <tr>
                                  <td>Status</td>
                                  <td>:</td>
                                  <td>Work Order Closed</td>
                                </tr>
								<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                                <tr>
                                  <td>Problem</td>
                                  <td>:</td>
                                  <td>' . $query->problem_summary . '</td>
                                </tr>
                                <tr>
                                  <td>Detail</td>
                                  <td>:</td>
                                  <td>' . nl2br($query->problem_detail) . '</td>
                                </tr>
                             </tbody>
                            </table>
                          </div>';

      $from = $this->settings->info['smtp_user'];
      $name = $this->settings->info['perusahaan'];
      $to = $query->email;
      $this->email->set_newline("\r\n");
      $this->email->from($from, $name);
      $this->email->to($to);
      $this->email->subject('Your Work Order (' . $query->id_ticket . ') is Done');
      $this->email->attach('uploads/' . $query->filefoto);
      $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
      $this->email->message($isiEmail);
      if (!$this->email->send()) {
        //Set pemberitahuan bahwa ticket berhasil di-update
        $this->session->set_flashdata('status', 'Updated');
        //Kembali ke halaman List ticket (Assignment Ticket)
        redirect('ticket_teknisi/index_tugas');
      } else {
        echo 'Success to send email';
      }
    }
  }

  public function emailubah($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Category of Work Order (" . $query->id_ticket . ") Has Been Changed</h1>";
    $isiEmail .= "<div>Please assign the technician after you check the detail to resolve the Work Order</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Category Changed</td>
                            </tr>
							<tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $query->nama_teknisi;
    $to = $this->settings->info['email'];
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Category of Work Order (' . $query->id_ticket . ') Has Been Changed');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      $this->session->set_flashdata('status', 'Returned');
      //Kembali ke halaman List ticket (Assignment Ticket)
      redirect('ticket_teknisi/index_tugas');
    } else {
      echo 'Success to send email';
    }
  }
  //Selesai Bagian Notifikasi Email


  //Method yang digunakan untuk proses reopen ticket dengan parameter (id_ticket)
  public function reopen($id)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 1, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 1
    );

    //Melakukan insert data tracking ticket bahwa ticket di-reopen oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Reopened",
      'deskripsi'  => "Work Order Dibuka Kembali",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //Method untuk mendapatkan semua ticket yang akan ditugaskan ke teknisi
  public function pilih_teknisi()
  {
    //Query untuk mendapatkan semua ticket dengan status 2 (Ticket Received) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, D.nama, D.email, D.telp, F.nama_dept, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1) ORDER BY A.tanggal DESC");
    return $query;
  }

  //Bagian Notifikasi Email dari Message
  public function emailmessageticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas, K.tanggal AS tanggal_message, K.status, K.message, K.id_user, K.filefoto AS filefoto_message FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    LEFT JOIN ticket_message K on K.id_ticket = A.id_ticket
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Message Work Order (" . $query->id_ticket . ")</h1>";
    $isiEmail .= "<div>New Message for Work Order with Number " . $query->id_ticket . " has been submited by " . $query->nama . "</div>";
    $isiEmail .= "<div>Please response and reply of the Work Order message in <b>TNA PORTAL Web Application</b></div><br/>";

    $isiEmail .= "<div>Date: " . $query->tanggal . "</div><br/>";
    $isiEmail .= "<div>Message: " . $query->message . "</div><br/>";

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    if ($this->session->userdata('level') == 'Admin') {
      $to = $query->email;
    } else if ($this->session->userdata('level') == 'Technician') {
      $to = $query->email;
    } else if ($this->session->userdata('level') == 'User') {
      $to = $this->settings->info['email'];
    }
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('New Message Work Order (' . $query->id_ticket . ')');
    $this->email->attach('uploads/' . $query->filefoto_message);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
    } else {
      echo 'Success to send email';
    }
  }

  //NEW ONE
  //Method untuk mendapatkan semua ticket pada dept masing-masing yang belum dilakukan approval 2025-02-20
  public function deptTicket($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail,A.due_date,  A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC");
    // $query = $this->db->query($sql, array($id));
    return $query;
  }

  //Method untuk mendapatkan semua ticket dari user dept masing-masing berdasarkan id dept
  public function getTicketSpvDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd");
    return $query->row();
  }

  //Method untuk mendapatkan ticket baru submitterd (1) dan belum di approve (2) dari user dept masing-masing berdasarkan id dept
  public function getNewTicketSpvDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status IN (1,2)");
    return $query->row();
  }

  //Method untuk mendapatkan ticket reject (0) dari user dept masing-masing berdasarkan id dept
  public function getRejectTicketSpvDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status = 0");
    return $query->row();
  }

  public function getDept($id)
  {
    //Query untuk mendapatkan dept
    $query = $this->db->query("SELECT nama_dept FROM pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept 
    INNER JOIN departemen d ON d.id_dept = db.id_dept 
    WHERE p.nik = '$id'");
    return $query->row();
  }


  //list daftar ticket spv dept
  public function list_ticket_spv($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    WHERE A.status <> 10            
    ORDER BY A.tanggal DESC");
    return $query;
  }


  //Method yang digunakan untuk proses approve ticket dengan parameter (id_ticket)
  public function approveSpv($id)
  {
    //Mengambil session SPV
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 2, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 8,
      'last_update' => date("Y-m-d  H:i:s"),
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh SPV, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Approved",
      'deskripsi'  => "Approved by Supervisor Dept",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //MGR
  public function mgrTicket($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 8 (diajukan ke MGR) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status = 11
    ORDER BY A.tanggal DESC");
    return $query;
  }

  public function getTicketMgr($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status IN (11)"); /*8 akan di ganti menjadi kode baru yaitu 10 karena harus approved mgr dept dulu*/
    return $query->row();
  }

  public function getNewTicketMgr($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status = 11"); /*8 akan di ganti menjadi kode baru yaitu 11 karena harus approved mgr dept dulu*/
    return $query->row();
  }

  //list daftar ticket manager
  public function list_ticket_mgr($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (0, 11, 9, 3, 10) /*8: diganti jadi 11 karena harus approved by mgr dept*/
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk menaruh data user spv tech sesuai dengan kategori yang dipilih pada dropdown
  function dropdown_spv_tech()
  {
    //Query untuk mengambil data user yang memiliki level 'MGR'
    $query = $this->db->query("SELECT 'SPVU' AS username, 'Supervisor Maintenance & Utility' AS nama FROM dual
                              UNION ALL
                              SELECT 'SPVM' AS username, 'Dies,Waorkshop Officer' AS nama FROM dual");

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data user spvu dan spvm ke dalam dropdown, value yang akan diambil adalah value id_user yang memiliki level 'Technician'
    foreach ($query->result() as $row) {
      $value[$row->username] = $row->nama;
    }
    return $value;
  }


  //Method yang digunakan untuk proses approve ticket dengan parameter (id_ticket)
  public function approveMgr($id)
  {
    $sql        = $this->db->query("SELECT tanggal FROM ticket WHERE id_ticket = '$id'")->row();
    $date       = $sql->tanggal;
    $date2      = $this->input->post('waktu_respon');
    //Mengambil session MGR
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 9, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'       => 9,
      'last_update'  => date("Y-m-d  H:i:s"),
      'assign_to'    => $this->input->post('id_spv_tech'),
      'notes'        => $this->input->post('notes')
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh MGR, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Assign to " . $this->input->post('id_spv_tech'),
      'deskripsi'  => $this->input->post('notes'),
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //SPVU
  public function spvuTicket($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 8 (diajukan ke MGR) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (9, 5)
    AND A.assign_to  = 'SPVU'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  public function getTicketSpvu($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status IN (9,3,5)
    AND t.assign_to = 'SPVU'");
    return $query->row();
  }

  public function getNewTicketSpvu($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status = 9
    AND t.assign_to = 'SPVU'");
    return $query->row();
  }

  public function list_ticket_spvu()
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (3,9,5)
    AND A.assign_to = 'SPVU'
    ORDER BY A.tanggal DESC");
    return $query;
  }


  //SPVM
  public function spvmTicket($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (9,5)
    AND A.assign_to  = 'SPVM'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  public function getTicketSpvm($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status IN (9,3,5)
    AND t.assign_to = 'SPVM'");
    return $query->row();
  }

  public function getNewTicketSpvm($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE t.status = 9
    AND t.assign_to = 'SPVM'");
    return $query->row();
  }

  public function list_ticket_spvm()
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (3,9,5)
    AND A.assign_to = 'SPVM'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method yang digunakan untuk proses noted ticket dengan parameter id_ticket
  public function noted($id, $alasan = null)
  {
    //Mengambil session MGR
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 10, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'      => 10,
      'last_update' => date("Y-m-d  H:i:s"),
      'mgr_noted'   => $alasan,
      'mgr_id'      => $id_user,
      'mgr_date'    => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket di-noted oleh MGR, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Returned",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //Incident
  public function myIncident($id)
  {
    //Query untuk mengambil semua incident yang di input user dengan parameter id_user
    $query = $this->db->query("SELECT id_incident, date_incident, target_dept, nama_dept, problem, status
    FROM INCIDENT i
    INNER JOIN departemen d 
    ON i.target_dept = d.id_dept
    WHERE id_input = '$id'
    ORDER BY date_incident DESC");
    return $query;
  }

  public function dropdown_target()
  {
    //Query untuk mengambil data dept dan diurutkan berdasarkan nama dept
    //$sql = "SELECT * FROM departemen d WHERE id_dept IN ('2', '8', '3') ORDER BY 1"; //-->tentukan id dept IT/HSE/GA
    $sql = "SELECT * FROM departemen d WHERE id_dept IN ('2','8','11') ORDER BY 1";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data dept ke dalam dropdown, value yang akan diambil adalah value id_dept
    foreach ($query->result() as $row) {
      $value[$row->id_dept] = $row->nama_dept;
    }
    return $value;
  }

  public function getkodeIncident()
  {
    //Query untuk mengembalikan value terbesar yang ada di kolom id_ticket
    $query = $this->db->query("SELECT max(id_ticket) AS max_code FROM ticket");

    //Menampung fungsi yang akan mengembalikan hasil 1 baris dari query ke dalam variabel $row
    $row = $query->row_array();

    //Menampung hasil kode ticket terbesar dari query
    $max_id = $row['max_code'];
    //Mengambil kode ticket pada database posisi 9 dan panjang kode 4
    $max_fix = (int) substr($max_id, 9, 4);

    //Hasil dari kode terbesar yang sudah didapatkan ditambah dengan 1, hasil dari penjumlahan ini akan digunakan sebagai kode ticket terbaru
    $max_ticket = $max_fix + 1;

    //Mengambil tanggal sekarang
    $tanggal = date("d");
    //Mengambil bulan sekarang
    $bulan = date("m");
    //Mengambil tahun sekarang
    $tahun = date("Y");

    //Membuat id_ticket dengan format T + tahun + bulan + tanggal + kode user terbaru (%04s merupakan fungsi untuk menentukan lebar minimum yang dimiliki nilai variable serta mengubah int menjadi string, %04s menandakan lebar minimum dari tiket yaitu 4 dengan padding berupa angka 0)
    $ticket = "T" . $tahun . $bulan . $tanggal . sprintf("%04s", $max_ticket);
    return $ticket;
  }

  public function getkodeIncidentNew($id)
  {
    //$this->load->helper('string');
    //$ticket = random_string('alnum', 9);
    $ticket = "INCIDENT-" . date("YmdHis") . "-" . $id;
    return $ticket;
  }

  public function detail_incident($id)
  {
    //Query untuk mendapatkan data detail dari setiap incident
    $query = $this->db->query("SELECT id_incident, nama, email, telp, CONCAT(nama_dept, ' - ', nama_bagian_dept) AS nama_dept,  date_incident, 
    (SELECT MAX(dd.NAMA_DEPT) FROM departemen dd WHERE dd.id_dept = I.target_dept) AS target_dept, problem, path_photo AS filefoto, status, 
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_action) AS id_action, date_action, reason_reject,
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_pic) AS id_pic, date_pic, i.message, i.progress, i.path_solve_photo,
    CONCAT(k.nama_kategori, ' - ', ks.nama_sub_kategori) AS kategori, l.lokasi
    FROM INCIDENT I
    INNER JOIN PEGAWAI P
    ON I.id_input = P.nik
    INNER JOIN departemen_bagian db 
    ON P.id_bagian_dept = DB.id_bagian_dept
    INNER JOIN departemen d 
    ON DB.id_dept = D.id_dept
    INNER JOIN lokasi l 
    ON I.id_lokasi  = l.id_lokasi
    INNER JOIN kategori_sub ks 
    ON I.id_sub_kategori = ks.id_sub_kategori
    INNER JOIN kategori k 
    ON ks.id_kategori = k.id_kategori
    WHERE I.id_incident = '$id'");
    return $query;
  }

  //SPV Incident
  public function spvIncident($dept)
  {
    //Query untuk mengambil semua incident yang di input user dengan parameter id_user
    $query = $this->db->query("SELECT i.id_incident , i.date_incident , i.target_dept , d.nama_dept , i.problem , i.status 
    FROM INCIDENT i
    INNER JOIN departemen d 
    ON i.target_dept = d.id_dept
    INNER JOIN pegawai p 
    ON i.id_input = p.nik 
    INNER JOIN departemen_bagian db 
    ON p.id_bagian_dept = db.id_bagian_dept 
    INNER JOIN departemen d2
    ON db.id_dept = d2.id_dept 
    WHERE d2.id_dept = '$dept'
    ORDER BY i.id_incident DESC");
    return $query;
  }

  public function detail_incident_spv($id)
  {
    //Query untuk mendapatkan data detail dari setiap incident
    $query = $this->db->query("SELECT id_incident, nama, email, telp, CONCAT(nama_dept, ' - ', nama_bagian_dept) AS nama_dept,  date_incident, 
    (SELECT MAX(dd.NAMA_DEPT) FROM departemen dd WHERE dd.id_dept = I.target_dept) AS target_dept, problem, path_photo AS filefoto, status, 
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_action) AS id_action, date_action,
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_pic) AS id_pic, date_pic, i.message, i.progress, i.path_solve_photo
    FROM INCIDENT I
    INNER JOIN PEGAWAI P
    ON I.id_input = P.nik
    INNER JOIN departemen_bagian db 
    ON P.id_bagian_dept = DB.id_bagian_dept
    INNER JOIN departemen d 
    ON DB.id_dept = D.id_dept
    WHERE I.id_incident = '$id'");
    return $query;
  }

  public function approveIncidentSpv($id)
  {
    //Mengambil session SPV
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data incident dengan mengubah status incident menjadi S (Setuju), data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'      => "S",
      'id_action'   => $id_user,
      'date_action' => date("Y-m-d  H:i:s"),
      'upd_id'      => $id_user,
      'upd_date'    => date("Y-m-d  H:i:s"),
    );

    // //Melakukan insert data tracking ticket bahwa ticket di-approve oleh SPV, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    // $datatracking = array(
    //   'id_ticket'  => $id,
    //   'tanggal'    => date("Y-m-d  H:i:s"),
    //   'status'     => "Ticket Approved",
    //   'deskripsi'  => "Approved by Supervisor Dept",
    //   'id_user'    => $id_user
    // );

    //Query untuk melakukan update data incident sesuai dengan array '$data' ke tabel incident
    $this->db->where('id_incident', $id);
    $this->db->update('incident', $data);

    // //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    // $this->db->insert('tracking', $datatracking);
  }

  public function rejectIncident($id, $alasan = null)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 0, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'        => "T",
      'id_action'     => $id_user,
      'date_action'   => date("Y-m-d  H:i:s"),
      'upd_id'        => $id_user,
      'reason_reject' => $alasan,
      'upd_date'      => date("Y-m-d  H:i:s")
    );

    // //Melakukan insert data tracking ticket bahwa ticket di-reject oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    // $datatracking = array(
    //   'id_ticket'  => $id,
    //   'tanggal'    => date("Y-m-d  H:i:s"),
    //   'status'     => "Ticket Rejected",
    //   'deskripsi'  => $alasan,
    //   'id_user'    => $id_user
    // );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_incident', $id);
    $this->db->update('incident', $data);

    // //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    // $this->db->insert('tracking', $datatracking);
  }

  //PIC Incident
  public function picIncident($dept)
  {
    //Query untuk mengambil semua incident yang di input user dengan parameter target_dept
    $query = $this->db->query("SELECT id_incident, date_incident, target_dept, nama_dept, problem, status
    FROM INCIDENT i
    INNER JOIN departemen d 
    ON i.target_dept = d.id_dept
    WHERE target_dept = '$dept'
    AND status IN ('S', 'O', 'X', 'P')
    ORDER BY i.id_incident DESC");
    return $query;
  }

  //Update Incident
  public function update_progress_incident($id)
  {
    //Mengambil session user id
    $id_user  = $this->session->userdata('id_user');

    //Mengambil data progress dan deskripsi untuk update system tracking ticket
    $progress = $this->input->post('progress');
    $date     = date("Y-m-d  H:i:s");
    //$sql      = $this->db->query("SELECT deadline FROM ticket WHERE id_ticket='$id'")->row();

    //Konfigurasi Upload Gambar
    $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
    $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
    $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
    $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
    $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

    //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
    $this->load->library('upload', $config);

    //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
    if (!$this->upload->do_upload('fileupdate')) {
      $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
      redirect('incident_pic/detail_update/' . $id);
    } else {
      //Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
      //Menampung file gambar ke variable 'gambar'
      $gambar   = $this->upload->data();

      //Signature pad
      $folderPath = './files/teknisi/signature/';
      $image_parts = explode(";base64,", $this->input->post('signed'));
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $fileName = uniqid() . '.' . $image_type;
      $file = $folderPath . $fileName;
      file_put_contents($file, $image_base64);

      if ($progress == 100) {

        $data = array(
          'status'            => "O", //ok
          'id_pic'            => $id_user,
          'date_pic'          => $date,
          'progress'          => $progress,
          'message'           => ucfirst($this->input->post('desk')),
          'path_solve_photo'  => $gambar['file_name'],
          'path_signature'    => $fileName
        );
      } else {
        $data = array(
          'status'            => "X", //belum ok
          'id_pic'            => $id_user,
          'date_pic'          => $date,
          'progress'          => $progress,
          'message'           => ucfirst($this->input->post('desk')),
          'path_solve_photo'  => $gambar['file_name'],
          'path_signature'    => $fileName
        );
      }

      //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
      $this->db->where('id_incident', $id);
      $this->db->update('incident', $data);
    }
  }


  //Manager Dept 2025.05.19
  //Dashboard MGRD
  public function getTicketMgrDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd");
    return $query->row();
  }

  public function getRejectTicketMgrDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status = 0");
    return $query->row();
  }

  public function getNewTicketMgrDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status IN (1,2)");
    return $query->row();
  }



  //list daftar ticket mgr dept
  public function list_ticket_mgrd($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.due_date, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    -- WHERE A.status IN ('8', '0', '11', '10')            
    ORDER BY A.tanggal DESC");
    return $query;
  }

  public function deptTicketMgrd($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail,A.due_date,  A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    WHERE A.status IN (8,10)
    ORDER BY A.tanggal DESC");
    // $query = $this->db->query($sql, array($id));
    return $query;
  }


  public function approveMgrd($id, $user_mail)
  {
    //Mengambil session MGRD
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'      => 11,
      'last_update' => date("Y-m-d  H:i:s"),
      'user_mail'   => urldecode($user_mail)
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh MGRD, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Approved",
      'deskripsi'  => "Approved by Manager Dept",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //detail khusus mgrd
  public function detail_ticket_mgrd($id, $nik)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, A.id_prioritas, A.id_sub_kategori, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, A.teknisi AS id_teknisi, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas, J.warna, J.waktu_respon, K.nama_jabatan, 
    CASE WHEN A.assign_to = 'SPVU' THEN 'Supervisor Utility' 
	  WHEN A.assign_to = 'SPVM' THEN 'Supervisor Maintenance'
	  ELSE A.assign_to
    END AS assign_to,
    (SELECT MAX(z.email) FROM pegawai z WHERE z.id_jabatan = 5 AND z.id_bagian_dept = D.id_bagian_dept) AS mail,
    z.deskripsi AS returned_reason,
    z.nama AS manager_name,
    z.tanggal AS tanggal_reason,
    A.id_lokasi,
    (SELECT MAX(z.email) FROM pegawai z WHERE z.nik = '$nik') AS user_mail,
    (SELECT MAX(z.email) FROM pegawai z WHERE z.nik = A.mgr_id) AS mgr_mail,
    (SELECT MAX(z.email) FROM pegawai z WHERE z.nik = A.teknisi) AS teknisi_mail,
    A.mgr_id , A.mgr_date,A.mgr_noted, A.mgrd_id, A.mgrd_date, A.mgrd_noted,
    A.mgr_reject,
    A.mgr_reject_id,
    A.mgrd_reject,
    A.mgrd_reject_id,
    A.last_update,
    A.memo_teknisi,
    A.answerfoto,
    A.notes
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = A.teknisi
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    LEFT JOIN jabatan K ON K.id_jabatan = D.id_jabatan
    LEFT JOIN (SELECT a.id_ticket, a.deskripsi, b.nama, a.tanggal FROM tracking a LEFT JOIN pegawai b ON a.id_user = b.nik  WHERE a.tanggal = (SELECT max(b.tanggal) FROM tracking b WHERE b.id_ticket = a.id_ticket) AND a.status = 'Ticket Returned') z
    ON A.id_ticket = z.id_ticket
    WHERE A.id_ticket = '$id'");
    return $query;
  }

  //noted from mgrd
  public function noted_mgrd($id, $alasan = null)
  {
    //Mengambil session MGR
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 10, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'       => 11,
      'last_update'  => date("Y-m-d  H:i:s"),
      'mgrd_noted'   => $alasan,
      'mgrd_id'      => $id_user,
      'mgrd_date'    => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket di-noted oleh MGR, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Work Order Resubmit",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }



  //email approve spv dept
  public function emailapprovespvticket($id, $id_user)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        WHERE p.id_jabatan = 6
        AND d.id_dept = I.id_dept) AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_spv,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_spv
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Approved SPV</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been approved SPV by " . $query->nama_spv . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Approved Supervisor</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Approved SPV By</td>
                              <td>:</td>
                              <td>' . $query->nama_spv . '</td>
                            </tr>

                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Approved SPV');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Approved");
      //Dialihkan ke halaman my ticket
      redirect('ticket_spv/index_tugas');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  //email dari mgrd
  public function emailapprovemgrdticket($id, $id_user)
  {
    //jabatan 6 --> manager, dept 3 --> maintenance
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        WHERE p.id_jabatan = 6
        AND d.id_dept = 3) AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_mgrd,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_mgrd
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Approved MGRD</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been approved MGRD by " . $query->nama_mgrd . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Approved Manager</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Approved MGRD By</td>
                              <td>:</td>
                              <td>' . $query->nama_mgrd . '</td>
                            </tr>

                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Approved MGRD');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Approved");
      //Dialihkan ke halaman my ticket
      redirect('ticket_mgrd/index_tugas');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  //email return from mgr maintenance
  public function emailnoted($id, $id_user, $alasan)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        WHERE p.id_jabatan = 6
        AND d.id_dept = I.id_dept) AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_mgr,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_mgr
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Returned</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been returned by " . $query->nama_mgr . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Returned</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Returned By</td>
                              <td>:</td>
                              <td>' . $query->nama_mgr . '</td>
                            </tr>
                            <tr>
                              <td>Reason</td>
                              <td>:</td>
                              <td>' . $alasan. '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Approved MGRD');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Approved");
      //Dialihkan ke halaman my ticket
      redirect('ticket_mgr/list_tugas_mgr');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  //email resubmit from mgr dept
  public function emailresubmit($id, $id_user, $alasan)
  {
    //jabatan 6 --> manager, dept 3 --> maintenance
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        WHERE p.id_jabatan = 6
        AND d.id_dept = 3) AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_mgrd,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_mgrd
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Resubmited</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been resubmited by " . $query->nama_mgrd . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Approved Manager</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Returned By</td>
                              <td>:</td>
                              <td>' . $query->nama_mgrd . '</td>
                            </tr>
                            <tr>
                              <td>Answer</td>
                              <td>:</td>
                              <td>' . $alasan. '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Resubmited');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Approved");
      //Dialihkan ke halaman my ticket
      redirect('ticket_mgr/index_tugas');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  //email assogn to spvm or spvu
  public function emailassign($id, $id_user, $level)
  {
    //jabatan 6 --> manager, dept 3 --> maintenance
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        INNER JOIN `user` u 
        ON u.username = p.nik
        WHERE u.`level` = '$level') AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_mgrd,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_mgrd,
        (SELECT MAX(p.nama) FROM pegawai p 
		WHERE p.nik = (SELECT MAX(username) FROM `user` u WHERE u.`level` = '$level')) AS nama_spv
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Assigned</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been assigned by " . $query->nama_mgrd . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Assigned By Manager</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Assigned By</td>
                              <td>:</td>
                              <td>' . $query->nama_mgrd . '</td>
                            </tr>
                            <tr>
                              <td>Assigned To</td>
                              <td>:</td>
                              <td>' . $query->nama_spv. '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;
    // $to = "it.deny@changshininc.com";

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Assigned');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      // show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Assigned");
      //Dialihkan ke halaman my ticket
      redirect('ticket_mgrd/list_tugas_mgr');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }

  //spvm
public function emailpenugasan2($id, $id_user, $id_teknisi)
  {
    //jabatan 6 --> manager, dept 3 --> maintenance
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        INNER JOIN `user` u 
        ON u.username = p.nik
        WHERE u.`level` = '$level') AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_spv,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_spv,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_teknisi') AS nama_teknisi
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Assigned</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been assigned by " . $query->nama_spv . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Assigned To Technician</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Assigned By</td>
                              <td>:</td>
                              <td>' . $query->nama_spv . '</td>
                            </tr>
                            <tr>
                              <td>Assigned To</td>
                              <td>:</td>
                              <td>' . $query->nama_teknisi. '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
  $to = $this->settings->info['email'];
      $to = $query->mail_to;
   

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Assigned');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      // show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Assigned");
      //Dialihkan ke halaman my ticket
      redirect('ticket_spvm/list_tugas_spvm');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  //email penugasan dari spvu ke teknisi
  public function emailpenugasan($id, $id_user, $id_teknisi)
  {
    //jabatan 6 --> manager, dept 3 --> maintenance
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.due_date, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas 
    , (SELECT MAX(p.email)
        FROM pegawai p 
        INNER JOIN departemen_bagian db 
        ON p.id_bagian_dept = db.id_bagian_dept 
        INNER JOIN departemen d 
        ON db.id_dept = d.id_dept 
        INNER JOIN jabatan j 
        ON j.id_jabatan = p.id_jabatan 
        INNER JOIN `user` u 
        ON u.username = p.nik
        WHERE u.`level` = '$level') AS mail_to,
        (SELECT MAX(nik) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nik_spv,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_user') AS nama_spv,
        (SELECT MAX(nama) FROM pegawai p2 WHERE p2.nik = '$id_teknisi') AS nama_teknisi
    FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Work Order (" . $query->id_ticket . ") Has Been Assigned</h1>";
    $isiEmail .= "<div>Work Order with Number " . $query->id_ticket . " has been assigned by " . $query->nama_spv . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the Work Order in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Work Order</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Assigned To Technician</td>
                            </tr>
							              <tr>
                              <td>due date</td>
                              <td>:</td>
                              <td>' . $query->due_date . '</td>
                            </tr>
                            <tr>
                              <td>Assigned By</td>
                              <td>:</td>
                              <td>' . $query->nama_spv . '</td>
                            </tr>
                            <tr>
                              <td>Assigned To</td>
                              <td>:</td>
                              <td>' . $query->nama_teknisi. '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $to = $this->settings->info['email'];
    $to = $query->mail_to;
   

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama_spv);
    $this->email->to($to);
    $this->email->subject('New Work Order (' . $query->id_ticket . ') Has Been Assigned');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      // show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', "Assigned");
      //Dialihkan ke halaman my ticket
      redirect('ticket_spvu/list_tugas_spvu');
    } else {
      // $this->session->set_flashdata('status', 'Ok Mail Terkirims');
      echo 'Success to send email';
    }
  }


  public function close_ticket($id)
  {
    $id_user = $this->session->userdata('id_user');
    $data = array(
      'status' => 12
    );

    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Closed",
      'id_user'    => $id_user
    );

    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    $this->db->insert('tracking', $datatracking);
  }

  
  //closing progress when status 13 (return to technician)
  public function close_progress($id)
  {
    //Mengambil session teknisi
    $id_user  = $this->session->userdata('id_user');

    //Mengambil data progress dan deskripsi untuk update system tracking ticket
    $progress = $this->input->post('progress');
    $date     = date("Y-m-d  H:i:s");
    $sql      = $this->db->query("SELECT deadline FROM ticket WHERE id_ticket='$id'")->row();

    //Konfigurasi Upload Gambar
    $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
    $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
    $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
    $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
    $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

    //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
    $this->load->library('upload', $config);

    //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
    if (!$this->upload->do_upload('fileupdate')) {
      $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
      redirect('ticket_teknisi/detail_update/' . $id);
    } else {
      //Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
      //Menampung file gambar ke variable 'gambar'
      $gambar   = $this->upload->data();

      //Signature pad
      $folderPath = './files/teknisi/signature/';
      $image_parts = explode(";base64,", $this->input->post('signed'));
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $fileName = uniqid() . '.' . $image_type;
      $file = $folderPath . $fileName;
      file_put_contents($file, $image_base64);

      //prioritas jika progress yang sudah selesai, maka status ticket pada system tracking ticket menjadi ticket closed dengan keterangan progress ticketnya juga
      if ($progress == 100) {
        if (date("Y-m-d  H:i:s") > $sql->deadline) {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 12,
            //'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress,
            'memo_teknisi'   => $this->input->post('desk')
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Work Order Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        } else {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 12,
            // 'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress,
            'memo_teknisi'   => $this->input->post('desk')
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Work Order Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        }
      } else {
        //Bagian ini jika prioritasnya progress ticket belum selesai dikerjakan, maka data yang diupdate hanya status dan progress
        //Melakukan update data ticket dengan mengubah status ticket menjadi 4, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
        $data = array(
          'status'       => 4,
          'last_update'  => date("Y-m-d  H:i:s"),
          'progress'     => $progress,
          'memo_teknisi' => $this->input->post('desk')
        );

        //Melakukan insert data tracking ticket progress oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
        $datatracking = array(
          'id_ticket'  => $id,
          'tanggal'    => date("Y-m-d  H:i:s"),
          'status'     => "Progress: " . $progress . " %",
          'deskripsi'  => ucfirst($this->input->post('desk')),
          'id_user'    => $id_user,
          'filefoto'   => $gambar['file_name'],
          'signature'  => $fileName
        );
      }
      //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
      $this->db->where('id_ticket', $id);
      $this->db->update('ticket', $data);

      //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
      $this->db->insert('tracking', $datatracking);
    }
  }


  //Incident Mgr
  public function mgrIncident($dept)
  {
    //Query untuk mengambil semua incident yang di input user dengan parameter id_user
    $query = $this->db->query("SELECT i.id_incident , i.date_incident , i.target_dept , d.nama_dept , i.problem , i.status 
    FROM INCIDENT i
    INNER JOIN departemen d 
    ON i.target_dept = d.id_dept
    INNER JOIN pegawai p 
    ON i.id_input = p.nik 
    INNER JOIN departemen_bagian db 
    ON p.id_bagian_dept = db.id_bagian_dept 
    INNER JOIN departemen d2
    ON db.id_dept = d2.id_dept 
    WHERE d2.id_dept = '$dept'
    ORDER BY i.id_incident DESC");
    return $query;
  }

  public function detail_incident_mgr($id)
  {
    //Query untuk mendapatkan data detail dari setiap incident
    $query = $this->db->query("SELECT id_incident, nama, email, telp, CONCAT(nama_dept, ' - ', nama_bagian_dept) AS nama_dept,  date_incident, 
    (SELECT MAX(dd.NAMA_DEPT) FROM departemen dd WHERE dd.id_dept = I.target_dept) AS target_dept, problem, path_photo AS filefoto, status, 
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_action) AS id_action, date_action,
    (SELECT MAX(nama) FROM pegawai WHERE nik = i.id_pic) AS id_pic, date_pic, i.message, i.progress, i.path_solve_photo
    FROM INCIDENT I
    INNER JOIN PEGAWAI P
    ON I.id_input = P.nik
    INNER JOIN departemen_bagian db 
    ON P.id_bagian_dept = DB.id_bagian_dept
    INNER JOIN departemen d 
    ON DB.id_dept = D.id_dept
    WHERE I.id_incident = '$id'");
    return $query;
  }

public function approveIncidentMgr($id)
  {
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data incident dengan mengubah status incident menjadi S (Setuju), data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'      => "S",
      'id_action'   => $id_user,
      'date_action' => date("Y-m-d  H:i:s"),
      'upd_id'      => $id_user,
      'upd_date'    => date("Y-m-d  H:i:s"),
    );

    //Query untuk melakukan update data incident sesuai dengan array '$data' ke tabel incident
    $this->db->where('id_incident', $id);
    $this->db->update('incident', $data);
  }

  public function pending_incident($id, $alasan = null)
  {
    $id_user    = $this->session->userdata('id_user');
    $data = array(
      'status'      => "P",
      'message'     => $alasan,
      'upd_id'      => $id_user,
      'upd_date'    => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket di-noted oleh MGR, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Pending Incident",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_incident', $id);
    $this->db->update('incident', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }



  //Query Untuk Assets
  public function assets()
  {
    $query = $this->db->query("SELECT a.*, (SELECT p.nama FROM pegawai p WHERE nik = a.id_user) AS user_name
                                 FROM assets a
                                ORDER BY a.id_user, a.id_asset");
    return $query;
  }

   public function getAsset($id)
  {
    $query = $this->db->query("SELECT * FROM assets WHERE id_asset = '$id'");
    return $query;
  }

  public function getCodeAsset($id)
  {
    // Ambil data terakhir untuk user tertentu (ID user = $id)
    $this->db->like('id_asset', 'ASSET-' . $id . '-', 'after');
    $this->db->order_by('id_asset', 'DESC');
    $last = $this->db->get('assets')->row();

    if ($last) {
        // Pecah dan ambil angka terakhir
        $explode = explode('-', $last->id_asset);
        $lastNumber = intval(end($explode)); // misalnya 003
    } else {
        $lastNumber = 0;
    }

    $nextNumber = $lastNumber + 1;

    // Format jadi 3 digit: 001, 002, dst.
    $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    // Bentuk final kode ID
    $code_id = "ASSET-" . $id . "-" . $formattedNumber;

    return $code_id;
  }


  //My Asset
  public function myAsset($id)
  {
    $query = $this->db->query("SELECT * FROM assets WHERE id_user = '$id' ORDER BY id_asset");
    return $query;
  }


  //Rental Vehicle
  public function rental($id)
  {
    $query = $this->db->query("SELECT rv.id_req,
	                                    DATE_FORMAT(rv.req_date, '%Y-%m-%d %H:%i') AS req_date,
                                      DATE_FORMAT(rv.end_date, '%Y-%m-%d %H:%i') AS end_date,
                                      v.vehicle_name,
                                      rv.driver_yn,
                                      rv.status
                                 FROM request_vehicle rv
                                 LEFT JOIN vehicle v
                                   ON rv.vehicle = v.id_vehicle
                                WHERE rv.user_req = '$id' 
                                ORDER BY rv.id_req DESC");
    return $query;
  }

  public function dropdown_request()
  {
    //Query untuk mengambil data dept dan diurutkan berdasarkan nama dept
    $sql = "SELECT * FROM departemen d WHERE id_dept IN ('8','9','3') ORDER BY 1";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data dept ke dalam dropdown, value yang akan diambil adalah value id_dept
    foreach ($query->result() as $row) {
      $value[$row->id_dept] = $row->nama_dept;
    }
    return $value;
  }

  public function dropdown_vehicle($id_dept)
  {
    $sql = "SELECT * FROM vehicle where id_dept ='$id_dept' ORDER BY 1";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';

    foreach ($query->result() as $row) {
      $value[$row->id_vehicle] = $row->vehicle_name;
    }
    return $value;
  }

  public function getIdReq($id)
  {
    $id_req = "REQ-" . date("YmdHis") . "-" . $id;
    return $id_req;
  }

  public function returnVehicle($id, $photo, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'       => "6",
      'path_return'  => $photo,
      'return_desc'  => $desc,
      'return_date'  => date("YmdHis")
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }

  //Rental SPV
  public function rentalSpv($id_dept)
  {
    $query = $this->db->query("SELECT rv.id_req,
	                                    DATE_FORMAT(rv.req_date, '%Y-%m-%d %H:%i') AS req_date,
                                      DATE_FORMAT(rv.end_date, '%Y-%m-%d %H:%i') AS end_date,
                                      v.vehicle_name,
                                      rv.driver_yn,
                                      rv.status
                                 FROM request_vehicle rv 
                                 LEFT JOIN vehicle v 
                                   ON rv.vehicle = v.id_vehicle 
                                /*WHERE rv.dept = '$id_dept' */
                                WHERE rv.target_dept = '$id_dept' 
                                ORDER BY rv.id_req DESC");
    return $query;
  }

  public function detail_request($id)
  {
    $query = $this->db->query("SELECT a.id_req ,
                                      (SELECT MAX(p.nama) FROM pegawai p WHERE p.nik = a.user_req) AS user_req,
                                      (SELECT MAX(d.nama_dept) FROM departemen d WHERE d.id_dept = a.dept) AS dept,
                                      (SELECT MAX(d.nama_dept) FROM departemen d WHERE d.id_dept = a.target_dept) AS target_dept,
                                      (SELECT MAX(v.vehicle_name) FROM vehicle v WHERE v.id_vehicle = a.vehicle) AS vehicle,
                                      (SELECT CASE WHEN a.driver_yn = 'Y' THEN 'Ya, Dengan Driver' ELSE 'Tidak Dengan Driver' END) AS driver_yn,
                                      a.driver_yn AS driver_yn_code,
                                      a.status,
                                      a.req_date,
                                      a.desc,
                                      a.path_photo,
                                      (SELECT MAX(p.nama) FROM pegawai p WHERE p.nik = a.user_spv) AS user_spv,
                                      a.spv_desc,
                                      a.user_pic,
                                      a.driver_name,
                                      a.vehicle_name,
                                      a.pic_desc,
                                      a.path_return
                               FROM request_vehicle a WHERE a.id_req = '$id'");
    return $query;
  }

  public function approveSpvVehicle($id, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'      => "2",
      'user_spv'    => $id_user,
      'spv_desc'    => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }

  public function rejectSpvVehicle($id, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'      => "0",
      'user_spv'    => $id_user,
      'spv_desc'    => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }


  //Rental PIC
  public function rentalPic($id_dept)
  {
    $query = $this->db->query("SELECT rv.id_req,
	                                    DATE_FORMAT(rv.req_date, '%Y-%m-%d %H:%i') AS req_date,
                                      DATE_FORMAT(rv.end_date, '%Y-%m-%d %H:%i') AS end_date,
                                      p.nama,
                                      v.vehicle_name,
                                      rv.driver_yn,
                                      rv.status
                                 FROM request_vehicle rv 
                                 LEFT JOIN vehicle v 
                                   ON rv.vehicle = v.id_vehicle 
                                 LEFT JOIN pegawai p 
                                   ON rv.user_req  = p.nik
                                WHERE rv.target_dept = '$id_dept' 
                                ORDER BY rv.id_req DESC");
    return $query;
  }

  public function approvePicVehicle($id, $driver_name, $vehicle_name, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'       => "3",
      'user_pic'     => $id_user,
      'driver_name'  => $driver_name,
      'vehicle_name' => $vehicle_name,
      'pic_desc'     => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
    $this->model->email_rental_approve($id_req);
  }

  public function rejectPicVehicle($id, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'      => "0",
      'user_pic'    => $id_user,
      'pic_desc'    => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }

  public function finishedVehicle($id, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'              => "5",
      'pic_dreturn_desc'    => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }

  public function giveBackVehicle($id, $desc)
  {
    $id_user    = $this->session->userdata('id_user');

    $data = array(
      'status'              => "4",
      'pic_dreturn_desc'    => $desc
    );

    $this->db->where('id_req', $id);
    $this->db->update('request_vehicle', $data);
  }

  //Maintenance Management
  public function maintenance($id)
  {
    $query = $this->db->query("SELECT wom.wo_id,
                                      DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') AS wo_date,
                                      wom.machine_id,
                                      wom.machine_name,
                                      wom.req_message,
                                      wom.status,
                                      IFNULL(TIMEDIFF(wom.checker_time, wom.req_time), '00:00:00') AS respone_time
                                 FROM work_order_management wom
                                WHERE wom.req_id = '$id'
                             ORDER BY DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s')  DESC");
    return $query;
  }

  public function getMachineById($machine_id)
  {
      $query = $this->db->query("
          SELECT machine_name 
          FROM master_machine 
          WHERE machine_id = '$machine_id'
      ");

      return $query->row();
  }

  public function getIdWo($id)
  {
    $id_wo = "WOM-" . date("YmdHis") . "-" . $id;
    return $id_wo;
  }

  public function maintenanceAct($id)
  {
    $query = $this->db->query("SELECT wom.wo_id,
                                      DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') AS wo_date,
                                      wom.machine_id,
                                      wom.machine_name,
                                      wom.req_message,
                                      wom.status,
                                      IFNULL(TIMEDIFF(wom.checker_time, wom.req_time), '00:00:00') AS respone_time
                                 FROM work_order_management wom
                             ORDER BY DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') DESC");
    return $query;
  }

  public function act($id)
  {
    $query = $this->db->query("SELECT wom.wo_id,
                                      DATE_FORMAT(wom.req_time, '%Y-%m-%d %H:%i:%s') AS wo_date,
                                      wom.machine_id,
                                      wom.machine_name,
                                      wom.req_message,
                                      wom.status,
                                      DATE_FORMAT(wom.req_time, '%Y-%m-%d') AS req_date,
                                      TIME_FORMAT(wom.req_time, '%H:%i:%s') AS req_time,
                                      wom.path_photo_1,
                                      wom.path_photo_2,
                                      wom.mtc_message,
                                      wom.root_cause,
                                      wom.temp_act,
                                      wom.prev_act,
                                      wom.approver_message
                                 FROM work_order_management wom
                                WHERE wom.wo_id = '$id'
                             ORDER BY wom.wo_date DESC");
    return $query;
  }

  public function checkRepairingMachine($machine_id)
  {
      $query = $this->db->query("
          SELECT COUNT(*) AS CNT
            FROM WORK_ORDER_MANAGEMENT 
           WHERE machine_id = '$machine_id'
             AND status IN ('0', '1', '2')");

      return $query->row()->CNT;
  }

  public function email_rental($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT *
                              FROM request_vehicle rv 
                              LEFT JOIN pic_rental_mail prm 
                              ON rv.target_dept = prm.dept
                              INNER JOIN departemen d 
                              ON rv.target_dept = d.id_dept 
                              INNER JOIN vehicle v 
                              ON rv.vehicle = v.id_vehicle 
                              INNER JOIN pegawai p 
                              ON rv.user_req = p.nik 
                              WHERE id_req = '$id'")->row();

    $isiEmail  = "<h1>New Request Vehicle (" . $query->id_req . ") Has Been Submited</h1>";
    $isiEmail .= "<div>Request Vehicle with Number " . $query->id_req . " has been submited by " . $query->nama . "</div>";
    $isiEmail .= "<div>Please response in <b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                    <table>
                      <tbody>
                        <tr>
                          <td>ID Rental</td>
                          <td>:</td>
                          <td>' . $query->id_req . '</td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td>:</td>
                          <td>' . $query->nama . '</td>
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td>:</td>
                          <td>' . $query->email . '</td>
                        </tr>
                        <tr>
                          <td>Target Dept</td>
                          <td>:</td>
                          <td>' . $query->nama_dept . '</td>
                        </tr>
                        <tr>
                          <td>Vehicle</td>
                          <td>:</td>
                          <td>' . $query->vehicle_name . '</td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>:</td>
                          <td>Submited</td>
                        </tr>
                        <tr>
                          <td>req date</td>
                          <td>:</td>
                          <td>' . $query->req_date . '</td>
                        </tr>
                        <tr>
                          <td>end date</td>
                          <td>:</td>
                          <td>' . $query->end_date . '</td>
                        </tr>
                        <tr>
                          <td>Desc</td>
                          <td>:</td>
                          <td>' . nl2br($query->desc) . '</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>';

    $from = $this->settings->info['smtp_user'];
    // $to = $this->settings->info['email'];
    $to = $query->mail_to;
    $cc = $query->mail_cc;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama);
    $this->email->to($to);
    $this->email->cc($cc);
    $this->email->subject('New Request Vehicle(' . $query->id_req . ') Has Been Submited');
    $this->email->attach('uploads/' . $query->path_photo);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      $this->session->set_flashdata('status', 'Dikirim');
      redirect('rental');
    } else {
      echo 'Success to send email';
    }
  }

  public function email_rental_approve($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT rv.id_req ,
                                      rv.`desc` ,
                                      rv.path_photo ,
                                      rv.req_date ,
                                      rv.end_date ,
                                      (SELECT p2.nama FROM pegawai p2 WHERE p2.nik = rv.user_pic) nama_pic,
                                      rv.pic_desc ,
                                      rv.driver_name ,
                                      v.vehicle_name,
                                      rv.vehicle_name type_vehicle,
                                      (SELECT p2.email FROM pegawai p2 WHERE p2.nik = rv.user_req) mail_to,
                                      prm.mail_cc 
                              FROM request_vehicle rv 
                              LEFT JOIN pic_rental_mail prm 
                              ON rv.target_dept = prm.dept
                              INNER JOIN departemen d 
                              ON rv.target_dept = d.id_dept 
                              INNER JOIN vehicle v 
                              ON rv.vehicle = v.id_vehicle 
                              INNER JOIN pegawai p 
                              ON rv.user_req = p.nik 
                              WHERE id_req = '$id'")->row();

    $isiEmail  = "<h1>Request Vehicle (" . $query->id_req . ") Has Been Approved</h1>";
    $isiEmail .= "<div>Request Vehicle with Number " . $query->id_req . " has been approved by " . $query->nama_pic . "</div>";
    $isiEmail .= "<div><b>TNA PORTAL Web Application</b></div>";
    $isiEmail .= '<div>
                    <table>
                      <tbody>
                        <tr>
                          <td>ID Rental</td>
                          <td>:</td>
                          <td>' . $query->id_req . '</td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td>:</td>
                          <td>' . $query->nama . '</td>
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td>:</td>
                          <td>' . $query->email . '</td>
                        </tr>
                        <tr>
                          <td>Vehicle</td>
                          <td>:</td>
                          <td>' . $query->vehicle_name . '</td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>:</td>
                          <td>Approved</td>
                        </tr>
                        <tr>
                          <td>req date</td>
                          <td>:</td>
                          <td>' . $query->req_date . '</td>
                        </tr>
                        <tr>
                          <td>end date</td>
                          <td>:</td>
                          <td>' . $query->end_date . '</td>
                        </tr>
                        <tr>
                          <td>Desc</td>
                          <td>:</td>
                          <td>' . nl2br($query->desc) . '</td>
                        </tr>
                        <tr>
                          <td>Driver Name</td>
                          <td>:</td>
                          <td>' . $query->driver_name . '</td>
                        </tr>
                        <tr>
                          <td>Vehicle Name</td>
                          <td>:</td>
                          <td>' . $query->type_vehicle . '</td>
                        </tr>
                        <tr>
                          <td>PIC Desc</td>
                          <td>:</td>
                          <td>' . nl2br($query->pic_desc) . '</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>';

    $from = $this->settings->info['smtp_user'];
    $to = $query->mail_to;
    $cc = $query->mail_cc;

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama);
    $this->email->to($to);
    $this->email->cc($cc);
    $this->email->subject('New Request Vehicle(' . $query->id_req . ') Has Been Submited');
    $this->email->attach('uploads/' . $query->path_photo);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      $this->session->set_flashdata('status', 'Dikirim');
      redirect('rental');
    } else {
      echo 'Success to send email';
    }
  }

}

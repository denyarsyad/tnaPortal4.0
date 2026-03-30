-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 04:04 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`id_backup`, `file_name`, `file_path`, `created_at`) VALUES
(2, 'backup-20250519-220833.sql.zip', 'files/backup/backup-20250519-220833.sql.zip', '2025-05-19 22:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_dept` int(11) NOT NULL,
  `nama_dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_dept`, `nama_dept`) VALUES
(1, 'Purchasing'),
(2, 'Information Technology'),
(3, 'Maintenance'),
(4, 'Produksi'),
(5, 'QC'),
(6, 'Marketing'),
(7, 'Engineering'),
(8, 'HRGA'),
(9, 'WH'),
(10, 'Finance'),
(11, 'IT'),
(12, 'HSE');

-- --------------------------------------------------------

--
-- Table structure for table `departemen_bagian`
--

CREATE TABLE `departemen_bagian` (
  `id_bagian_dept` int(11) NOT NULL,
  `nama_bagian_dept` varchar(100) NOT NULL,
  `id_dept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departemen_bagian`
--

INSERT INTO `departemen_bagian` (`id_bagian_dept`, `nama_bagian_dept`, `id_dept`) VALUES
(1, 'QA', 5),
(2, 'IT', 2),
(3, 'Tester', 3),
(4, 'Produksi', 4),
(5, 'QC', 5),
(6, 'PPIC', 9),
(7, 'General affair', 8),
(8, 'Warehouse', 9),
(9, 'Marketing', 6),
(10, 'Purchasing', 1),
(11, 'Maintenance', 3),
(12, 'Engineering', 7),
(13, 'Finance', 10),
(14, 'Informasi Teknologi', 11),
(15, 'HSE', 12);

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_informasi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `subject` varchar(35) NOT NULL,
  `pesan` varchar(250) NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_informasi`, `tanggal`, `subject`, `pesan`, `id_user`) VALUES
(1, '2025-05-08 09:58:12', 'Ganti Password', 'Demi keamanan, pengguna sistem diharuskan mengganti password', 'it');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Administrator'),
(2, 'Staf IT'),
(3, 'Leader'),
(4, 'Staf'),
(5, 'Supervisor'),
(6, 'Manager'),
(7, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Repair'),
(2, 'Request'),
(3, 'Fabrikasi'),
(4, 'Support');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sub`
--

CREATE TABLE `kategori_sub` (
  `id_sub_kategori` int(11) NOT NULL,
  `nama_sub_kategori` varchar(35) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_sub`
--

INSERT INTO `kategori_sub` (`id_sub_kategori`, `nama_sub_kategori`, `id_kategori`) VALUES
(15, 'Dies', 3),
(16, 'Jig', 3),
(17, 'Building', 3),
(19, 'Repair Mesin', 1),
(26, 'Mesin', 3),
(27, 'Repair dies', 1),
(28, 'Repair jig', 1),
(29, 'Repair building', 1),
(30, 'Repair pallet', 1),
(31, 'Request', 2),
(32, 'Support', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `lokasi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `lokasi`) VALUES
(1, 'Rull'),
(2, 'Carpet'),
(3, 'NVH'),
(4, 'Office lt 2'),
(5, 'Office Finance'),
(6, 'Aspalt'),
(7, 'Warehouse'),
(8, 'Office warehouse'),
(9, 'Office QC/QA'),
(10, 'Office Produksi'),
(11, 'Felt'),
(12, 'Other\'s');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nik` varchar(50) NOT NULL DEFAULT '',
  `nama` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `telp` char(25) DEFAULT NULL,
  `id_bagian_dept` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nik`, `nama`, `email`, `telp`, `id_bagian_dept`, `id_jabatan`) VALUES
('000521205', 'Malaratina', 'spvwh@tna.co.id', '\'08551788864', 8, 5),
('002611305', 'Yanto', 'maintenance@tna.co.id', '081281816101', 11, 3),
('005711310', 'Irdam setiyoko', 'irdamsetiyoko@gmail.com', '088973188451', 4, 3),
('007811310', 'Ahmad Fauzi', 'ahmadfauzii0309@gmail.com', '08118433239', 4, 3),
('008611410', 'Apip Nurul Hidayat', 'apipnurul94@gmail.com', '081289433245', 4, 3),
('009211410', 'Ridwan Irawan', 'ridwanwan17.ri@gmail.com', '087779232563', 4, 3),
('009611410', 'Yudhi Firmansyah', 'yudi@tna.co.id', '081389156224', 4, 6),
('010411410', 'Kusnun', 'nunkhus92@gmail.com', '081213617012', 4, 3),
('011911410', 'Rustono', 'rustono1994@gmail.com', '085311455549', 4, 3),
('015311410', 'Ega saputra', 'ega6560@gmail.com', '085973142084', 4, 3),
('016911410', 'Restiawan', 'Restiawan99@gmail.com', '089639589586', 4, 3),
('018511410', 'Anang widianto', 'anangwidianto26@gmail.com', '087858015516', 4, 3),
('018611410', 'Setiyadi Wicaksono', 'dhexadhy@gmail.com', '085777790441', 4, 3),
('025511510', 'Endis kosasih', 'Endis.kosasih@yahoo.co.id', '\'085773343033', 4, 3),
('028111510', 'Leonard.A', 'Ardiyanleo@gmail.com', '081284951363', 4, 3),
('038321605', 'Mellia Ristian', 'Meliaristian@gmail.com', '08984445807', 7, 4),
('044811610', 'Iqbal', 'Muhamadiqbal839@gmail.com', '\'085642351572', 4, 3),
('046311610', 'Riky wijayanto', 'rikywijayanto13@gmail.com', '085749818763', 4, 3),
('047511607', 'Rusmara', 'marboy1706@gmail.com', '085714561325', 8, 3),
('050411610', 'Hafizzul Rahman', 'hafiz@tna.co.id', '', 4, 5),
('053811708', 'Wawan Darmawan', 'wawanalvie@gmail.com', '085770885017', 11, 3),
('058711706', 'Casrodin', 'casrodin@tna.co.id', '087788245903', 12, 4),
('072611806', 'Ahmad bahri ', 'ahmadbahri66@gmail.com', '085883702770', 11, 3),
('107512010', 'Yosa Akbar Dirgantoro ', 'yos4akbar99@gmail.com', '081519023019', 4, 3),
('107612010', 'Irvanda Ikhsan Krismanto', 'irvandaikhsan76@gmail.com', '081548177525', 4, 3),
('111012108', 'Eko nur cahyanto', 'ekonurcahyanto64@gmail.com', '085293966440', 11, 7),
('116912108', 'Novananda novela', 'nova60064@gmail.com', '082183897708', 11, 7),
('117112106', 'Rahadian Sahid R', 'rahadian@tna.co.id', '081391192838', 12, 6),
('124312110', 'Ananda anggi putra', 'anggikodeananakbola@gmail.com', '085293472980', 4, 3),
('127012210', 'Higa Bara Swapaksa', 'bongol.rpps@gmail.com', '087834647754', 4, 3),
('127412209', 'Robi Nursikin', 'robi@tna.co.id', '081316623717', 1, 5),
('127912210', 'Muhamad Abdul Rajip', 'Abdulrazip14@gmail.com', '081283787828', 4, 3),
('128012210', 'YOGA ABI SAPUTRO', 'yogaabisaputra1403@gmail.com', '083844106864', 4, 3),
('130312210', 'Rahma Efendi', 'Pendongbarbar123@gmail.com', '082176283405', 11, 7),
('134322209', 'INDRI', 'qc@tna.co.id', '085879794660', 1, 4),
('137412210', 'Arjuna Giri', 'arjunagiri3@gmail.com', '089637743400', 11, 7),
('142612210', 'Juan Alfa A', 'alfsjuan@gmail.com', '085848719901', 4, 3),
('143812308', 'Aji Purnomo', 'ajipurnomo190699@gmail.com', '085729963640', 11, 7),
('144022305', 'Nurima Kurniasari Putri', 'recruitment@tna.co.id', '081219557596', 7, 4),
('144222308', 'Afiatin', 'afiatin98@gmail.com', '085704126151', 11, 5),
('144912308', 'Ardi', 'Ardidabling96@gmail.com', '\'081572252373', 11, 7),
('145012308', 'Husyen A', 'husyenabdullah@gmail.com', '0895359284918', 11, 7),
('145612310', 'Imelda puspita ningrum', 'meldapn024@gmail.com', '082123421341', 4, 3),
('149912308', 'Faiq Rosiawan', 'faiqrosiawan1607@gmail.com', '082132343939', 11, 7),
('154412305', 'Luthfi Naufal', 'luthfinaufalrusdiyanto', '081389156224', 2, 4),
('156312407', 'Rizky Firmansyah', 'rizky@tna.co.id', '082297971706', 8, 6),
('157012409', 'Teguh Dwi martanto', 'd.teguh.martanto.29@gmail.com', '08563653696', 5, 7),
('159812407', 'Irfan Rizaldi', 'warehouse@tna.co.id', '08978116016', 8, 3),
('159912408', 'Marcell', 'marcell@tna.co.id', '081212392808', 11, 6),
('161612408', 'Mulyadi', 'mulyadiezhar@gmail.com', '085691806544', 11, 7),
('161712408', 'Sigit Catur Rahmatullah ', 'sigitcaturrahmatullah@gmail.com', '083124313023', 11, 7),
('162112408', 'Yulius Fendy Pradianto', 'spvmtc@tna.co.di', '\'081336155160', 11, 5),
('162812408', 'Lulel Nur Falah', 'lulel101999@gmail.com', '083879969425', 11, 7),
('162922505', 'Anissa Witasari', 'anissa.witasari@tna.co.id', '081389156224', 7, 6),
('163122511', 'Firstin', 'firstin.kemalasari@tna.co.id', '082143169190', 15, 6),
('281131', 'Safii', 'safii@tna.co.id', '085776072464', 12, 4),
('admin', 'Efedi', '-', '-', 11, 5),
('informasi teknology', 'Luthfi Naufal Rusdiyanto', 'luthfinaufalrusdiyanto@gmail.com', '081389156224', 2, 6),
('it', 'It', 'it@tna.co.id', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prioritas`
--

CREATE TABLE `prioritas` (
  `id_prioritas` int(11) NOT NULL,
  `nama_prioritas` varchar(30) NOT NULL,
  `waktu_respon` int(11) NOT NULL,
  `warna` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prioritas`
--

INSERT INTO `prioritas` (`id_prioritas`, `nama_prioritas`, `waktu_respon`, `warna`) VALUES
(1, 'High', 2, '#F50A12'),
(2, 'Medium', 5, '#FC8500'),
(3, 'Low', 14, '#FFB701');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'app', 'aplikasi', 'Portal', 'Nama Aplikasi', '2025-03-21 09:14:07'),
(2, 'app', 'developer', 'IT TNA 2025', 'Pengembang Aplikasi', '2023-06-17 15:21:28'),
(3, 'app', 'versi', '1.0', 'Versi Aplikasi', '2022-05-19 09:42:25'),
(4, 'general', 'perusahaan', 'PT Tuffindo Nittoku Autoneum', 'Nama Instansi', '2025-02-12 14:24:40'),
(5, 'general', 'alamat', 'Jalan Surya Madya VI Kav. I-46 BC, Kutanegara, Kec. Ciampel Kabupaten Karawang Jawa Barat', 'Alamat', '2025-02-12 14:25:01'),
(6, 'general', 'telepon', '081389156224', 'No Telepon', '2025-02-12 14:25:13'),
(7, 'general', 'email', 'it@tna.co.id', 'Email', '2025-02-12 14:25:22'),
(8, 'image', 'logo', 'kecil.png', 'Logo', '2025-02-12 14:26:11'),
(9, 'email', 'protocol', 'smtp', 'Email Protocol \'mail\', \'sendmail\', or \'smtp\'', NULL),
(10, 'email', 'smtp_host', 'mail.tna.co.id', 'SMTP Host', '2025-02-12 14:26:25'),
(11, 'email', 'smtp_port', '587', 'SMTP Port \'465\' or \'587\'', NULL),
(12, 'email', 'smtp_user', 'it@tna.co.id', 'SMTP User', '2025-02-12 14:26:36'),
(13, 'email', 'smtp_pass', 'Karawang0267!', 'SMTP Password', '2025-05-13 07:23:25'),
(14, 'email', 'smtp_crypto', 'ssl', 'SMTP Crypto', NULL),
(15, 'image', 'background', 'PT-Tuffindo-Nittoku-Autoneum-4-Juni.jpg', 'Background', '2025-02-12 14:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` varchar(50) NOT NULL DEFAULT '',
  `nik` varchar(50) NOT NULL DEFAULT '',
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` varchar(13) NOT NULL DEFAULT '',
  `tanggal` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `tanggal_proses` datetime DEFAULT NULL,
  `tanggal_solved` datetime DEFAULT NULL,
  `reported` varchar(50) NOT NULL DEFAULT '',
  `id_sub_kategori` int(11) NOT NULL,
  `due_date` varchar(10) NOT NULL,
  `problem_summary` varchar(50) NOT NULL DEFAULT '',
  `problem_detail` text NOT NULL,
  `teknisi` varchar(50) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL,
  `progress` decimal(10,0) NOT NULL,
  `filefoto` text NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `id_prioritas` int(11) NOT NULL,
  `assign_to` varchar(100) DEFAULT NULL,
  `user_mail` varchar(100) DEFAULT NULL,
  `mgr_noted` varchar(100) DEFAULT NULL,
  `mgrd_noted` varchar(250) DEFAULT NULL,
  `mgr_id` varchar(250) DEFAULT NULL,
  `mgrd_id` varchar(100) DEFAULT NULL,
  `mgr_date` datetime DEFAULT NULL,
  `mgrd_date` datetime DEFAULT NULL,
  `mgr_reject` varchar(250) DEFAULT NULL,
  `mgr_reject_id` varchar(100) DEFAULT NULL,
  `mgrd_reject` varchar(250) DEFAULT NULL,
  `mgrd_reject_id` varchar(100) DEFAULT NULL,
  `memo_teknisi` varchar(200) DEFAULT NULL,
  `answerfoto` text DEFAULT NULL,
  `user_answer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `tanggal`, `deadline`, `last_update`, `tanggal_proses`, `tanggal_solved`, `reported`, `id_sub_kategori`, `due_date`, `problem_summary`, `problem_detail`, `teknisi`, `status`, `progress`, `filefoto`, `id_lokasi`, `id_prioritas`, `assign_to`, `user_mail`, `mgr_noted`, `mgrd_noted`, `mgr_id`, `mgrd_id`, `mgr_date`, `mgrd_date`, `mgr_reject`, `mgr_reject_id`, `mgrd_reject`, `mgrd_reject_id`, `memo_teknisi`, `answerfoto`, `user_answer`) VALUES
('23y07d6ml', '2025-05-17 10:07:57', '2025-05-22 10:07:57', '2025-05-27 10:01:44', '2025-05-27 10:00:49', '2025-05-27 10:01:44', '011911410', 19, '17-05-2025', 'Rel plat oven POE rul4 rusak, baud penahan lepas ', 'Rel mesin  oven poe rul 4 rusak diarea depan mesin R4A plat  mangap ke atas baud penahan lepas.', '002611305', 7, '100', 'no-image.jpg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('59fCrgiqz', '2025-05-14 08:04:22', '2025-05-16 08:04:22', '2025-05-21 10:22:05', '2025-05-21 10:17:38', '2025-05-21 10:22:05', '159812407', 19, '1 Jam', 'Perbaikan Mesin Cutting Non Woven', 'Mesin Cutting mati, tidak bisa beroperasi', '002611305', 7, '100', 'no-image.jpg', 7, 1, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5JYSlHdwg', '2025-05-14 09:24:12', '2025-05-19 09:24:12', '2025-05-22 10:10:27', '2025-05-22 09:10:24', '2025-05-22 10:10:27', '159812407', 29, '3 Hari', 'Perbaikan Safety Barrier Tiang Gedung Raw Material', 'Perbaikan Safety Barrier tiang gedung diarea Raw Material', '072611806', 7, '100', 'WhatsApp_Image_2025-05-14_at_9_24_33_AM.jpeg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6GnhIZvdJ', '2025-05-15 16:00:27', '2025-05-29 16:00:27', '2025-05-22 10:08:31', '2025-05-22 09:10:37', '2025-05-22 10:08:31', '159812407', 16, '7 Hari', 'Pembuatan Trolley', 'Pembuatan Trolley baru Sparepart, Spec ada dilampiran', '072611806', 6, '100', 'WhatsApp_Image_2025-05-15_at_4_00_30_PM_(1).jpeg', 7, 3, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6hFuTNCqb', '2025-05-15 13:59:06', '2025-05-17 13:59:06', '2025-05-22 10:18:00', '2025-05-21 10:22:41', '2025-05-22 10:18:00', '047511607', 30, '0', 'Repair pallet reguler', 'Palet sudah direpair tanggal 14 Mei 2025', '072611806', 7, '100', 'IMG-20250515-WA0022.jpg', 7, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8VRwfx35B', '2025-06-09 01:12:28', NULL, '2025-06-10 14:33:05', NULL, NULL, '005711310', 19, '2025-06-10', 'Penggantian teflon', 'Penggantian teflon meja heater D, sudah rusak dan tidak nempel', '', 9, '0', 'IMG_20250609_011249.jpg', 1, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9nkcvIfKC', '2025-06-08 20:57:47', '2025-06-13 20:57:47', '2025-06-16 16:27:19', '2025-06-16 16:20:03', '2025-06-16 16:27:19', '044811610', 26, '2025-06-08', 'Perbaikan baut pagar mesin andon NVH depan', 'Baut danabolt pagar mesin andon NVH depan lepas , repiar / ganti dengan yang baru agar pagar tidak geser ', '072611806', 7, '100', 'WhatsApp_Image_2025-06-08_at_20_55_58.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di perbaiki', NULL, NULL),
('APwb3cUNX', '2025-05-18 15:37:13', '2025-06-01 15:37:13', '2025-06-02 14:07:45', '2025-05-22 14:37:42', '2025-06-02 14:07:45', '018611410', 31, '1 minggu', 'Penambahan tombol ', 'Penambahan tombol auto stop mesin forming Felt di panel mesin Cutting', '053811708', 7, '100', 'WhatsApp_Image_2025-05-18_at_15_33_05.jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BQEDi3NCJ', '2025-06-08 12:24:36', NULL, '2025-06-08 12:24:36', NULL, NULL, '058711706', 15, '2025-06-08', 'Perbaikan dies', 'Perbaikan dies', '', 8, '0', 'Screenshot_2025-04-21_1307322.png', 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('GJhLgziSv', '2025-05-19 23:38:57', NULL, '2025-05-22 15:35:27', NULL, NULL, '127012210', 26, '14 hari', 'Inter lock', 'Pembuatan inter lock pada pintu slitter forming', '', 0, '0', 'WhatsApp_Image_2025-05-07_at_15_32_20.jpeg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('ipIowdx76', '2025-05-19 14:32:56', '2025-05-24 14:32:56', '2025-06-02 14:16:32', '2025-06-02 14:09:03', '2025-06-02 14:16:32', '154412305', 31, '2 hari', 'Support IT', 'Support pemasangan cctv area project gedung baru', '053811708', 7, '100', 'OIP1.jpg', 12, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('kxRiG98sH', '2025-05-19 14:34:09', '2025-06-02 14:34:09', '2025-05-22 08:58:48', '2025-05-22 08:57:10', '2025-05-22 08:58:48', '154412305', 31, '2 hari', 'Support IT', 'Pergantian mesin absen di area kantin', '053811708', 6, '100', 'OIP_(1).jpg', 12, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('L9hYb0s6a', '2025-05-17 10:44:06', '2025-05-31 10:44:06', '2025-05-27 09:56:37', '2025-05-27 09:55:20', '2025-05-27 09:56:37', '159812407', 19, '1 Hari', 'Instalasi Mesin Cutting Non Woven (URGENT)', 'Mesin sudah ada di Sparepart, untuk rel tetap menggunakan rel existing. Hanya diganti kelengkapan rel nya menggunakan yang baru (URGENT)', '002611305', 6, '100', 'no-image.jpg', 7, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('LgY2CxHy6', '2025-05-14 09:22:46', '2025-05-19 09:22:46', '2025-05-21 15:25:05', '2025-05-21 15:19:17', '2025-05-21 15:25:05', '159812407', 19, '1 Hari', 'Pelepasan lampu indikator pada timbangan Raw Mater', 'Lampu Indikator dilepas', '053811708', 7, '100', 'WhatsApp_Image_2025-05-14_at_9_23_32_AM.jpeg', 7, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('lm18giv3H', '2025-05-19 23:44:16', '2025-06-02 23:44:16', '2025-05-26 09:16:05', '2025-05-26 08:36:30', '2025-05-26 09:16:05', '127012210', 26, '14 hari', 'Cover', 'Pembuatan cover pada roller mesin blending', '072611806', 6, '100', 'WhatsApp_Image_2025-05-19_at_23_45_06.jpeg', 11, 3, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('LWhRZxB5j', '2025-05-19 23:40:04', NULL, '2025-05-22 15:35:07', NULL, NULL, '127012210', 26, '14 hari', 'Inter lock', 'Penambahan inter lock pada pintu slitter cutting', '', 0, '0', 'WhatsApp_Image_2025-05-07_at_15_32_51.jpeg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('oe9iHGa8N', '2025-05-15 15:59:11', '2025-05-29 15:59:11', '2025-05-26 09:53:20', '2025-05-26 09:52:17', '2025-05-26 09:53:20', '159812407', 29, '3 Hari', 'Penggantian Stopkontak Sparepart Room', 'Stopkontak existing kendor, aliran listrik putus nyambung', '053811708', 6, '100', 'WhatsApp_Image_2025-05-15_at_4_00_30_PM.jpeg', 7, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('oj0lNE5PA', '2025-05-19 13:06:00', '2025-05-24 13:06:00', '2025-05-26 08:54:10', '2025-05-22 09:10:31', '2025-05-26 08:54:10', '145612310', 27, '1 minggu', 'Repair Hole Dies OUTER No 2', 'Repair area yang kurang motong sesuai gambar terlampir.', '072611806', 7, '100', '36b58191-349e-449e-9e1e-b12710f7f2ac.jpg', 3, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('PZgdESB3n', '2025-06-08 20:38:35', NULL, '2025-06-16 14:38:34', NULL, NULL, '005711310', 29, '2025-06-09', 'Perbaikan lampu gedung mati', 'Antara rul 2 dan rul 3,', '', 5, '0', 'IMG_20250608_204051.jpg', 1, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('q6l3YrxVE', '2025-06-08 14:04:30', NULL, '2025-06-08 14:04:31', NULL, NULL, '058711706', 17, '2025-06-08', '(URGENT) Relayout Area Tim Delivery. Mohon dikerja', '(URGENT) Relayout Area Tim Delivery. Mohon dikerjakan saat Hari Minggu', '', 8, '0', 'Screenshot_2025-04-24_111044.png', 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('rKQqX6zhk', '2025-05-14 15:25:04', '2025-05-16 15:25:04', '2025-05-22 10:19:09', '2025-05-21 10:23:05', '2025-05-22 10:19:09', '047511607', 30, '0', 'Repair pallet reguler', 'Palet sudah di repair tanggal 13 Mei 2025', '072611806', 7, '100', 'IMG-20250514-WA0020.jpg', 7, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('rnMI8Wtwg', '2025-05-14 10:13:17', NULL, '2025-05-14 14:19:15', NULL, NULL, '015311410', 19, '14/5/25', 'Penggantian tombol emergency oven 3 dan penggantia', 'Tombol emergency oven 3 berpotensi terkena badan di karnakan posisi menonjol ke depan', '', 0, '0', 'no-image.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('wGSHK7Dk0', '2025-05-14 10:13:19', '2025-05-28 10:13:19', '2025-06-04 08:41:51', '2025-06-04 08:40:44', '2025-06-04 08:41:51', '015311410', 19, '14/5/25', 'Penggantian tombol emergency oven 3 dan penggantia', 'Tombol emergency oven 3 berpotensi terkena badan di karnakan posisi menonjol ke depan', '002611305', 7, '100', 'no-image.jpg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20250RN', '2025-06-17 03:21:06', '2025-06-22 03:21:06', '2025-06-17 18:34:09', NULL, NULL, '127912210', 28, '2025-06-04', 'Perbaikan roda jig waiting d26a rul 2', 'Roda pada jig D26A lepas 1 pcs dan bengkok 1 pcs total 2 roda butuh perbaikan pergantian roda yang baru (pemasangan roda baru pada jig tersebut)', '072611806', 3, '0', 'WhatsApp_Image_2025-06-17_at_03_19_59.jpeg', 1, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20250SU', '2025-06-13 14:35:03', NULL, '2025-06-16 16:11:20', NULL, NULL, '159812407', 19, '2025-06-27', 'URGENT! PERBAIKAN POMPA HYDRAULIC WING BOX TRUCK', 'PLAT NO : T 8518 FL', '', 8, '0', 'WhatsApp_Image_2025-06-13_at_9_46_44_AM.jpeg', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20251HN', '2025-06-02 21:38:47', '2025-06-07 21:38:47', '2025-06-05 13:34:07', NULL, NULL, '018611410', 19, '2025-06-02', 'Perbaikan tirai', 'Tirai belakang oven 3 rusak', '002611305', 3, '0', 'WhatsApp_Image_2025-06-02_at_21_28_39_(1).jpeg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20251LU', '2025-06-02 17:04:45', '2025-06-07 17:04:45', '2025-06-09 14:55:09', '2025-06-09 10:43:03', '2025-06-09 14:55:09', '005711310', 19, '2025-06-09', 'Heater D', 'Perbaikan dudukan tombol patah', '072611806', 7, '100', 'IMG_20250602_122147.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20251SX', '2025-06-09 13:04:16', '2025-06-11 13:04:16', '2025-06-16 16:26:36', '2025-06-16 16:20:33', '2025-06-16 16:26:36', '018511410', 31, '2025-06-09', 'Perubahan posisi tangga, melebarkan pagar dan mera', 'Tangga diposisikan kesamping agar tidak mengganggu MP calenderoll, pagar dilebarkan agar muat untuk pejalan kaki dan merapikan ram besi yang beberapa potongannya sedikit tajam, berpotensi tangan tergores saat memegang pagar', '072611806', 7, '100', 'WhatsApp_Image_2025-06-09_at_12_53_36.jpeg', 6, 1, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di rubah posisi tangga', NULL, NULL),
('WO20252FE', '2025-06-11 12:33:55', '2025-06-25 12:33:55', '2025-06-13 09:10:02', NULL, NULL, '159812407', 30, '2025-06-25', 'Repair dan Modifikasi Pallet Recycle Asphalt', 'Repair Pallet NG Recycle Asphalt dan melakukan modifikasi pallet existing', '072611806', 3, '0', 'Screenshot_2025-06-11_123541.png', 7, 3, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20252TF', '2025-06-11 13:33:09', NULL, '2025-06-11 13:33:09', NULL, NULL, '134322209', 31, '2025-06-18', 'Preventive maintenance chamber ', 'Preventive maintenance chamber ', '', 1, '0', 'WhatsApp_Image_2025-06-11_at_13_36_31.jpeg', 9, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20252Y9', '2025-05-22 11:02:16', NULL, '2025-05-22 15:26:26', NULL, NULL, '145612310', 31, '2025-05-25', 'Pemindahan panel yg sudah tidak diperlukan ', 'Pemindahan panel oven yang sudah tidak diperlukan/difungsikan', '', 0, '0', 'no-image.jpg', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO202550M', '2025-06-17 11:19:24', NULL, '2025-06-17 15:11:40', NULL, NULL, '047511607', 30, '2025-07-01', 'Repair pallet reguler', 'Palet NG return customer tanggal 13 & 16 Juni 2025', '', 8, '0', 'Screenshot_2025-06-17_111652.png', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO202551F', '2025-06-02 21:34:10', '2025-06-16 21:34:10', '2025-06-05 15:06:12', NULL, NULL, '018611410', 29, '2025-06-02', 'Perbaikan lampu gedung', 'Lampu gedung diantara RUL 2 dan RUL 3 mati 2 pcs', '053811708', 5, '0', 'WhatsApp_Image_2025-06-02_at_21_28_35.jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20255IS', '2025-06-02 08:37:45', '2025-06-07 08:37:45', '2025-06-14 13:22:38', '2025-06-13 15:19:02', '2025-06-14 13:22:38', '047511607', 30, '2025-06-20', 'Repair pallet reguler', 'Palet NG return Customer tanggal 28 Mei 2025', '072611806', 7, '100', 'Screenshot_2025-06-02_083316.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO20256EV', '2025-05-21 02:40:07', '2025-05-26 02:40:07', '2025-05-26 08:55:19', '2025-05-26 08:37:03', '2025-05-26 08:55:19', '011911410', 19, '2025-05-20', 'Plat bantalan rel oven poe rusak ', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '072611806', 6, '100', 'WhatsApp_Image_2025-05-21_at_02_32_532.jpeg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20256K5', '2025-06-02 17:07:39', '2025-06-07 17:07:39', '2025-06-09 19:07:33', '2025-06-09 15:26:25', '2025-06-09 19:07:33', '005711310', 19, '2025-06-09', 'Melepas dudukan kipas', 'Melepas dudukan kipas yg sudah tidak terpakai ( R1B,R1C,R4C,R4B)', '072611806', 7, '100', 'IMG_20250602_121714.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20256RW', '2025-05-22 13:47:30', '2025-06-05 13:47:30', '2025-06-09 13:42:21', '2025-06-09 13:36:47', '2025-06-09 13:42:21', '145612310', 31, '2025-05-25', 'Pemindahan posisi pipa vacum wj ', 'Pemindahan posisi vacum wj,tabung angin dan mc shimizu ke dekat conveyor yang bertujuan untuk akses jalan saat produksi berlangsung', '002611305', 7, '100', 'WhatsApp_Image_2025-05-22_at_10_02_07.jpeg', 2, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20256TP', '2025-05-27 11:15:41', '2025-06-01 11:15:41', '2025-06-09 16:19:42', '2025-06-09 15:23:33', '2025-06-09 16:19:42', '128012210', 26, '2025-05-27', 'Perbaikan kipas stand nvh depan (baling baling dan', 'Perbaikan baling baling dan kaki kaki kipas stand nvh depan', '072611806', 7, '100', 'WhatsApp_Image_2025-05-27_at_09_24_26.jpeg', 3, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20256UU', '2025-06-12 16:08:44', '2025-06-26 16:08:44', '2025-06-16 08:43:37', NULL, NULL, '159812407', 17, '2025-06-26', 'Pembuatan Rak Output Cutting Non Woven (2 Pcs)', 'Jumlah 2 Biji, Ukuran detail request to rizaldi. Material sudah Ready.', '072611806', 3, '0', 'Screenshot_2025-06-12_161020.png', 7, 3, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20257DZ', '2025-06-13 08:01:02', '2025-06-27 08:01:02', '2025-06-17 18:42:25', NULL, NULL, '159812407', 17, '2025-06-30', 'Pembuatan Hanging Rak Remaining Cutting Non Woven', 'Pengubahan Hanging Rak dari Horizontal ke Vertikal untuk Optimasi Area. Ukuran detail langsung diskusi dengan Rizaldi. Material sudah siap', '072611806', 3, '0', 'Screenshot_2025-06-13_080048.png', 7, 3, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20257JR', '2025-05-26 15:41:38', '2025-06-09 15:41:38', '2025-06-02 10:50:17', NULL, NULL, '159812407', 32, '2025-06-02', 'Pengecekan Charger Forklift WH04 dan Kalibrasi Bat', 'Mohon support untuk pengecekan Ampere pada Charger Forklift WH04 dan Kalibrasi indikator Baterai pada Forklift WH04', '053811708', 3, '0', 'no-image.jpg', 7, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20257NY', '2025-05-26 15:40:19', '2025-05-31 15:40:19', '2025-06-09 16:20:42', '2025-06-09 16:17:33', '2025-06-09 16:20:42', '159812407', 32, '2025-06-02', 'Pemasanga Address Layout Raw Material', 'Address sudah tersedia di area Raw Material', '072611806', 7, '100', 'WhatsApp_Image_2025-05-26_at_3_40_35_PM.jpeg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20257UH', '2025-06-02 21:30:49', '2025-06-04 21:30:49', '2025-06-09 14:43:17', '2025-06-09 14:38:19', '2025-06-09 14:43:17', '018611410', 19, '2025-06-02', 'Perbaikan tampungan oli slide', 'Tampungan oli slide mesin R3B rusak', '072611806', 7, '100', 'WhatsApp_Image_2025-06-02_at_21_28_42.jpeg', 1, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20257Y6', '2025-05-27 10:27:10', '2025-06-01 10:27:10', '2025-06-14 13:23:22', '2025-06-13 15:18:07', '2025-06-14 13:23:22', '047511607', 30, '2025-07-06', 'Repair pallet reguler', 'Palet NG return Customer tanggal 26 mei 2025', '072611806', 7, '100', 'Screenshot_2025-05-27_102138.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di perbaiki', NULL, NULL),
('WO202587L', '2025-06-02 21:44:44', '2025-06-07 21:44:44', '2025-06-16 19:38:50', '2025-06-16 16:21:38', '2025-06-16 19:38:50', '018611410', 31, '2025-06-02', 'Penambahan pintu pada pagar samping oven 4', 'Penambahan pintu pada pagar samping oven 4. Kondisi saat ini jika terdapat material gagal feeding, operator harus masuk ke bagian bawah oven untuk mengambil material yang jatuh sehingga kurang safety.', '072611806', 7, '100', 'WhatsApp_Image_2025-06-02_at_21_28_35_(2).jpeg', 1, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di modifikasi tambahkan pintu', NULL, NULL),
('WO20258E5', '2025-06-09 10:57:23', '2025-06-23 10:57:23', '2025-06-09 19:04:29', NULL, NULL, '163122511', 31, '2025-06-16', 'Perbaikan Jalur Electrical (kabel di meja assembly', 'Kabel berserakan di area kerja, dan ada bagian kabel terkelupas yg diisolasi.\r\n1. Buatkan tempat jalur kabel yang fix di area meja kerja\r\n2. Buatkan saklar yang fix di area meja kerja dengan dibantali isolator dari kayu. (Saklar-Kayu-Besi)\r\n3. Buatkan semacam roll atau tempat menggantungkan sisa kabel\r\n', '002611305', 3, '0', 'WhatsApp_Image_2025-06-09_at_09_31_30.jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20258EE', '2025-06-02 16:51:28', NULL, '2025-06-05 10:57:31', NULL, NULL, '005711310', 16, '2025-06-09', 'Modifikasi troley', 'Troley di buat tinggi seperti meja troley yg sudah ada / yg lain nya', '', 10, '0', 'IMG_20250602_130215.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20258FL', '2025-06-14 10:17:21', '2025-06-19 10:17:21', '2025-06-17 19:00:42', NULL, NULL, '018511410', 26, '2025-06-14', 'Melebarkan talang/tampungan resin', 'Bagian bawah conveyor coating, talang/tampungan kurang lebar, resin menetes kelantai', '072611806', 3, '0', 'WhatsApp_Image_2025-06-14_at_09_45_58.jpeg', 6, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20259DY', '2025-06-12 09:43:51', NULL, '2025-06-12 09:43:51', NULL, NULL, '038321605', 32, '2025-06-12', 'Acrilic area merokok pecah dan keluar dari tempatn', 'Tolong dibantu ya team MTC, terkait acrilic area merokok pecah dan keluar dari tempatnya. Terima kasih banyak.', '', 8, '0', 'acrilic_area_merokok.jpg', 12, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO20259ED', '2025-05-27 10:34:09', '2025-06-01 10:34:09', '2025-06-02 10:47:54', NULL, NULL, '047511607', 31, '2025-02-06', 'Pembuatan sekat box Hood SU2ID FL', 'Sekat box Hood su2id fl 6 pcs untuk pengganti sekat box yang NG return customer', '072611806', 3, '0', 'IMG20250527092220.jpg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025A6L', '2025-05-22 13:49:06', '2025-06-05 13:49:06', '2025-05-27 09:59:43', '2025-05-27 09:55:38', '2025-05-27 09:59:43', '145612310', 31, '2025-05-25', 'Pembongkaran mesin', 'Pembongkaran/pemindahan mesin yang sudah tidak digunakan (panel oven carpet)', '002611305', 6, '100', 'WhatsApp_Image_2025-05-22_at_11_00_00.jpeg', 2, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025A8G', '2025-05-21 15:44:17', '2025-05-26 15:44:17', '2025-05-26 09:04:59', '2025-05-26 08:36:59', '2025-05-26 09:04:59', '159812407', 29, '2025-05-23', 'Repair Kaki Rak WIP', 'Repair Kaki Rak WIP Carpet', '072611806', 6, '100', 'WhatsApp_Image_2025-05-19_at_3_25_09_PM.jpeg', 2, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025ACC', '2025-06-17 07:31:36', NULL, '2025-06-17 11:07:32', NULL, NULL, '005711310', 28, '2025-06-24', 'Pemindahan posisi panel', 'Posisi panel berada di bawah sehingga sedikit menyulitkan saat cek jig, dan panel juga cepat kotor debu \r\n\r\nNote: di rubah posisi panel seperti jig liner 5j45 ', '', 9, '0', 'IMG_20250617_072920.jpg', 1, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025AXM', '2025-06-16 07:50:40', NULL, '2025-06-16 16:11:02', NULL, NULL, '159812407', 31, '2025-06-18', 'URGENT CUSTOMER FINDING MODIFIKASI BOX', 'Modifikasi Box Hood MMKI untuk delivery Hood YHA ke Tambun, dengan menambahkan sekat menggunakan Impraboard untuk setiap part. Detail modifikasi disscuss dengan Rizaldi. Attachment merupakan foto Temporary Packing Method', '', 8, '0', 'WhatsApp_Image_2025-06-16_at_7_43_02_AM_(1).jpeg', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025BKE', '2025-06-09 09:04:57', '2025-06-14 09:04:57', '2025-06-09 19:01:35', NULL, NULL, '154412305', 32, '2025-06-11', 'Support pemasangan cctv area gedung baru', 'Support pemasangan cctv area gedung baru', '053811708', 3, '0', 'WhatsApp_Image_2025-06-09_at_09_08_25.jpeg', 12, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025BLV', '2025-06-09 16:51:33', NULL, '2025-06-16 14:33:37', NULL, NULL, '011911410', 31, '2025-09-06', 'Lampu penerangan utama di belakang oven 7 kondisi ', 'Pergantian lampu penerangan utama rul 4 di atas oven 7 ', '', 5, '0', 'WhatsApp_Image_2025-06-09_at_14_01_33.jpeg', 1, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025BSV', '2025-06-02 21:32:10', '2025-06-16 21:32:10', '2025-06-09 13:54:17', '2025-06-09 13:53:36', '2025-06-09 13:54:17', '018611410', 19, '2025-06-02', 'Perbaikan lampu mesin R3C', 'Lampu bagian atas mesin R3C redup ', '002611305', 6, '100', 'WhatsApp_Image_2025-06-02_at_21_28_41_(1).jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025C9B', '2025-06-12 03:08:26', '2025-06-17 03:08:26', '2025-06-16 14:31:16', NULL, NULL, '005711310', 31, '2025-06-19', 'Pemindahan legran hotmelt', 'Pmindahan legra  mesin hotmelt / gluroll karena kebutuhan flow proses,\r\n- R1A pindah R1B\r\n- R2A pindah R2B\r\n- R3A pindah R3B', '002611305', 3, '0', 'IMG_20250612_030848.jpg', 1, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025C9Z', '2025-05-27 11:13:32', '2025-06-01 11:13:32', '2025-06-09 19:08:30', '2025-06-09 19:06:20', '2025-06-09 19:08:30', '128012210', 17, '2025-05-27', 'Perbaikan pagar kuning matrial/palet F/G di nvh de', 'Perbaikkan pagar kuning suplay matrial dan palet F/G di NVH DEPAN', '072611806', 7, '100', 'WhatsApp_Image_2025-05-27_at_09_23_43.jpeg', 3, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CB0', '2025-05-27 13:24:53', '2025-06-01 13:24:53', '2025-06-04 16:08:04', '2025-06-04 15:57:25', '2025-06-04 16:08:04', '159812407', 30, '2025-09-30', 'Pallet ISUZU', 'Modifikasi Pallet Asphalt HMMI untuk Project ISUZU', '072611806', 7, '100', 'no-image.jpg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CGI', '2025-05-23 01:33:11', '2025-06-06 01:33:11', '2025-05-23 09:53:57', NULL, NULL, '107612010', 19, '2025-05-22', 'Perbaikan kipas meja inpeksi N5 dan N6', 'Perbaikan/pergantian kipas meja inpeksi N5 depan mati 1 pcs\r\nPerbaikan kipas meja inpeksi N6 belakang rusak ( baling baling lepas )', '002611305', 3, '0', 'WhatsApp_Image_2025-05-23_at_01_31_08_(1).jpeg', 3, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CGN', '2025-06-16 03:22:16', '2025-06-21 03:22:16', '2025-06-16 14:29:26', NULL, NULL, '107612010', 19, '2025-06-15', 'Perbaikan oli slide N5 tidak keluar', 'Perbaikan oli slide N5n bagian depan 2 titik tidak keluar ( tampungan oli kering )', '002611305', 3, '0', 'WhatsApp_Image_2025-06-16_at_03_22_32.jpeg', 3, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025COT', '2025-05-22 03:49:51', '2025-05-27 03:49:51', '2025-05-26 09:08:20', '2025-05-26 08:36:43', '2025-05-26 09:08:20', '018511410', 31, '2025-05-21', 'Penambahan plat/impraboard', 'Diantara mesin k.600 dan k.110, menutup celah agar material tidak masuk dan memudahkan saat cleaning\r\n', '072611806', 12, '100', 'WhatsApp_Image_2025-05-21_at_22_54_09.jpeg', 6, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CPW', '2025-06-10 15:51:36', '2025-06-15 15:51:36', '2025-06-16 14:28:32', NULL, NULL, '025511510', 19, '2025-06-10', 'Perbaikan selang hidraulik forklif 10 TON', 'Selang bagian geser garpu  forklif 10 TON bocor sehingga oli hidraulik cepas habis dan oli berceceran di lantai.', '053811708', 3, '0', 'WhatsApp_Image_2025-06-10_at_15_54_31.jpeg', 12, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CTD', '2025-06-13 15:32:27', NULL, '2025-06-17 15:10:00', NULL, NULL, '128012210', 27, '2024-06-13', 'Repair dies outer no 3', 'Repair cutting in line outer no 3 cavity 2.', '', 9, '0', 'WhatsApp_Image_2025-06-13_at_15_10_27.jpeg', 3, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025CUT', '2025-06-10 08:39:57', '2025-06-15 08:39:57', '2025-06-17 11:15:34', '2025-06-16 09:54:04', '2025-06-17 11:15:34', '047511607', 30, '2025-06-24', 'Repair pallet reguler', 'Palet NG return customer tanggal 09 juni 2025', '072611806', 7, '100', 'Screenshot_2025-06-10_083815.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO2025CVN', '2025-06-09 10:59:32', '2025-06-14 10:59:32', '2025-06-10 16:14:38', '2025-06-10 16:12:30', '2025-06-10 16:14:38', '018511410', 31, '2025-06-09', 'Modifikasi cover mesin press continue', 'Cover kurang pas/masih ada celah potensi tangan masuk dan cover riskan tersenggol anggota tubuh', '072611806', 12, '100', 'WhatsApp_Image_2025-06-09_at_10_18_19.jpeg', 6, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025D5J', '2025-06-09 17:11:57', NULL, '2025-06-09 17:11:57', NULL, NULL, '038321605', 32, '2025-06-09', 'Perapian kabel', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '', 8, '0', 'kabel_11.jpg', 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025DIQ', '2025-06-05 09:23:47', '2025-06-10 09:23:47', '2025-06-13 08:50:07', NULL, NULL, '047511607', 31, '2025-06-05', 'Pembuatan sekat outer YHA', 'Pembuatan sekat karpet untuk palet Outer YHA', '072611806', 3, '0', 'no-image.jpg', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025DNP', '2025-06-05 09:20:51', '2025-06-10 09:20:51', '2025-06-14 13:24:43', '2025-06-13 15:19:52', '2025-06-14 13:24:43', '047511607', 30, '2025-06-19', 'Repair pallet reguler', 'Palet NG return customer tanggal 03-04 Juni 2025', '072611806', 7, '100', 'Screenshot_2025-06-05_091604.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO2025DS9', '2025-05-20 15:52:22', NULL, '2025-05-22 15:32:02', NULL, NULL, '145612310', 31, '2025-05-27', 'Pemasangan Interloc', 'Pemasangan Interloc di pagar area cutting FELT', '', 0, '0', '50f76ccf-20fb-4be2-8e3d-912cf39d31bb.jpg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025DWN', '2025-06-13 08:31:15', '2025-06-18 08:31:15', '2025-06-17 18:46:03', NULL, NULL, '127912210', 31, '2025-06-13', 'Pembuatan tangki penampung ili slide dimesin R1b b', 'Request pembuatan kembali tangki penampungan oli untuk dimesin R1B bagian luar yang hilang ', '072611806', 3, '0', 'WhatsApp_Image_2025-06-13_at_08_33_06.jpeg', 1, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025DXT', '2025-05-21 15:46:20', '2025-05-26 15:46:20', '2025-05-26 09:47:23', '2025-05-26 08:36:54', '2025-05-26 09:47:23', '159812407', 29, '2025-05-26', 'Adjustment Arah Convex Mirror', 'Convex Mirror dilakukan adjustment menghadap kearah Carpet', '072611806', 6, '100', 'WhatsApp_Image_2025-05-19_at_3_49_48_PM.jpeg', 3, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025E1L', '2025-05-28 10:15:48', NULL, '2025-06-02 10:43:52', NULL, NULL, '047511607', 31, '2025-05-28', 'Tali Carpet', 'Kebutuhan untuk tali packing palet produksi hari ini \r\n100 pcs', '', 0, '0', 'no-image.jpg', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025FES', '2025-06-09 17:11:54', NULL, '2025-06-09 17:11:54', NULL, NULL, '038321605', 32, '2025-06-09', 'Perapian kabel', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '', 8, '0', 'kabel_1.jpg', 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025FGZ', '2025-05-22 16:25:34', '2025-05-27 16:25:34', '2025-05-23 09:41:18', NULL, NULL, '159812407', 32, '2025-05-25', '(URGENT) Relayout Area Tim Delivery. Mohon dikerja', 'Relayout Area Tim Delivery :\r\n1. Instalasi Listrik\r\n2. Pemasangan Papan Kuning pada Tembok', '072611806', 3, '0', 'Screenshot_2025-05-22_162651.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025FWA', '2025-05-27 10:33:20', '2025-05-29 10:33:20', '2025-06-16 19:37:06', '2025-06-16 09:58:27', '2025-06-16 19:37:06', '128012210', 27, '2025-05-27', 'Repair dies hood 2vf cavity 1', 'Repair dies hood 2vf cavity 1', '072611806', 7, '100', 'WhatsApp_Image_2025-05-27_at_09_23_43_(1).jpeg', 3, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di repair hari sabtu tgl 14/6/2025', NULL, NULL),
('WO2025GGY', '2025-06-11 14:47:15', '2025-06-16 14:47:15', '2025-06-17 11:18:50', '2025-06-16 09:49:11', '2025-06-17 11:18:50', '047511607', 30, '2025-06-25', 'Repair pallet reguler', 'Palet NG return Customer tanggal 10 juni 2025', '072611806', 7, '100', 'Screenshot_2025-06-11_144438.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di repair', NULL, NULL),
('WO2025GZE', '2025-06-17 01:14:36', NULL, '2025-06-17 11:08:56', NULL, NULL, '128012210', 17, '2025-06-16', 'Pergantian lampu gedung di nvh depan', 'Lampu gedung nvh depan kondisi menyala tetapi redup. pencahyaan area nvh jadi kurang maksimal', '', 9, '0', 'WhatsApp_Image_2025-06-17_at_01_12_13.jpeg', 3, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025H7H', '2025-06-14 10:21:44', NULL, '2025-06-17 15:08:12', NULL, NULL, '018511410', 31, '2025-06-14', 'Pindah power listrik cctv dan lampu k.1500', 'Power sebelumnya dari panel conveyor recycle, dipindah kepanel calenderoll, agar teteap stand by sampai akhir shift, karena jika dari panel conveyor recycle, 1 jam sebelum pulang sudah mati.', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_09_48_51.jpeg', 6, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025HFB', '2025-06-11 09:06:06', '2025-06-16 09:06:06', '2025-06-16 14:33:01', NULL, NULL, '128012210', 19, '2025-06-11', 'Perbaikan blower dinding kecil kecil ', 'Blower dinding yang kecil kecil  dibagian atas mesin N1 dan N2 mati, ', '053811708', 3, '0', 'WhatsApp_Image_2025-06-10_at_14_20_18.jpeg', 3, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025HQQ', '2025-06-02 17:48:26', '2025-06-16 17:48:26', '2025-06-05 13:38:12', NULL, NULL, '005711310', 31, '2025-06-09', 'Perapian kabel R1C ', 'Kabel tidak rapi dan melambai', '002611305', 3, '0', 'IMG_20250602_123348.jpg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025HSB', '2025-05-20 15:52:34', NULL, '2025-05-22 15:29:54', NULL, NULL, '145612310', 31, '2025-05-27', 'Pemasangan Interloc', 'Pemasangan Interloc di pagar area cutting FELT', '', 0, '0', '50f76ccf-20fb-4be2-8e3d-912cf39d31bb2.jpg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025HX7', '2025-05-26 10:02:50', '2025-05-31 10:02:50', '2025-06-05 14:14:51', NULL, NULL, '047511607', 30, '2025-07-06', 'Repair pallet reguler', 'Palet NG penuh sudah tidak ada area untuk penyimpanan\r\nPalet NG saat ini ada di Area :\r\n1.samping gudang solar\r\n2.depam gudang solar', '072611806', 3, '0', 'IMG-20250523-WA0082.jpg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025IFP', '2025-06-07 13:37:56', '2025-06-12 13:37:56', '2025-06-17 15:56:25', '2025-06-17 11:41:28', '2025-06-17 15:56:25', '009211410', 27, '2025-06-07', 'Perbaikan Dies Hood 5h45', 'Perbaikan dies hood 5h45 cavity 1 bagian belakang ,ada seperti garis bekas lalasan ,dan timbul garis di part', '072611806', 7, '100', 'WhatsApp_Image_2025-06-07_at_13_38_50.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di grinding finishing', NULL, NULL),
('WO2025IQ8', '2025-06-12 13:15:56', '2025-06-26 13:15:56', '2025-06-16 14:30:20', NULL, NULL, '154412305', 32, '2025-06-12', 'Support IT mengaktifkan cctv area workshop mainten', 'Support IT mengaktifkan cctv area workshop maintennce', '053811708', 3, '0', 'OIP6.jpg', 12, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025IYU', '2025-06-09 15:18:22', '2025-06-14 15:18:22', '2025-06-13 10:30:36', '2025-06-13 10:19:35', '2025-06-13 10:30:36', '018511410', 30, '2025-06-09', 'Penggantian roda trolly blown asphalt', 'Roda rusak ', '072611806', 12, '100', 'WhatsApp_Image_2025-06-09_at_14_59_38.jpeg', 6, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025J4R', '2025-06-02 21:36:37', '2025-06-16 21:36:37', '2025-06-05 15:06:28', NULL, NULL, '018611410', 29, '2025-06-02', 'Perbaikan lampu', 'Lampu gedung diarea pojok RUL 1 (Gerbang baru) mati 1', '053811708', 5, '0', 'WhatsApp_Image_2025-06-02_at_21_28_38.jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025J8S', '2025-06-02 21:37:38', '2025-06-07 21:37:38', '2025-06-09 13:46:06', '2025-06-09 13:43:43', '2025-06-09 13:46:06', '018611410', 19, '2025-06-02', 'Perbaikan lampu', 'Lampu mesin bagian dalam R2A mati 2 ', '002611305', 7, '100', 'WhatsApp_Image_2025-06-02_at_21_28_40.jpeg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025JIL', '2025-05-21 23:32:09', '2025-06-04 23:32:09', '2025-06-04 08:46:47', '2025-06-02 14:08:40', '2025-06-04 08:46:47', '018511410', 31, '2025-05-21', 'Penambahan tombol emergency ', 'Untuk mempermudah jika ada abnormal, penambahan didekat MP standby', '053811708', 12, '100', 'WhatsApp_Image_2025-05-21_at_22_56_43_(1).jpeg', 6, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025JWB', '2025-06-15 23:44:38', NULL, '2025-06-17 11:09:55', NULL, NULL, '018511410', 31, '2025-06-15', 'Pindah selector switch setting thickness calendrol', 'Dipindah kepanel calenderoll agar memudahkan pengoperasiannya.', '', 9, '0', 'WhatsApp_Image_2025-06-15_at_23_41_46.jpeg', 6, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025K2H', '2025-06-04 12:41:32', '2025-06-18 12:41:32', '2025-06-10 09:54:09', '2025-06-10 09:52:18', '2025-06-10 09:54:09', '159812407', 19, '2025-06-12', 'URGENT! Perbaikan Lampu Sign Forklift WH02', 'Lampu Sign sebelah kanan mati. Mohon diadvance karena bekaitan dengan safety', '053811708', 6, '100', 'Screenshot_2025-06-04_124226.png', 7, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025K8U', '2025-06-12 13:14:35', '2025-06-26 13:14:35', '2025-06-16 14:30:42', NULL, NULL, '145612310', 31, '2025-06-13', 'Perbaikan AC di ruang admin produksi', 'AC tidak dingin suhu sudah max namun tidak dingin ', '053811708', 3, '0', 'no-image.jpg', 12, 3, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025KCA', '2025-06-02 17:46:38', '2025-06-07 17:46:38', '2025-06-09 09:27:36', '2025-06-09 09:26:43', '2025-06-09 09:27:36', '005711310', 19, '2025-06-09', 'Mesin blending', 'Cover mesin blending banyak yg tidak lengkap bautnya, minta cek dan pembaruan baut yg tidak proper nya', '053811708', 7, '100', 'IMG_20250602_122511.jpg', 11, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025KF5', '2025-05-23 11:00:57', '2025-05-28 11:00:57', '2025-06-04 08:36:53', '2025-06-04 08:35:52', '2025-06-04 08:36:53', '044811610', 26, '2025-05-23', 'Penggantian soket nanaboshi mesin press N1 dan N2', 'Ganti soket nanaboshi press N1 dan N2 atas bawah dengan yang karena pembacaan temperatur dies sering tidak aktual', '002611305', 7, '100', 'no-image.jpg', 3, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025KJQ', '2025-05-20 15:52:28', NULL, '2025-05-22 15:30:17', NULL, NULL, '145612310', 31, '2025-05-27', 'Pemasangan Interloc', 'Pemasangan Interloc di pagar area cutting FELT', '', 0, '0', '50f76ccf-20fb-4be2-8e3d-912cf39d31bb1.jpg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025KNR', '2025-06-16 13:42:22', NULL, '2025-06-16 16:05:25', NULL, NULL, '047511607', 31, '2025-06-19', 'Penambahan spon pada palet outer 2GN', 'Penambahan spon pada palet outer 2GN untuk kebutuhan produksi tanggal 19 juni 2025\r\ntotal kebutuhan produksi 9 palet', '', 8, '0', 'Screenshot_2025-06-16_134058.png', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025KV5', '2025-06-07 13:29:53', '2025-06-12 13:29:53', '2025-06-16 19:40:27', '2025-06-16 16:20:51', '2025-06-16 19:40:27', '009211410', 16, '2025-06-07', 'PEMBUATAN JIG UPLID 2GN', 'PEMBUATAN JIG UPLID 2GN ,KARENA JIG ADA 1PCS\r\n#CONTOH JIG TERLAMPIR', '072611806', 7, '100', 'WhatsApp_Image_2025-06-07_at_13_29_30.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sudah di tambahkan jig go nogo untuk produk uplide 2GN', NULL, NULL),
('WO2025L4T', '2025-06-11 09:09:39', NULL, '2025-06-16 14:32:36', NULL, NULL, '128012210', 19, '2025-06-11', 'Plat meja heater N3 melengkung ', 'Plat meja heater N3 melengkung. untuk pemagangan kurang mereta di part', '', 5, '0', 'WhatsApp_Image_2025-06-10_at_14_20_18_(1).jpeg', 3, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025LCD', '2025-06-14 10:28:59', NULL, '2025-06-17 11:15:04', NULL, NULL, '018511410', 31, '2025-06-14', 'Penambahan jig go no go magnetic', 'Jig agar bisa disetting sesuai ketebalan ( 1 s/d 5 mm ) material yang akan diproses, meminimalisir double proses magnetic', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_09_57_48.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025LGX', '2025-06-13 09:53:12', '2025-06-18 09:53:12', '2025-06-16 08:35:53', NULL, NULL, '047511607', 30, '2025-06-20', 'Modifikasi palet ', 'Modifikasi palet Hood 2JX ke Hood YTB untuk kebutuhan delivery & stok FG', '072611806', 3, '0', 'Screenshot_2025-06-13_095225.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025M8G', '2025-06-08 12:23:56', NULL, '2025-06-08 12:23:56', NULL, NULL, '058711706', 15, '2025-06-08', 'Perbaikan dies', 'Perbaikan dies', '', 8, '0', 'Screenshot_2025-04-21_1307321.png', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025MBF', '2025-06-17 03:17:22', '2025-06-22 03:17:22', '2025-06-17 18:35:37', NULL, NULL, '127912210', 31, '2025-06-16', 'Pengelasan kembali roda meja pendingin', 'Pengelasan kembali roda meja waiting yang copot dibagian las-lasan nya, qty 1 pcs yg copot (meja waiting/pendingin rul ) ', '072611806', 3, '0', 'WhatsApp_Image_2025-06-17_at_03_18_35_(1).jpeg', 1, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025MDR', '2025-06-10 13:11:09', '2025-06-24 13:11:09', '2025-06-16 14:29:01', NULL, NULL, '154412305', 32, '2025-06-11', 'Penarikan kabel jaringan untuk cctv monitoring mat', 'Penarikan kabel jaringan untuk cctv monitoring material aspalt dari lantai 2 ke lantai 3 aspalt ', '053811708', 3, '0', 'WhatsApp_Image_2025-06-10_at_13_14_10.jpeg', 6, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025MFO', '2025-06-12 16:22:15', '2025-06-17 16:22:15', '2025-06-16 16:28:41', '2025-06-16 16:21:10', '2025-06-16 16:28:41', '159812407', 29, '2025-06-20', 'Replace Roda Tangga RM', 'Replace Roda Tangga RM', '072611806', 6, '100', 'WhatsApp_Image_2025-06-12_at_4_24_16_PM.jpeg', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'roda sudah di ganti', NULL, NULL),
('WO2025MQ1', '2025-05-22 10:52:06', NULL, '2025-05-22 15:26:59', NULL, NULL, '145612310', 32, '2025-02-05', 'Pemindahan posisi pipa vacum wj', 'Pemindahan pipa vacum wj,tabung angin dan mc shimizu ke area dekat conveyor bertujuan untuk akses jalan mp saat proses produksi', '', 0, '0', 'no-image.jpg', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025MTC', '2025-06-02 17:36:40', NULL, '2025-06-10 15:31:47', NULL, NULL, '005711310', 26, '2025-06-16', 'Pembuata safety fence', 'Pembuatan pembatas / pelindung agar palet recyce tidak menabrak conveyor vacum transfer', '', 5, '0', 'IMG_20250602_122700.jpg', 11, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025N5C', '2025-06-16 07:52:45', NULL, '2025-06-16 16:09:24', NULL, NULL, '159812407', 31, '2025-06-18', 'URGENT CUSTOMER FINDING MODIFIKASI BOX OUTER', 'Modifikasi Box untuk delivery Outer ke Tambun, dengan menambahkan Spons dibagian dasar Box sebagai stopper untuk masing - masing part. SNP 12 Pcs. Detail bisa disscuss dengan Rizaldi', '', 8, '0', 'WhatsApp_Image_2025-06-16_at_7_43_02_AM.jpeg', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025NAB', '2025-05-23 01:46:22', '2025-06-06 01:46:22', '2025-06-09 17:22:34', '2025-06-09 17:22:02', '2025-06-09 17:22:34', '011911410', 31, '2025-05-22', ' Lampu penerangan meja assy rul 4 ', 'Penambahan lampu penerangan meja assy rul 4 \r\n', '002611305', 7, '100', 'WhatsApp_Image_2025-05-23_at_01_40_43.jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025NLD', '2025-06-04 12:39:18', NULL, '2025-06-05 10:40:48', NULL, NULL, '159812407', 29, '2025-06-12', 'Perbaikan Loading Dock Container di Area Raw Mater', 'Perbaikan Engsel dan pemasangan kembali plat pada Engsel', '', 10, '0', 'Screenshot_2025-06-04_124108.png', 7, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025NTI', '2025-06-10 15:55:23', '2025-06-15 15:55:23', '2025-06-16 19:42:22', '2025-06-16 16:20:08', '2025-06-16 19:42:22', '025511510', 29, '2025-06-10', 'Perbaikan pintu chamber ', 'Pintu chamber NVH rusak di bagian engsel ', '072611806', 7, '100', 'WhatsApp_Image_2025-06-10_at_15_58_27.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Engsel Pintu chamber sudah di welding', NULL, NULL),
('WO2025O80', '2025-05-28 07:41:23', '2025-06-02 07:41:23', '2025-06-14 13:25:34', '2025-06-13 15:18:42', '2025-06-14 13:25:34', '047511607', 30, '2025-06-13', 'Repair pallet reguler', 'Palet NG return Customer tanggal 27 Mei 2025', '072611806', 7, '100', 'Screenshot_2025-05-28_072902.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO2025OBM', '2025-06-09 11:25:34', '2025-06-14 11:25:34', '2025-06-12 11:14:39', '2025-06-12 11:13:41', '2025-06-12 11:14:39', '018511410', 31, '2025-06-09', 'Penambahan cover pagar area mixing', 'Meminimalisir benda asing atau yang lainnya jatuh dari lantai 3 mixing', '072611806', 12, '100', 'WhatsApp_Image_2025-06-09_at_09_20_44.jpeg', 6, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025OWH', '2025-05-20 15:16:38', '2025-05-25 15:16:38', '2025-06-09 19:22:21', '2025-05-26 08:36:16', '2025-06-09 19:22:21', '145612310', 19, '2025-05-27', 'Penambahan/Mengganti Cover Akrilik', 'Menyesuaikan ukuran Akrilik sehingga tidak ada celah pada mesin.', '072611806', 7, '100', 'ed4a8e0a-2206-4806-bcdd-adfdba520a94.jpg', 11, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025OY9', '2025-05-23 11:03:34', NULL, '2025-06-05 10:58:46', NULL, NULL, '044811610', 29, '2025-05-23', 'Perbaikan atap yang bocor di area NVH depan', 'Kebocoran atap yang parah di arean depan N1 dan belakang N1 \r\n', '', 10, '0', 'WhatsApp_Image_2025-05-23_at_10_59_44_(1).jpeg', 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025PIA', '2025-06-02 21:35:26', '2025-06-16 21:35:26', '2025-06-05 15:06:23', NULL, NULL, '018611410', 29, '2025-06-02', 'Perbaikan lampu', 'Lampu gedung diantara RUL 1 dan RUL 2 mati 1', '053811708', 5, '0', 'WhatsApp_Image_2025-06-02_at_21_28_35_(1).jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025PJ3', '2025-06-12 09:02:41', NULL, '2025-06-12 09:02:41', NULL, NULL, '038321605', 32, '2025-06-12', 'Adanya kebocoran di wastafel', 'Tolong dibantu ya team MTC, terkait kebocoran wastafel tersebut. \r\nkarena khawatir akan banyak genangan air di area tersebut. sehingga menimbulkan banyak potensi bahaya terjadi.\r\nTerima kasih banyak.', '', 8, '0', 'no-image.jpg', 12, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025PSY', '2025-06-14 11:20:26', NULL, '2025-06-17 11:11:21', NULL, NULL, '018511410', 31, '2025-06-14', 'Penambahan roller area bak cooling', 'Roller ukuran kecil dibagian depan roller spon, untuk menahan material agar tidak terlalu menekan material, yang akan cepat merusak roller spon ', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_10_07_03.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025PZT', '2025-06-14 11:25:04', NULL, '2025-06-17 11:10:48', NULL, NULL, '018511410', 31, '2025-06-14', 'Pembuatan dudukan spon resin', 'Menggunakan besi holo 2x4cm, menggantikan kayu yang sudah ada.', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_10_08_41.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025QEC', '2025-06-13 08:25:50', NULL, '2025-06-17 15:12:09', NULL, NULL, '127912210', 31, '2025-06-13', 'Penambahan identitas pada kabel heater dimesin R1B', 'Penambahan identitas nomor dan keterangan bahwa kabel heater atas dan bawah agar mudah dikenali dan difahami', '', 9, '0', 'WhatsApp_Image_2025-06-13_at_08_26_23.jpeg', 1, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ticket` (`id_ticket`, `tanggal`, `deadline`, `last_update`, `tanggal_proses`, `tanggal_solved`, `reported`, `id_sub_kategori`, `due_date`, `problem_summary`, `problem_detail`, `teknisi`, `status`, `progress`, `filefoto`, `id_lokasi`, `id_prioritas`, `assign_to`, `user_mail`, `mgr_noted`, `mgrd_noted`, `mgr_id`, `mgrd_id`, `mgr_date`, `mgrd_date`, `mgr_reject`, `mgr_reject_id`, `mgrd_reject`, `mgrd_reject_id`, `memo_teknisi`, `answerfoto`, `user_answer`) VALUES
('WO2025QI4', '2025-06-04 23:09:15', '2025-06-06 23:09:15', '2025-06-09 10:53:01', '2025-06-09 10:35:03', '2025-06-09 10:53:01', '107612010', 19, '2025-06-04', 'Menghilangkan tempat clip bunga', 'Menghilangkat tempat clip pada meja inpeksi N4 belakang', '072611806', 7, '100', 'WhatsApp_Image_2025-06-04_at_23_04_59.jpeg', 3, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025QRY', '2025-06-02 17:42:54', NULL, '2025-06-05 10:48:26', NULL, NULL, '005711310', 31, '2025-06-05', 'Tangga bekas mesin press', 'Tangga bekas mesin press sudah tidak di gunakan dan belum di rapikan ', '', 0, '0', 'IMG_20250602_121929.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025R4L', '2025-06-02 16:55:04', NULL, '2025-06-05 10:55:48', NULL, NULL, '005711310', 19, '2025-06-09', 'Penggantian plastik layar monitor', 'Penggantian plastik layar monitor , agar pembacaan tidak buram', '', 0, '0', 'IMG_20250602_121309.jpg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025RER', '2025-06-09 17:12:02', NULL, '2025-06-09 17:12:02', NULL, NULL, '038321605', 32, '2025-06-09', 'Perapian kabel', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '', 8, '0', 'kabel_12.jpg', 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025RGU', '2025-06-02 21:29:24', '2025-06-16 21:29:24', '2025-06-05 13:37:52', NULL, NULL, '018611410', 19, '2025-06-02', 'Perbaikan kran angin', 'Kran angin mesin R3C rusak', '002611305', 3, '0', 'WhatsApp_Image_2025-06-02_at_21_28_42_(1).jpeg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025RKY', '2025-05-27 15:41:50', '2025-06-01 15:41:50', '2025-06-02 10:45:51', NULL, NULL, '159812407', 30, '2025-06-07', 'Repair Box Hood F/L ', 'Perbaikan Sekat Box Hood F/L (3 Box)', '072611806', 3, '0', 'WhatsApp_Image_2025-05-27_at_3_43_33_PM.jpeg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025RMS', '2025-06-13 09:40:22', '2025-06-18 09:40:22', '2025-06-17 11:19:42', '2025-06-16 09:56:17', '2025-06-17 11:19:42', '047511607', 30, '2025-06-27', 'Repair pallet reguler', 'Palet NG return Customer tanggal 11-12 juni 2025', '072611806', 6, '100', 'Screenshot_2025-06-13_093841.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di repair', NULL, NULL),
('WO2025RNE', '2025-06-14 09:22:02', '2025-06-19 09:22:02', '2025-06-17 19:01:25', NULL, NULL, '018511410', 19, '2025-06-14', 'Perbaikan cover', 'Cover sensor press continue kurang kuat.', '072611806', 3, '0', 'WhatsApp_Image_2025-06-13_at_10_06_57.jpeg', 6, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SB9', '2025-05-22 16:26:55', '2025-05-24 16:26:55', '2025-05-26 10:00:21', '2025-05-26 09:59:10', '2025-05-26 10:00:21', '159812407', 19, '2025-05-25', '(URGENT) Cek Rem Forklift WH 01', 'Pengecekan Rem Wh01 yang blong', '053811708', 7, '100', 'no-image.jpg', 7, 1, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SBR', '2025-05-20 15:16:42', '2025-05-25 15:16:42', '2025-06-09 19:21:17', '2025-05-26 09:44:19', '2025-06-09 19:21:17', '145612310', 19, '2025-05-27', 'Penambahan/Mengganti Cover Akrilik', 'Menyesuaikan ukuran Akrilik sehingga tidak ada celah pada mesin.', '072611806', 7, '100', 'ed4a8e0a-2206-4806-bcdd-adfdba520a941.jpg', 11, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SEL', '2025-06-02 16:53:11', NULL, '2025-06-09 13:11:16', NULL, NULL, '005711310', 32, '2025-06-09', 'Pembuatan cover kabel', 'Cover kabel di buat di atas sehingga tidak sering terinjak dan kotor scrap triming', '', 5, '0', 'IMG_20250602_124013.jpg', 1, 0, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SHC', '2025-06-12 16:23:56', '2025-06-26 16:23:56', '2025-06-16 14:29:57', NULL, NULL, '159812407', 31, '2025-06-19', 'Penambahan Colokan Listrik dimeja Leader RM', 'Penambahan lubang colokan (4 colokan) karena tim RM kekurangan colokan.', '053811708', 3, '0', 'WhatsApp_Image_2025-06-11_at_2_08_18_PM.jpeg', 7, 3, 'SPVU', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SL9', '2025-05-21 02:40:02', NULL, '2025-05-21 13:55:00', NULL, NULL, '011911410', 19, '2025-05-20', 'Plat bantalan rel oven poe rusak ', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '', 0, '0', 'WhatsApp_Image_2025-05-21_at_02_32_531.jpeg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SMX', '2025-06-12 16:18:20', '2025-06-17 16:18:20', '2025-06-16 08:42:56', NULL, NULL, '159812407', 30, '2025-06-30', 'Repair Pallet Feltline (URGENT SAFETY FINDING)', 'Follow Up WO repair pallet Feltline, yang dikembalikan sebelumnya karena material belum ready. Sekarang material sudah ada.', '072611806', 3, '0', 'WhatsApp_Image_2025-06-12_at_4_19_05_PM.jpeg', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025SNF', '2025-06-02 17:40:21', '2025-06-16 17:40:21', '2025-06-05 13:38:59', NULL, NULL, '005711310', 19, '2025-06-09', 'Selang ciller R2C', 'Coupler selang ciller bocor dan kran tidak bisa menutup sempurna', '002611305', 3, '0', 'IMG_20250602_122118.jpg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025STU', '2025-06-02 21:39:41', '2025-06-07 21:39:41', '2025-06-05 13:33:53', NULL, NULL, '018611410', 19, '2025-06-02', 'Perbaikan tirai', 'Tirai belakang oven 4 rusak', '002611305', 3, '0', 'WhatsApp_Image_2025-06-02_at_21_28_41.jpeg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025TGP', '2025-06-12 03:02:45', '2025-06-17 03:02:45', '2025-06-16 14:31:48', NULL, NULL, '005711310', 31, '2025-06-16', 'Penambahan nozel kerucut', 'Penambahan nozel kerucut pada mesin rul 3 untuk jalan proses Fr Toyota, untuk memudakan aplikasi lem pasta', '002611305', 3, '0', 'IMG_20250612_030354.jpg', 1, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025TGS', '2025-06-02 17:25:53', NULL, '2025-06-05 10:53:07', NULL, NULL, '005711310', 19, '2025-06-09', 'Modif tangga oven 1- 8', 'Tangga oven di buat menjadi permanet tidak bongkar pasang sehingga tidak mudah mleset saat operator naik', '', 10, '0', 'IMG_20250602_121912.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025TM3', '2025-06-09 10:01:31', '2025-06-23 10:01:31', '2025-06-09 19:03:23', NULL, NULL, '154412305', 32, '2025-06-09', 'Melanjutkan pengaktifan cctv area gedung baru', 'Melanjutkan pengaktifan cctv area gedung baru', '053811708', 3, '0', 'WhatsApp_Image_2025-06-09_at_09_08_251.jpeg', 12, 3, 'SPVU', NULL, 'Job utk maintenance ngapain Pak?', 'connect kabel dengan scissor lift pak di area warehouse,sebelumnya dengan faiq', '159912408', '154412305', '2025-06-09 10:25:14', '2025-06-09 11:06:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025TNE', '2025-06-14 10:14:23', NULL, '2025-06-17 15:08:56', NULL, NULL, '018511410', 19, '2025-06-14', 'Perbaikan sambungan pipa boiler', 'Ada tetesan oli boiler pada silinder calenderoll', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_09_38_33.jpeg', 6, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025TQY', '2025-06-13 10:49:29', '2025-06-18 10:49:29', '2025-06-17 18:55:51', NULL, NULL, '128012210', 15, '2025-06-13', 'Penambahan pin di dies OUTER 3GN', 'Penambahan pin (6) di dies outer 3GN dikarenakan ada problem melipat di part, maka itu untuk minimalisir/ menghilangkan problem tersebut dilakukan penambahan pin pada dies untuk mengaitkan nonwoven.', '072611806', 3, '0', 'WhatsApp_Image_2025-06-13_at_10_47_47.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025U2U', '2025-06-02 17:38:07', NULL, '2025-06-09 13:12:48', NULL, NULL, '005711310', 26, '2025-06-09', 'Pembuatan cover selang angin', 'Selang angin tidak rapi dan melambai', '', 5, '0', 'IMG_20250602_123401.jpg', 1, 0, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025U5I', '2025-06-02 17:28:31', '2025-06-07 17:28:31', '2025-06-09 13:44:39', '2025-06-09 13:43:48', '2025-06-09 13:44:39', '005711310', 32, '2025-06-09', 'Perbaikan lampu', 'Perbaikan lampu meja hotmelt RUL 1 Mati', '002611305', 7, '100', 'IMG_20250602_123433.jpg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025UDT', '2025-06-03 09:58:41', '2025-06-08 09:58:41', '2025-06-14 13:26:42', '2025-06-13 15:19:33', '2025-06-14 13:26:42', '047511607', 30, '2025-06-17', 'Repair pallet reguler', 'Palet NG return Customer tanggal 30 mei - 02 juni 2025', '072611806', 7, '100', 'Screenshot_2025-06-03_094828.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO2025UMU', '2025-06-02 16:56:42', '2025-06-07 16:56:42', '2025-06-09 15:07:38', '2025-06-09 10:42:40', '2025-06-09 15:07:38', '005711310', 28, '2025-06-09', 'Penggantin roda jig', 'Roda jig rusak dan patah', '072611806', 7, '100', 'IMG_20250602_121548.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025UQV', '2025-05-21 02:40:00', '2025-05-26 02:40:00', '2025-05-26 09:13:44', '2025-05-26 08:37:12', '2025-05-26 09:13:44', '011911410', 19, '2025-05-20', 'Plat bantalan rel oven poe rusak ', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '072611806', 6, '100', 'WhatsApp_Image_2025-05-21_at_02_32_53.jpeg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025UXQ', '2025-05-27 13:02:28', '2025-05-29 13:02:28', '2025-06-09 14:51:22', '2025-06-09 14:37:58', '2025-06-09 14:51:22', '128012210', 15, '2025-05-27', 'Pengecekan heater upper dies cowl mmki cavity 1 (p', 'Ketika jalan produksi cowl mmki, part cowl mmki cavity 1 (6320A412) terbakar, dengan temperatur std 180+/-20 tetapi actual di dies 195\'', '072611806', 7, '100', 'WhatsApp_Image_2025-05-27_at_12_54_55.jpeg', 3, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025UXW', '2025-06-09 10:00:31', '2025-06-23 10:00:31', '2025-06-09 19:03:55', NULL, NULL, '154412305', 32, '2025-06-10', 'Request penarikan kabel', 'Request penarikan kabel dari meja pak agung CFO ke ruang server lt3', '053811708', 3, '0', 'Topology_TNA.jpg', 4, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025V0W', '2025-06-02 21:40:55', '2025-06-07 21:40:55', '2025-06-09 19:04:58', '2025-06-09 19:04:58', NULL, '018611410', 19, '2025-06-02', 'Perbaikan tombol two hand operate', 'Pengunci tombol two hand operate mesin R2C rusak', '072611806', 4, '0', 'WhatsApp_Image_2025-06-02_at_21_28_39.jpeg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025VDN', '2025-06-09 11:01:55', '2025-06-14 11:01:55', '2025-06-15 15:26:46', '2025-06-15 15:26:46', NULL, '163122511', 31, '2025-06-23', 'Perbaikan dinding kabel terekspose di area dekat p', 'Dinding terbuka dan kabel terekspose. ', '053811708', 4, '0', 'WhatsApp_Image_2025-06-09_at_09_27_08.jpeg', 12, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025VE6', '2025-06-02 17:01:21', '2025-06-07 17:01:21', '2025-06-05 13:06:31', NULL, NULL, '005711310', 19, '2025-06-09', 'Pemindahan legran', 'Pemindahan legran meja heater dari R4B ke R4A', '002611305', 3, '0', 'IMG_20250602_121758.jpg', 1, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025VL1', '2025-06-14 10:25:10', NULL, '2025-06-17 11:15:39', NULL, NULL, '018511410', 31, '2025-06-14', 'Penutupan area output crusher poe', 'Tutup rapat area output agar debu tidak berterbangan dan pasang tirai (plastik fiber bening) dibuka tutup untuk penggantian box jika sudah penuh', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_09_55_19.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025VOZ', '2025-06-09 10:59:25', '2025-06-14 10:59:25', '2025-06-10 09:57:06', '2025-06-10 09:52:02', '2025-06-10 09:57:06', '163122511', 31, '2025-06-16', 'Perbaikan tray kabel charging forklift', '1. Bersihkan terminal charger forklift yang berdebu dan sarang laba-laba\r\n2. Rapikan kabel di area belakang dan tutup dengan tray yg rapat dan rapi.', '053811708', 6, '100', 'WhatsApp_Image_2025-06-09_at_09_49_56.jpeg', 7, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025VQI', '2025-05-28 10:25:44', '2025-06-02 10:25:44', '2025-06-02 10:44:59', NULL, NULL, '047511607', 30, '2025-06-13', 'Ganti cover plastik & repainting', 'Palet berkarat & cover plastik NG total 20 unit :\r\n1.PLT-AA no.43,47,32,82,44,98,91,84,85,115,27,62,61,124,121,16\r\n2.PLT-U no.28,23,35,22', '072611806', 3, '0', 'IMG-20250527-WA0014.jpg', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WAN', '2025-06-17 09:55:44', NULL, '2025-06-17 09:55:45', NULL, NULL, '134322209', 16, '2025-06-16', 'Jig Pengujian Asphalt Request BYD (TOP URGENT)', 'Jig untuk pengujian asphalt \r\nSteel plat 1mm\r\nJumlah : 6pcs', '', 1, '0', 'Doc20250617_09445848.pdf', 9, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WFO', '2025-06-02 17:44:54', '2025-06-16 17:44:54', '2025-06-05 13:38:42', NULL, NULL, '005711310', 19, '2025-06-09', 'Perbaiakan buzzer', 'Banyak buzzer oven 1 sampai 8 sudah tidak ada suara nya, dan juga sudah lirih tidak jelas', '002611305', 3, '0', 'IMG_20250602_121628.jpg', 1, 3, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WHY', '2025-06-11 14:13:07', '2025-06-16 14:13:07', '2025-06-16 14:32:10', NULL, NULL, '018511410', 19, '2025-06-11', 'Perbaikan conveyor oven asphalt ', 'Putaran conveyor tersendat-sendat (conveyor bagian bawah)', '053811708', 3, '0', 'WhatsApp_Image_2025-06-11_at_14_09_57.jpeg', 6, 2, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WI5', '2025-06-02 16:59:02', '2025-06-07 16:59:02', '2025-06-10 10:37:37', '2025-06-10 10:34:59', '2025-06-10 10:37:37', '005711310', 19, '2025-06-09', 'Pembuatan cover', 'Pembuatan cover pada sisi kiri dan kanan belt agar tidak ada celah tangan untuk bisa masuk ke belt, pastikan cover tidak terlalu besar sehingga tidak mempengaruhi laju material', '072611806', 7, '100', 'IMG_20250602_121601.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WIV', '2025-06-09 08:21:27', '2025-06-14 08:21:27', '2025-06-17 11:23:15', '2025-06-16 09:54:00', '2025-06-17 11:23:15', '047511607', 30, '2025-06-23', 'Repair pallet reguler', 'Palet NG return customer tanggal 5 Juni 20025', '072611806', 7, '100', 'Screenshot_2025-06-09_081848.png', 7, 2, 'SPVM', 'rizky@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudah di perbaiki', NULL, NULL),
('WO2025WN7', '2025-06-14 10:12:38', NULL, '2025-06-17 15:09:22', NULL, NULL, '018511410', 26, '2025-06-14', 'Penambahan tuas setting pembatas material', 'Tuas berada disebelah kanan dekat dengan panel mesin press continue, agar memudahkan proses setting material', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_09_34_30.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WUT', '2025-06-08 11:09:52', NULL, '2025-06-16 10:45:13', NULL, NULL, '007811310', 17, '2025-06-08', 'Support IT CCTV dszsss', 'Perbaikan cctv', '', 10, '0', 'Electrical_Hazard_Landscape_fix_(1)1.png', 5, 0, NULL, 'yudi@tna.co.id', 'Pak Lutpi, kabel yg mau direpair yg mana? mohon informasi detailnya, terima kasih.', NULL, '159912408', NULL, '2025-06-16 10:45:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025WYT', '2025-06-04 12:33:39', '2025-06-09 12:33:39', '2025-06-05 15:59:49', '2025-06-05 15:58:06', '2025-06-05 15:59:49', '159812407', 31, '2025-06-12', 'URGENT! Melengkapi Baut Roda Forklift WH02', 'Baut Roda belakang kurang satu. Mohon diadvance karena berkaitan dengan Safety', '053811708', 6, '100', 'Screenshot_2025-06-04_123352.png', 7, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025X4T', '2025-06-09 11:22:46', NULL, '2025-06-10 15:31:27', NULL, NULL, '018511410', 31, '2025-06-09', 'Penambahan tangga dibelakang press continue', 'Untuk mempermudah setting mtl yang geser/kurang center saat proses berlangsung, tanpa harus memutar lewat depan', '', 5, '0', 'WhatsApp_Image_2025-06-09_at_11_20_52.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025X6C', '2025-06-02 17:31:39', NULL, '2025-06-05 10:51:48', NULL, NULL, '005711310', 17, '2025-06-09', 'Pembuatan tangga', 'Pembuatan tangga yg permaen dan juga safety', '', 10, '0', 'IMG_20250602_122353.jpg', 11, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025X80', '2025-06-14 11:17:32', NULL, '2025-06-17 11:12:22', NULL, NULL, '018511410', 31, '2025-06-14', 'Penambahan penahan kape bibir extrude k.1500', 'Menggunakan besi holo ukuran 2x2cm, untuk memudahkan pembersihan/pemotongan material.', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_10_05_15.jpeg', 6, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025XFK', '2025-06-13 09:16:55', NULL, '2025-06-17 15:10:58', NULL, NULL, '107612010', 19, '2025-06-13', 'Pergantian kipas', 'Pergantian kipas meja inpeksi N4 belakang 1 pcs dan meja inpeksi N5 depan 1 pcs', '', 9, '0', 'WhatsApp_Image_2025-06-13_at_08_18_28.jpeg', 3, 0, 'SPVU', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025XHM', '2025-06-02 17:23:24', '2025-06-07 17:23:24', '2025-06-09 19:10:40', '2025-06-09 19:04:37', '2025-06-09 19:10:40', '005711310', 19, '2025-06-09', 'Perbaikan kipas', 'Perbaikan kipas angin R3A bagian dalam, dudukan rusak dan di tali', '072611806', 7, '100', 'IMG_20250602_121418.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025XR6', '2025-06-14 13:14:02', NULL, '2025-06-17 11:10:29', NULL, NULL, '018511410', 19, '2025-06-14', 'Perbaikan cover cerobong burner oven asphalt', 'Sudah rusak/rapuh', '', 9, '0', 'WhatsApp_Image_2025-06-14_at_10_10_07.jpeg', 6, 0, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025XRK', '2025-06-07 13:32:13', '2025-06-12 13:32:13', '2025-06-13 08:48:24', NULL, NULL, '009211410', 27, '2025-06-07', 'Perbaikan dies hood 560b ', 'Perbaikan dies hood 560b cavity 3 bagian belang ada yang gompal\r\n#gambar terlampir', '072611806', 3, '0', 'WhatsApp_Image_2025-06-07_at_13_29_19.jpeg', 3, 2, 'SPVM', 'yudi@tna.co.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025Y5C', '2025-05-20 11:41:05', NULL, '2025-05-20 11:41:05', NULL, NULL, '154412305', 16, '2025-05-20', 'Support IT CCTV dszsss', 'Perbaikan', '', 1, '0', '042025PROD4.pdf', 12, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025YCT', '2025-05-21 15:45:20', '2025-06-04 15:45:20', '2025-05-26 09:48:14', '2025-05-26 08:36:25', '2025-05-26 09:48:14', '145612310', 19, '2025-05-28', 'Perbaikan Board Plan ', 'Perbaikan Board Plan line carpet foto terlampir.', '072611806', 6, '100', '380ef607-28c4-412b-8449-ce9731f77bc3.jpg', 2, 3, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025YDH', '2025-06-02 17:50:25', '2025-06-07 17:50:25', '2025-06-09 19:12:11', '2025-06-09 19:05:39', '2025-06-09 19:12:11', '005711310', 31, '2025-06-09', 'Pembuatan cover', 'Pembuatan cover pada bagian bawah tiang mesin press R1A, R1B dan R1C', '072611806', 7, '100', 'IMG_20250602_123341.jpg', 1, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025YO2', '2025-05-27 13:23:48', '2025-06-10 13:23:48', '2025-06-17 11:27:18', '2025-06-16 09:49:38', '2025-06-17 11:27:18', '159812407', 30, '2025-06-30', 'Project RFID', 'Modifikasi penambahan dudukan pada semua pallet untuk RFID', '072611806', 7, '100', 'no-image.jpg', 7, 3, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet progress modifikasi penambahan dudukan barcode RFID , target selesai bulan juli', NULL, NULL),
('WO2025YS1', '2025-05-20 16:00:22', '2025-05-25 16:00:22', '2025-05-26 09:51:02', '2025-05-26 09:35:53', '2025-05-26 09:51:02', '005711310', 31, '2025-05-27', 'Penambahan cover', 'Pembuatan cover semi permanent di area mixing dan mesin Blending', '072611806', 7, '100', 'ac9cb292-7e8c-459c-9952-359af84c4b4d.jpg', 11, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025YWB', '2025-06-12 09:04:34', NULL, '2025-06-12 09:04:34', NULL, NULL, '038321605', 32, '2025-12-06', 'Adanya kebocoran di wastafel', 'Tolong dibantu ya team MTC, terkait kebocoran wastafel tersebut. karena khawatir akan banyak genangan air di area tersebut. sehingga menimbulkan banyak potensi bahaya terjadi. Terima kasih banyak.', '', 8, '0', 'wastafel_area_kantin_problem.jpg', 12, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025ZLV', '2025-06-04 23:12:02', '2025-06-06 23:12:02', '2025-06-09 14:53:35', '2025-06-09 14:38:24', '2025-06-09 14:53:35', '107612010', 19, '2025-06-04', 'Perbaikan meja N5 belakang ( melengkung )', 'Perbaikan meja inpeksi N5 belakang ( melengkung ) agar lurus seperti meja lainnya', '072611806', 7, '100', 'WhatsApp_Image_2025-06-04_at_23_05_30.jpeg', 3, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('WO2025ZNI', '2025-05-26 14:15:33', '2025-05-31 14:15:33', '2025-06-14 13:28:18', '2025-06-13 15:07:46', '2025-06-14 13:28:18', '047511607', 30, '2025-07-06', 'Repair pallet reguler', 'Palet NG return Customer tanggal 22-24 Mei 2025', '072611806', 7, '100', 'Screenshot_2025-05-26_141010.png', 7, 2, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Palet sudh di perbaiki', NULL, NULL),
('XIUje7M5J', '2025-05-14 15:22:11', '2025-05-16 15:22:11', '2025-05-22 10:25:39', '2025-05-21 10:22:54', '2025-05-22 10:25:39', '047511607', 30, '0', 'Repair pallet reguler', 'Pallet sudah di repair tanggal 13 Mei 2025', '072611806', 7, '100', 'IMG-20250514-WA0018.jpg', 7, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('yAwD4Mf6v', '2025-05-14 08:31:48', '2025-05-19 08:31:48', '2025-05-26 09:56:54', '2025-05-26 09:54:10', '2025-05-26 09:56:54', '159812407', 19, '1 Hari', 'Repair Rem Forklift WH01', 'Kondisi Rem WH 01 blong', '053811708', 7, '100', 'no-image.jpg', 7, 2, 'SPVU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('yuiUBY0x1', '2025-05-14 15:23:40', '2025-05-16 15:23:40', '2025-05-22 10:24:01', '2025-05-21 10:22:28', '2025-05-22 10:24:01', '047511607', 30, '0', 'Repair pallet reguler', 'Palet sudah direpair tanggal 13 Mei 2025', '072611806', 7, '100', 'IMG-20250514-WA0019.jpg', 7, 1, 'SPVM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_message`
--

CREATE TABLE `ticket_message` (
  `id_message` int(10) UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `message` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket_message`
--

INSERT INTO `ticket_message` (`id_message`, `id_ticket`, `tanggal`, `status`, `message`, `id_user`, `filefoto`) VALUES
(5, '6hFuTNCqb', '2025-05-21 10:28:22', 1, 'palet sudah di repair', '072611806', NULL),
(6, 'ipIowdx76', '2025-05-22 14:36:24', 1, 'posisi fix dan arah nya di tentukan ya pak.', '053811708', NULL),
(7, 'WO2025FGZ', '2025-05-22 16:41:09', 1, 'Perubahan Layout After', '159812407', 'Screenshot_2025-05-22_164247.png'),
(8, 'WO2025SBR', '2025-05-26 09:35:07', 1, 'Tolong kasih informasi detail untuk memudahkan saat pengerjaan.', '072611806', NULL),
(9, 'WO202551F', '2025-06-05 15:08:17', 1, 'waiting sparepart Lampu gedung', '053811708', NULL),
(10, 'WO2025PIA', '2025-06-05 15:10:11', 1, 'waiting sparepart(lampu gedung)\r\n', '053811708', NULL),
(11, 'WO2025J4R', '2025-06-05 15:10:53', 1, 'waiting sparepart (lampu gedung)', '053811708', NULL),
(12, '8VRwfx35B', '2025-06-09 12:52:07', 1, 'test catatan (IT)', '005711310', 'WhatsApp_Image_2025-06-09_at_09_08_252.jpeg'),
(13, 'WO2025IYU', '2025-06-10 07:29:37', 1, 'test', '050411610', 'OIP5.jpg'),
(14, 'WO2025DIQ', '2025-06-10 12:36:28', 1, 'material dari karpet NG, untuk dipotong sbg sekat', '000521205', NULL),
(15, 'WO2025DIQ', '2025-06-13 13:05:03', 1, 'material karpet NG untuk dipotong sebagai sekat', '047511607', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id_tracking` int(10) UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL DEFAULT '',
  `tanggal` datetime DEFAULT NULL,
  `status` text NOT NULL,
  `deskripsi` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text NOT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `answerfoto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`id_tracking`, `id_ticket`, `tanggal`, `status`, `deskripsi`, `id_user`, `filefoto`, `signature`, `answerfoto`) VALUES
(159, '59fCrgiqz', '2025-05-14 08:04:22', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Mesin Cutting mati, tidak bisa beroperasi', '159812407', '', NULL, NULL),
(160, 'yAwD4Mf6v', '2025-05-14 08:31:48', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Kondisi Rem WH 01 blong', '159812407', '', NULL, NULL),
(161, 'LgY2CxHy6', '2025-05-14 09:22:46', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Lampu Indikator dilepas', '159812407', '', NULL, NULL),
(162, '5JYSlHdwg', '2025-05-14 09:24:12', 'Ticket Submited. Kategori: Repair(Repair building)', 'Perbaikan Safety Barrier tiang gedung diarea Raw Material', '159812407', '', NULL, NULL),
(163, 'rnMI8Wtwg', '2025-05-14 10:13:17', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tombol emergency oven 3 berpotensi terkena badan di karnakan posisi menonjol ke depan', '015311410', '', NULL, NULL),
(164, 'wGSHK7Dk0', '2025-05-14 10:13:19', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tombol emergency oven 3 berpotensi terkena badan di karnakan posisi menonjol ke depan', '015311410', '', NULL, NULL),
(165, 'wGSHK7Dk0', '2025-05-14 14:17:29', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(166, 'rnMI8Wtwg', '2025-05-14 14:19:15', 'Ticket Rejected', 'sudah diajukan sebelumnya, jadi dobel WO sama', '050411610', '', NULL, NULL),
(167, 'XIUje7M5J', '2025-05-14 15:22:11', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Pallet sudah di repair tanggal 13 Mei 2025', '047511607', '', NULL, NULL),
(168, 'yuiUBY0x1', '2025-05-14 15:23:41', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet sudah direpair tanggal 13 Mei 2025', '047511607', '', NULL, NULL),
(169, 'rKQqX6zhk', '2025-05-14 15:25:04', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet sudah di repair tanggal 13 Mei 2025', '047511607', '', NULL, NULL),
(170, 'rKQqX6zhk', '2025-05-14 15:34:44', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(171, 'yuiUBY0x1', '2025-05-14 15:34:50', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(172, 'XIUje7M5J', '2025-05-14 15:34:57', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(173, '5JYSlHdwg', '2025-05-14 15:35:04', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(174, 'LgY2CxHy6', '2025-05-14 15:35:09', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(175, 'yAwD4Mf6v', '2025-05-14 15:35:16', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(176, '59fCrgiqz', '2025-05-14 15:35:23', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(177, '6hFuTNCqb', '2025-05-15 13:59:06', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet sudah direpair tanggal 14 Mei 2025', '047511607', '', NULL, NULL),
(178, 'oe9iHGa8N', '2025-05-15 15:59:11', 'Ticket Submited. Kategori: Repair(Repair building)', 'Stopkontak existing kendor, aliran listrik putus nyambung', '159812407', '', NULL, NULL),
(179, '6GnhIZvdJ', '2025-05-15 16:00:27', 'Ticket Submited. Kategori: Fabrikasi(Jig)', 'Pembuatan Trolley baru Sparepart, Spec ada dilampiran', '159812407', '', NULL, NULL),
(180, '6GnhIZvdJ', '2025-05-16 08:20:07', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(181, 'oe9iHGa8N', '2025-05-16 08:20:32', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(182, '6hFuTNCqb', '2025-05-16 08:20:49', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(183, '23y07d6ml', '2025-05-17 10:07:57', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Rel mesin  oven poe rul 4 rusak diarea depan mesin R4A plat  mangap ke atas baud penahan lepas.', '011911410', '', NULL, NULL),
(184, 'L9hYb0s6a', '2025-05-17 10:44:06', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Mesin sudah ada di Sparepart, untuk rel tetap menggunakan rel existing. Hanya diganti kelengkapan rel nya menggunakan yang baru (URGENT)', '159812407', '', NULL, NULL),
(185, 'APwb3cUNX', '2025-05-18 15:37:13', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan tombol auto stop mesin forming Felt di panel mesin Cutting', '018611410', '', NULL, NULL),
(186, 'APwb3cUNX', '2025-05-19 09:29:23', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(187, '23y07d6ml', '2025-05-19 09:34:01', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(188, 'oj0lNE5PA', '2025-05-19 13:06:00', 'Ticket Submited. Kategori: Repair(Repair dies)', 'Repair area yang kurang motong sesuai gambar terlampir.', '145612310', '', NULL, NULL),
(189, 'APwb3cUNX', '2025-05-19 13:53:16', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(190, '23y07d6ml', '2025-05-19 13:54:36', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(191, '6GnhIZvdJ', '2025-05-19 13:54:58', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(192, 'oe9iHGa8N', '2025-05-19 13:55:22', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(193, '6hFuTNCqb', '2025-05-19 13:55:44', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(194, 'rKQqX6zhk', '2025-05-19 13:56:13', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(195, 'yuiUBY0x1', '2025-05-19 13:56:33', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(196, 'XIUje7M5J', '2025-05-19 13:56:58', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(197, 'wGSHK7Dk0', '2025-05-19 13:57:14', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(198, '5JYSlHdwg', '2025-05-19 13:59:06', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(199, 'LgY2CxHy6', '2025-05-19 13:59:26', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(200, 'yAwD4Mf6v', '2025-05-19 13:59:44', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(201, '59fCrgiqz', '2025-05-19 14:00:11', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(202, 'oj0lNE5PA', '2025-05-19 14:24:17', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(203, 'ipIowdx76', '2025-05-19 14:32:56', 'Ticket Submited. Kategori: Request(Request)', 'Support pemasangan cctv area project gedung baru', '154412305', '', NULL, NULL),
(204, 'kxRiG98sH', '2025-05-19 14:34:09', 'Ticket Submited. Kategori: Request(Request)', 'Pergantian mesin absen di area kantin', '154412305', '', NULL, NULL),
(205, 'kxRiG98sH', '2025-05-19 14:38:00', 'Ticket Approved', 'Approved by Supervisor Dept', 'informasi teknology', '', NULL, NULL),
(206, 'ipIowdx76', '2025-05-19 14:38:04', 'Ticket Approved', 'Approved by Supervisor Dept', 'informasi teknology', '', NULL, NULL),
(207, 'oj0lNE5PA', '2025-05-19 14:42:18', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(208, 'kxRiG98sH', '2025-05-19 14:42:37', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(209, 'ipIowdx76', '2025-05-19 14:42:55', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(210, 'oj0lNE5PA', '2025-05-19 16:01:03', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(211, '5JYSlHdwg', '2025-05-19 16:01:26', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(212, '6GnhIZvdJ', '2025-05-19 16:01:48', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to technician.', '144222308', '', NULL, NULL),
(213, '6hFuTNCqb', '2025-05-19 16:02:20', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '144222308', '', NULL, NULL),
(214, 'rKQqX6zhk', '2025-05-19 16:02:36', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '144222308', '', NULL, NULL),
(215, 'yuiUBY0x1', '2025-05-19 16:02:50', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '144222308', '', NULL, NULL),
(216, 'XIUje7M5J', '2025-05-19 16:03:02', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '144222308', '', NULL, NULL),
(217, '59fCrgiqz', '2025-05-19 17:37:27', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '162112408', '', NULL, NULL),
(218, 'yAwD4Mf6v', '2025-05-19 17:39:46', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(219, 'LgY2CxHy6', '2025-05-19 17:40:24', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(220, 'wGSHK7Dk0', '2025-05-19 17:41:10', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(221, 'oe9iHGa8N', '2025-05-19 17:41:37', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(222, '23y07d6ml', '2025-05-19 17:42:18', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(223, 'APwb3cUNX', '2025-05-19 17:42:47', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(224, 'ipIowdx76', '2025-05-19 17:43:15', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(225, 'kxRiG98sH', '2025-05-19 17:43:34', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(226, 'GJhLgziSv', '2025-05-19 23:38:57', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Pembuatan inter lock pada pintu slitter forming', '127012210', '', NULL, NULL),
(227, 'LWhRZxB5j', '2025-05-19 23:40:04', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Penambahan inter lock pada pintu slitter cutting', '127012210', '', NULL, NULL),
(228, 'lm18giv3H', '2025-05-19 23:44:16', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Pembuatan cover pada roller mesin blending', '127012210', '', NULL, NULL),
(239, 'WO2025Y5C', '2025-05-20 11:41:05', 'Ticket Submited. Kategori: Fabrikasi(Jig)', 'Perbaikan', '154412305', '', NULL, NULL),
(240, 'WO2025OWH', '2025-05-20 15:16:38', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Menyesuaikan ukuran Akrilik sehingga tidak ada celah pada mesin.', '145612310', '', NULL, NULL),
(241, 'WO2025SBR', '2025-05-20 15:16:42', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Menyesuaikan ukuran Akrilik sehingga tidak ada celah pada mesin.', '145612310', '', NULL, NULL),
(242, 'WO2025DS9', '2025-05-20 15:52:22', 'Ticket Submited. Kategori: Request(Request)', 'Pemasangan Interloc di pagar area cutting FELT', '145612310', '', NULL, NULL),
(243, 'WO2025KJQ', '2025-05-20 15:52:28', 'Ticket Submited. Kategori: Request(Request)', 'Pemasangan Interloc di pagar area cutting FELT', '145612310', '', NULL, NULL),
(244, 'WO2025HSB', '2025-05-20 15:52:34', 'Ticket Submited. Kategori: Request(Request)', 'Pemasangan Interloc di pagar area cutting FELT', '145612310', '', NULL, NULL),
(245, 'WO2025YS1', '2025-05-20 16:00:22', 'Ticket Submited. Kategori: Request(Request)', 'Pembuatan cover semi permanent di area mixing dan mesin Blending', '005711310', '', NULL, NULL),
(246, 'WO2025UQV', '2025-05-21 02:40:00', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '011911410', '', NULL, NULL),
(247, 'WO2025SL9', '2025-05-21 02:40:02', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '011911410', '', NULL, NULL),
(248, 'WO20256EV', '2025-05-21 02:40:07', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Plat bantalan rel oven poe rusak baud penahan lepas \r\n', '011911410', '', NULL, NULL),
(249, 'L9hYb0s6a', '2025-05-21 08:21:06', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(250, '59fCrgiqz', '2025-05-21 10:17:38', 'On Process', '', '002611305', '', NULL, NULL),
(251, '59fCrgiqz', '2025-05-21 10:22:05', 'Ticket Closed. Progress: 100 %', 'Penggantian Cutting', '002611305', 'WhatsApp_Image_2025-05-17_at_13_49_29.jpeg', '682d46dd78fc3.png', NULL),
(252, 'yuiUBY0x1', '2025-05-21 10:22:28', 'On Process', '', '072611806', '', NULL, NULL),
(253, '6hFuTNCqb', '2025-05-21 10:22:41', 'On Process', '', '072611806', '', NULL, NULL),
(254, 'XIUje7M5J', '2025-05-21 10:22:54', 'On Process', '', '072611806', '', NULL, NULL),
(255, 'rKQqX6zhk', '2025-05-21 10:23:05', 'On Process', '', '072611806', '', NULL, NULL),
(256, 'L9hYb0s6a', '2025-05-21 12:31:14', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(257, 'WO20256EV', '2025-05-21 12:41:56', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(258, 'WO2025SL9', '2025-05-21 12:42:17', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(259, 'WO20256EV', '2025-05-21 13:54:16', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(260, 'WO2025SL9', '2025-05-21 13:55:00', 'Ticket Rejected', 'Double WO', '159912408', '', NULL, NULL),
(261, 'LgY2CxHy6', '2025-05-21 15:19:17', 'On Process', '', '053811708', '', NULL, NULL),
(262, 'LgY2CxHy6', '2025-05-21 15:25:05', 'Ticket Closed. Progress: 100 %', 'Lampu sudah di lepas', '053811708', 'WhatsApp_Image_2025-05-21_at_15_27_12.jpeg', '682d8de20593b.png', NULL),
(263, 'WO2025A8G', '2025-05-21 15:44:17', 'Ticket Submited. Kategori: Repair(Repair building)', 'Repair Kaki Rak WIP Carpet', '159812407', '', NULL, NULL),
(264, 'WO2025YCT', '2025-05-21 15:45:20', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan Board Plan line carpet foto terlampir.', '145612310', '', NULL, NULL),
(265, 'WO2025DXT', '2025-05-21 15:46:20', 'Ticket Submited. Kategori: Repair(Repair building)', 'Convex Mirror dilakukan adjustment menghadap kearah Carpet', '159812407', '', NULL, NULL),
(266, 'WO2025JIL', '2025-05-21 23:32:09', 'Ticket Submited. Kategori: Request(Request)', 'Untuk mempermudah jika ada abnormal, penambahan didekat MP standby', '018511410', '', NULL, NULL),
(267, 'WO2025COT', '2025-05-22 03:49:51', 'Ticket Submited. Kategori: Request(Request)', 'Diantara mesin k.600 dan k.110, menutup celah agar material tidak masuk dan memudahkan saat cleaning\r\n', '018511410', '', NULL, NULL),
(268, 'kxRiG98sH', '2025-05-22 08:57:10', 'On Process', '', '053811708', '', NULL, NULL),
(269, 'kxRiG98sH', '2025-05-22 08:58:48', 'Ticket Closed. Progress: 100 %', 'Finger print sudah di ganti', '053811708', 'WhatsApp_Image_2025-05-21_at_21_11_00.jpeg', '682e84d8f20e6.png', NULL),
(270, '5JYSlHdwg', '2025-05-22 09:10:24', 'On Process', '', '072611806', '', NULL, NULL),
(271, 'oj0lNE5PA', '2025-05-22 09:10:31', 'On Process', '', '072611806', '', NULL, NULL),
(272, '6GnhIZvdJ', '2025-05-22 09:10:37', 'On Process', '', '072611806', '', NULL, NULL),
(273, '6GnhIZvdJ', '2025-05-22 10:08:31', 'Ticket Closed. Progress: 100 %', 'Sudah di buatkan ', '072611806', 'WhatsApp_Image_2025-05-21_at_22_10_20.jpeg', '682e952f3a788.png', NULL),
(274, '5JYSlHdwg', '2025-05-22 10:10:27', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-05-21_at_22_10_24.jpeg', '682e95a358101.png', NULL),
(275, '6hFuTNCqb', '2025-05-22 10:18:00', 'Ticket Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-05-15_at_13_44_06.jpeg', '682e9768d845a.png', NULL),
(276, 'rKQqX6zhk', '2025-05-22 10:19:09', 'Ticket Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-05-14_at_09_14_03.jpeg', '682e97adc0feb.png', NULL),
(277, 'yuiUBY0x1', '2025-05-22 10:24:01', 'Ticket Closed. Progress: 100 %', 'Palet sudah di repair', '072611806', 'WhatsApp_Image_2025-05-14_at_09_14_031.jpeg', '682e98d1711e1.png', NULL),
(278, 'XIUje7M5J', '2025-05-22 10:25:39', 'Ticket Closed. Progress: 100 %', 'Palet sudah di repair', '072611806', 'WhatsApp_Image_2025-05-14_at_09_14_03_(1).jpeg', '682e993308737.png', NULL),
(279, 'WO2025MQ1', '2025-05-22 10:52:06', 'Ticket Submited. Kategori: Support(Support)', 'Pemindahan pipa vacum wj,tabung angin dan mc shimizu ke area dekat conveyor bertujuan untuk akses jalan mp saat proses produksi', '145612310', '', NULL, NULL),
(280, 'WO20252Y9', '2025-05-22 11:02:16', 'Ticket Submited. Kategori: Request(Request)', 'Pemindahan panel oven yang sudah tidak diperlukan/difungsikan', '145612310', '', NULL, NULL),
(281, 'WO20252Y9', '2025-05-22 12:50:18', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(282, 'WO2025MQ1', '2025-05-22 12:50:39', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(283, 'WO2025COT', '2025-05-22 12:50:44', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(284, 'WO2025JIL', '2025-05-22 12:50:51', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(285, 'WO2025YCT', '2025-05-22 12:50:56', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(286, 'WO2025UQV', '2025-05-22 12:51:21', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(287, 'WO2025YS1', '2025-05-22 12:51:29', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(288, 'WO2025HSB', '2025-05-22 12:51:35', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(289, 'WO2025KJQ', '2025-05-22 12:51:42', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(290, 'GJhLgziSv', '2025-05-22 12:51:59', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(291, 'WO2025DS9', '2025-05-22 12:52:12', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(292, 'WO2025OWH', '2025-05-22 12:52:23', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(293, 'lm18giv3H', '2025-05-22 12:52:34', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(294, 'LWhRZxB5j', '2025-05-22 12:52:46', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(295, 'WO2025SBR', '2025-05-22 12:53:11', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(296, 'WO20256RW', '2025-05-22 13:47:30', 'Ticket Submited. Kategori: Request(Request)', 'Pemindahan posisi vacum wj,tabung angin dan mc shimizu ke dekat conveyor yang bertujuan untuk akses jalan saat produksi berlangsung', '145612310', '', NULL, NULL),
(297, 'WO2025A6L', '2025-05-22 13:49:06', 'Ticket Submited. Kategori: Request(Request)', 'Pembongkaran/pemindahan mesin yang sudah tidak digunakan (panel oven carpet)', '145612310', '', NULL, NULL),
(298, 'APwb3cUNX', '2025-05-22 14:37:42', 'On Process', '', '053811708', '', NULL, NULL),
(299, 'APwb3cUNX', '2025-05-22 14:43:34', 'Progress: 50 %', 'Push button sudah terpasang di panel cutting, tinggal narik kabel dari panel cutting ke panel forming', '053811708', 'WhatsApp_Image_2025-05-22_at_06_36_30.jpeg', '682ed5a6942f1.png', NULL),
(300, 'WO2025A6L', '2025-05-22 14:46:25', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(301, 'WO20256RW', '2025-05-22 14:46:47', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(302, 'WO20256RW', '2025-05-22 15:25:58', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(303, 'WO20252Y9', '2025-05-22 15:26:26', 'Ticket Rejected', 'Double WO ya neng', '159912408', '', NULL, NULL),
(304, 'WO2025MQ1', '2025-05-22 15:26:59', 'Ticket Rejected', 'Double deui WO na', '159912408', '', NULL, NULL),
(305, 'WO2025COT', '2025-05-22 15:27:34', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(306, 'WO2025JIL', '2025-05-22 15:27:53', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(307, 'WO2025YCT', '2025-05-22 15:28:08', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(308, 'WO2025YS1', '2025-05-22 15:29:23', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(309, 'WO2025HSB', '2025-05-22 15:29:54', 'Ticket Rejected', 'WO to Engineering', '159912408', '', NULL, NULL),
(310, 'WO2025KJQ', '2025-05-22 15:30:17', 'Ticket Rejected', 'WO to Engineering', '159912408', '', NULL, NULL),
(311, 'WO2025DS9', '2025-05-22 15:32:02', 'Ticket Rejected', 'WO to Engineering', '159912408', '', NULL, NULL),
(312, 'WO2025SBR', '2025-05-22 15:32:19', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(313, 'WO2025OWH', '2025-05-22 15:34:23', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(314, 'lm18giv3H', '2025-05-22 15:34:43', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(315, 'LWhRZxB5j', '2025-05-22 15:35:07', 'Ticket Rejected', 'WO to Engineering', '159912408', '', NULL, NULL),
(316, 'GJhLgziSv', '2025-05-22 15:35:27', 'Ticket Rejected', 'WO to Engineering', '159912408', '', NULL, NULL),
(317, 'WO2025UQV', '2025-05-22 15:35:38', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(318, 'WO2025FGZ', '2025-05-22 16:25:34', 'Ticket Submited. Kategori: Support(Support)', 'Relayout Area Tim Delivery :\r\n1. Instalasi Listrik\r\n2. Pemasangan Papan Kuning pada Tembok', '159812407', '', NULL, NULL),
(319, 'WO2025SB9', '2025-05-22 16:26:55', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Pengecekan Rem Wh01 yang blong', '159812407', '', NULL, NULL),
(320, 'WO2025SB9', '2025-05-22 16:50:42', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(321, 'WO2025FGZ', '2025-05-22 16:50:53', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(322, 'WO2025DXT', '2025-05-22 16:51:07', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(323, 'WO2025A8G', '2025-05-22 16:51:21', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(324, 'WO2025CGI', '2025-05-23 01:33:11', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan/pergantian kipas meja inpeksi N5 depan mati 1 pcs\r\nPerbaikan kipas meja inpeksi N6 belakang rusak ( baling baling lepas )', '107612010', '', NULL, NULL),
(325, 'WO2025NAB', '2025-05-23 01:46:22', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan lampu penerangan meja assy rul 4 \r\n', '011911410', '', NULL, NULL),
(326, 'WO2025NAB', '2025-05-23 08:20:09', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(327, 'WO2025CGI', '2025-05-23 08:20:29', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(328, 'WO2025NAB', '2025-05-23 09:27:13', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(329, 'WO2025CGI', '2025-05-23 09:27:28', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(330, 'WO2025SB9', '2025-05-23 09:27:47', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(331, 'WO2025FGZ', '2025-05-23 09:28:09', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(332, 'WO2025A6L', '2025-05-23 09:28:21', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(333, 'WO2025DXT', '2025-05-23 09:28:40', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(334, 'WO2025A8G', '2025-05-23 09:28:52', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(335, 'WO2025FGZ', '2025-05-23 09:41:18', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(336, 'WO2025COT', '2025-05-23 09:42:37', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(337, 'WO2025DXT', '2025-05-23 09:43:24', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(338, 'WO2025YCT', '2025-05-23 09:43:53', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(339, 'lm18giv3H', '2025-05-23 09:46:07', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(340, 'WO2025JIL', '2025-05-23 09:50:44', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(341, 'WO2025A6L', '2025-05-23 09:52:53', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(342, 'WO2025SB9', '2025-05-23 09:53:17', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(343, 'WO2025CGI', '2025-05-23 09:53:57', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(344, 'WO2025NAB', '2025-05-23 09:54:25', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(345, 'L9hYb0s6a', '2025-05-23 09:55:36', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(346, 'WO20256RW', '2025-05-23 09:55:53', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(347, 'WO2025UQV', '2025-05-23 09:59:20', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(348, 'WO20256EV', '2025-05-23 09:59:57', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(349, 'WO2025A8G', '2025-05-23 10:00:26', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(350, 'WO2025KF5', '2025-05-23 11:00:57', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Ganti soket nanaboshi press N1 dan N2 atas bawah dengan yang karena pembacaan temperatur dies sering tidak aktual', '044811610', '', NULL, NULL),
(351, 'WO2025OY9', '2025-05-23 11:03:34', 'Ticket Submited. Kategori: Repair(Repair building)', 'Kebocoran atap yang parah di arean depan N1 dan belakang N1 \r\n', '044811610', '', NULL, NULL),
(352, 'WO2025YS1', '2025-05-24 10:11:59', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(353, 'WO2025SBR', '2025-05-24 10:12:17', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(354, 'WO2025OWH', '2025-05-24 10:12:32', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(355, 'WO2025OWH', '2025-05-26 08:36:16', 'On Process', '', '072611806', '', NULL, NULL),
(356, 'WO2025YCT', '2025-05-26 08:36:25', 'On Process', '', '072611806', '', NULL, NULL),
(357, 'lm18giv3H', '2025-05-26 08:36:30', 'On Process', '', '072611806', '', NULL, NULL),
(358, 'WO2025COT', '2025-05-26 08:36:43', 'On Process', '', '072611806', '', NULL, NULL),
(359, 'WO2025DXT', '2025-05-26 08:36:54', 'On Process', '', '072611806', '', NULL, NULL),
(360, 'WO2025A8G', '2025-05-26 08:36:59', 'On Process', '', '072611806', '', NULL, NULL),
(361, 'WO20256EV', '2025-05-26 08:37:03', 'On Process', '', '072611806', '', NULL, NULL),
(362, 'WO2025UQV', '2025-05-26 08:37:12', 'On Process', '', '072611806', '', NULL, NULL),
(363, 'oj0lNE5PA', '2025-05-26 08:54:10', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki bagian yang tidak terpotong dan di support team produksi a/n ilham', '072611806', 'WhatsApp_Image_2025-05-26_at_08_55_27.jpeg', '6833c9c288f0c.png', NULL),
(364, 'WO20256EV', '2025-05-26 08:55:19', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki bagian plat rel yg rusak', '072611806', 'WhatsApp_Image_2025-05-25_at_09_33_09.jpeg', '6833ca073cf3e.png', NULL),
(365, 'WO2025A8G', '2025-05-26 09:04:59', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki kaki rak wip yang rusak', '072611806', 'WhatsApp_Image_2025-05-25_at_07_13_59_(1).jpeg', '6833cc4b67ffa.png', NULL),
(366, 'WO2025COT', '2025-05-26 09:08:20', 'Ticket Closed. Progress: 100 %', 'Sudah di tambahkan impraboard bagian celah mesin', '072611806', 'WhatsApp_Image_2025-05-25_at_07_13_58_(2).jpeg', '6833cd140ec36.png', NULL),
(367, 'WO2025UQV', '2025-05-26 09:13:44', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki plat yang rusak di rel mesin peo', '072611806', 'WhatsApp_Image_2025-05-25_at_09_33_091.jpeg', '6833ce58b8f21.png', NULL),
(368, 'lm18giv3H', '2025-05-26 09:16:05', 'Ticket Closed. Progress: 100 %', 'Sudah di tambahkan cover dri plat besi', '072611806', 'WhatsApp_Image_2025-05-25_at_07_13_58_(1).jpeg', '6833cee5cda8f.png', NULL),
(369, 'WO2025SBR', '2025-05-26 09:27:45', 'Pending', '', '072611806', '', NULL, NULL),
(370, 'WO2025YS1', '2025-05-26 09:35:53', 'On Process', '', '072611806', '', NULL, NULL),
(371, 'WO2025SBR', '2025-05-26 09:44:19', 'On Process', '', '072611806', '', NULL, NULL),
(372, 'WO2025DXT', '2025-05-26 09:47:23', 'Ticket Closed. Progress: 100 %', 'Sudah di geser sesuai request', '072611806', 'WhatsApp_Image_2025-05-25_at_07_13_58_(3).jpeg', '6833d63b5511b.png', NULL),
(373, 'WO2025YCT', '2025-05-26 09:48:14', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-05-25_at_07_13_59.jpeg', '6833d66e8bb0e.png', NULL),
(374, 'WO2025YS1', '2025-05-26 09:51:02', 'Ticket Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-05-26_at_09_36_59.jpeg', '6833d7167e0f8.png', NULL),
(375, 'oe9iHGa8N', '2025-05-26 09:52:17', 'On Process', '', '053811708', '', NULL, NULL),
(376, 'oe9iHGa8N', '2025-05-26 09:53:20', 'Ticket Closed. Progress: 100 %', 'Stop kontak sudah diganti', '053811708', 'WhatsApp_Image_2025-05-23_at_23_05_28.jpeg', '6833d7a0ec3eb.png', NULL),
(377, 'yAwD4Mf6v', '2025-05-26 09:54:10', 'On Process', '', '053811708', '', NULL, NULL),
(378, 'yAwD4Mf6v', '2025-05-26 09:56:54', 'Ticket Closed. Progress: 100 %', 'Ganti kanvas dan master rem bagian kiri dan kanan', '053811708', 'WhatsApp_Image_2025-05-23_at_18_48_35.jpeg', '6833d876acdf5.png', NULL),
(379, 'WO2025SB9', '2025-05-26 09:59:10', 'On Process', '', '053811708', '', NULL, NULL),
(380, 'WO2025SB9', '2025-05-26 10:00:21', 'Ticket Closed. Progress: 100 %', 'Ganti kanvas dan master rem', '053811708', 'WhatsApp_Image_2025-05-23_at_18_48_351.jpeg', '6833d9451f959.png', NULL),
(381, 'WO2025HX7', '2025-05-26 10:02:50', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG penuh sudah tidak ada area untuk penyimpanan\r\nPalet NG saat ini ada di Area :\r\n1.samping gudang solar\r\n2.depam gudang solar', '047511607', '', NULL, NULL),
(382, 'WO2025ZNI', '2025-05-26 14:15:33', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 22-24 Mei 2025', '047511607', '', NULL, NULL),
(383, 'WO20257NY', '2025-05-26 15:40:19', 'Ticket Submited. Kategori: Support(Support)', 'Address sudah tersedia di area Raw Material', '159812407', '', NULL, NULL),
(384, 'WO20257JR', '2025-05-26 15:41:38', 'Ticket Submited. Kategori: Support(Support)', 'Mohon support untuk pengecekan Ampere pada Charger Forklift WH04 dan Kalibrasi indikator Baterai pada Forklift WH04', '159812407', '', NULL, NULL),
(385, 'WO2025KF5', '2025-05-27 07:28:59', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(386, 'WO2025OY9', '2025-05-27 07:29:05', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(387, 'L9hYb0s6a', '2025-05-27 09:55:20', 'On Process', '', '002611305', '', NULL, NULL),
(388, 'WO2025A6L', '2025-05-27 09:55:38', 'On Process', '', '002611305', '', NULL, NULL),
(389, 'L9hYb0s6a', '2025-05-27 09:56:37', 'Ticket Closed. Progress: 100 %', 'Instalasi mesin baru', '002611305', 'WhatsApp_Image_2025-05-17_at_13_49_291.jpeg', '683529e599c45.png', NULL),
(390, 'WO2025A6L', '2025-05-27 09:59:43', 'Ticket Closed. Progress: 100 %', 'Uninstall Panel ex heater oven', '002611305', 'WhatsApp_Image_2025-05-25_at_18_27_58.jpeg', '68352a9f5dc86.png', NULL),
(391, '23y07d6ml', '2025-05-27 10:00:49', 'On Process', '', '002611305', '', NULL, NULL),
(392, '23y07d6ml', '2025-05-27 10:01:44', 'Ticket Closed. Progress: 100 %', 'Perbaikan plat rel', '002611305', 'WhatsApp_Image_2025-05-27_at_10_04_11.jpeg', '68352b18978dd.png', NULL),
(393, 'WO20257Y6', '2025-05-27 10:27:10', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 26 mei 2025', '047511607', '', NULL, NULL),
(394, 'WO2025FWA', '2025-05-27 10:33:20', 'Ticket Submited. Kategori: Repair(Repair dies)', 'Repair dies hood 2vf cavity 1', '128012210', '', NULL, NULL),
(395, 'WO20259ED', '2025-05-27 10:34:09', 'Ticket Submited. Kategori: Request(Request)', 'Sekat box Hood su2id fl 6 pcs untuk pengganti sekat box yang NG return customer', '047511607', '', NULL, NULL),
(396, 'WO2025C9Z', '2025-05-27 11:13:32', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikkan pagar kuning suplay matrial dan palet F/G di NVH DEPAN', '128012210', '', NULL, NULL),
(397, 'WO20256TP', '2025-05-27 11:15:41', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Perbaikan baling baling dan kaki kaki kipas stand nvh depan', '128012210', '', NULL, NULL),
(398, 'WO2025UXQ', '2025-05-27 13:02:28', 'Ticket Submited. Kategori: Fabrikasi(Dies)', 'Ketika jalan produksi cowl mmki, part cowl mmki cavity 1 (6320A412) terbakar, dengan temperatur std 180+/-20 tetapi actual di dies 195\'', '128012210', '', NULL, NULL),
(399, 'WO2025YO2', '2025-05-27 13:23:48', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Modifikasi penambahan dudukan pada semua pallet untuk RFID', '159812407', '', NULL, NULL),
(400, 'WO2025CB0', '2025-05-27 13:24:53', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Modifikasi Pallet Asphalt HMMI untuk Project ISUZU', '159812407', '', NULL, NULL),
(401, 'WO2025KF5', '2025-05-27 15:10:01', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(402, 'WO2025RKY', '2025-05-27 15:41:50', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Perbaikan Sekat Box Hood F/L (3 Box)', '159812407', '', NULL, NULL),
(403, 'WO2025UXQ', '2025-05-28 07:09:21', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(404, 'WO20256TP', '2025-05-28 07:09:35', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(405, 'WO2025C9Z', '2025-05-28 07:10:19', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(406, 'WO2025FWA', '2025-05-28 07:10:29', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(407, 'WO2025O80', '2025-05-28 07:41:23', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 27 Mei 2025', '047511607', '', NULL, NULL),
(408, 'WO2025E1L', '2025-05-28 10:15:48', 'Ticket Submited. Kategori: Request(Request)', 'Kebutuhan untuk tali packing palet produksi hari ini \r\n100 pcs', '047511607', '', NULL, NULL),
(409, 'WO2025VQI', '2025-05-28 10:25:44', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet berkarat & cover plastik NG total 20 unit :\r\n1.PLT-AA no.43,47,32,82,44,98,91,84,85,115,27,62,61,124,121,16\r\n2.PLT-U no.28,23,35,22', '047511607', '', NULL, NULL),
(410, 'WO2025VQI', '2025-05-28 16:29:10', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(411, 'WO2025E1L', '2025-05-28 16:29:17', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(412, 'WO2025O80', '2025-05-28 16:29:53', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(413, 'WO2025RKY', '2025-05-28 16:30:07', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(414, 'WO2025CB0', '2025-05-28 16:30:18', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(415, 'WO2025YO2', '2025-05-28 16:30:28', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(416, 'WO20259ED', '2025-05-28 16:30:42', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(417, 'WO20257Y6', '2025-05-28 16:30:55', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(418, 'WO20257JR', '2025-05-28 16:31:25', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(419, 'WO20257NY', '2025-05-28 16:31:38', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(420, 'WO2025ZNI', '2025-05-28 16:32:00', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(421, 'WO20255IS', '2025-06-02 08:37:45', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 28 Mei 2025', '047511607', '', NULL, NULL),
(422, 'WO2025VQI', '2025-06-02 10:42:27', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(423, 'WO2025E1L', '2025-06-02 10:43:52', 'Ticket Rejected', 'Mohon maaf keterangan kurang jelas, dan photo tidak bisa dilihat.', '159912408', '', NULL, NULL),
(424, 'WO2025O80', '2025-06-02 10:44:30', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(425, 'WO2025RKY', '2025-06-02 10:44:43', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(426, 'WO2025VQI', '2025-06-02 10:44:59', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(427, 'WO2025CB0', '2025-06-02 10:45:05', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(428, 'WO2025YO2', '2025-06-02 10:45:19', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(429, 'WO2025O80', '2025-06-02 10:45:27', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(430, 'WO2025RKY', '2025-06-02 10:45:51', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(431, 'WO2025CB0', '2025-06-02 10:46:12', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(432, 'WO2025UXQ', '2025-06-02 10:46:17', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(433, 'WO2025YO2', '2025-06-02 10:46:30', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(434, 'WO20256TP', '2025-06-02 10:46:42', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(435, 'WO2025UXQ', '2025-06-02 10:46:54', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(436, 'WO2025C9Z', '2025-06-02 10:46:56', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(437, 'WO20259ED', '2025-06-02 10:47:08', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(438, 'WO2025C9Z', '2025-06-02 10:47:11', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(439, 'WO2025FWA', '2025-06-02 10:47:20', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(440, 'WO20257Y6', '2025-06-02 10:47:31', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(441, 'WO20256TP', '2025-06-02 10:47:34', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(442, 'WO20259ED', '2025-06-02 10:47:54', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(443, 'WO2025FWA', '2025-06-02 10:48:12', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(444, 'WO20257JR', '2025-06-02 10:48:24', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(445, 'WO20257Y6', '2025-06-02 10:48:25', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(446, 'WO20257NY', '2025-06-02 10:48:44', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(447, 'WO2025ZNI', '2025-06-02 10:49:01', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(448, 'WO20257JR', '2025-06-02 10:50:17', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(449, 'WO2025KF5', '2025-06-02 10:50:40', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(450, 'WO20257NY', '2025-06-02 10:52:10', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(451, 'WO2025ZNI', '2025-06-02 10:52:24', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(452, 'WO20255IS', '2025-06-02 11:16:11', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(453, 'WO20255IS', '2025-06-02 11:18:13', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(454, 'APwb3cUNX', '2025-06-02 14:07:45', 'Ticket Closed. Progress: 100 %', 'Push button tombol auto stop mesin forming sudah terpasang di mesin cutting felt, dan sudah berfungsi\r\n', '053811708', 'WhatsApp_Image_2025-05-22_at_06_36_301.jpeg', '683d4dc202b02.png', NULL),
(455, 'WO2025JIL', '2025-06-02 14:08:30', 'Pending', '', '053811708', '', NULL, NULL),
(456, 'WO2025JIL', '2025-06-02 14:08:40', 'On Process', '', '053811708', '', NULL, NULL),
(457, 'ipIowdx76', '2025-06-02 14:09:03', 'On Process', '', '053811708', '', NULL, NULL),
(458, 'ipIowdx76', '2025-06-02 14:16:32', 'Ticket Closed. Progress: 100 %', 'Cctv sudah terpasang oleh mas faiq, tinggal setting ip addres by pak luthfi', '053811708', 'WhatsApp_Image_2025-06-02_at_14_15_39.jpeg', '683d4fd0d5e94.png', NULL),
(459, 'WO2025HX7', '2025-06-02 16:03:26', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(460, 'WO20255IS', '2025-06-02 16:45:00', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(461, 'WO20258EE', '2025-06-02 16:51:28', 'Ticket Submited. Kategori: Fabrikasi(Jig)', 'Troley di buat tinggi seperti meja troley yg sudah ada / yg lain nya', '005711310', '', NULL, NULL),
(462, 'WO2025SEL', '2025-06-02 16:53:11', 'Ticket Submited. Kategori: Support(Support)', 'Cover kabel di buat di atas sehingga tidak sering terinjak dan kotor scrap triming', '005711310', '', NULL, NULL),
(463, 'WO2025R4L', '2025-06-02 16:55:04', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Penggantian plastik layar monitor , agar pembacaan tidak buram', '005711310', '', NULL, NULL),
(464, 'WO2025UMU', '2025-06-02 16:56:42', 'Ticket Submited. Kategori: Repair(Repair jig)', 'Roda jig rusak dan patah', '005711310', '', NULL, NULL),
(465, 'WO2025WI5', '2025-06-02 16:59:02', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Pembuatan cover pada sisi kiri dan kanan belt agar tidak ada celah tangan untuk bisa masuk ke belt, pastikan cover tidak terlalu besar sehingga tidak mempengaruhi laju material', '005711310', '', NULL, NULL),
(466, 'WO2025VE6', '2025-06-02 17:01:21', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Pemindahan legran meja heater dari R4B ke R4A', '005711310', '', NULL, NULL),
(467, 'WO20251LU', '2025-06-02 17:04:45', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan dudukan tombol patah', '005711310', '', NULL, NULL),
(468, 'WO20256K5', '2025-06-02 17:07:39', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Melepas dudukan kipas yg sudah tidak terpakai ( R1B,R1C,R4C,R4B)', '005711310', '', NULL, NULL),
(469, 'WO2025XHM', '2025-06-02 17:23:24', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan kipas angin R3A bagian dalam, dudukan rusak dan di tali', '005711310', '', NULL, NULL),
(470, 'WO2025TGS', '2025-06-02 17:25:53', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tangga oven di buat menjadi permanet tidak bongkar pasang sehingga tidak mudah mleset saat operator naik', '005711310', '', NULL, NULL),
(471, 'WO2025U5I', '2025-06-02 17:28:31', 'Ticket Submited. Kategori: Support(Support)', 'Perbaikan lampu meja hotmelt RUL 1 Mati', '005711310', '', NULL, NULL),
(472, 'WO2025X6C', '2025-06-02 17:31:39', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Pembuatan tangga yg permaen dan juga safety', '005711310', '', NULL, NULL),
(473, 'WO2025MTC', '2025-06-02 17:36:40', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Pembuatan pembatas / pelindung agar palet recyce tidak menabrak conveyor vacum transfer', '005711310', '', NULL, NULL),
(474, 'WO2025U2U', '2025-06-02 17:38:07', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Selang angin tidak rapi dan melambai', '005711310', '', NULL, NULL),
(475, 'WO2025SNF', '2025-06-02 17:40:21', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Coupler selang ciller bocor dan kran tidak bisa menutup sempurna', '005711310', '', NULL, NULL),
(476, 'WO2025QRY', '2025-06-02 17:42:54', 'Ticket Submited. Kategori: Request(Request)', 'Tangga bekas mesin press sudah tidak di gunakan dan belum di rapikan ', '005711310', '', NULL, NULL),
(477, 'WO2025WFO', '2025-06-02 17:44:54', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Banyak buzzer oven 1 sampai 8 sudah tidak ada suara nya, dan juga sudah lirih tidak jelas', '005711310', '', NULL, NULL),
(478, 'WO2025KCA', '2025-06-02 17:46:38', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Cover mesin blending banyak yg tidak lengkap bautnya, minta cek dan pembaruan baut yg tidak proper nya', '005711310', '', NULL, NULL),
(479, 'WO2025HQQ', '2025-06-02 17:48:26', 'Ticket Submited. Kategori: Request(Request)', 'Kabel tidak rapi dan melambai', '005711310', '', NULL, NULL),
(480, 'WO2025YDH', '2025-06-02 17:50:25', 'Ticket Submited. Kategori: Request(Request)', 'Pembuatan cover pada bagian bawah tiang mesin press R1A, R1B dan R1C', '005711310', '', NULL, NULL),
(481, 'WO2025RGU', '2025-06-02 21:29:24', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Kran angin mesin R3C rusak', '018611410', '', NULL, NULL),
(482, 'WO20257UH', '2025-06-02 21:30:49', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tampungan oli slide mesin R3B rusak', '018611410', '', NULL, NULL),
(483, 'WO2025BSV', '2025-06-02 21:32:10', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Lampu bagian atas mesin R3C redup ', '018611410', '', NULL, NULL),
(484, 'WO202551F', '2025-06-02 21:34:10', 'Ticket Submited. Kategori: Repair(Repair building)', 'Lampu gedung diantara RUL 2 dan RUL 3 mati 2 pcs', '018611410', '', NULL, NULL),
(485, 'WO2025PIA', '2025-06-02 21:35:26', 'Ticket Submited. Kategori: Repair(Repair building)', 'Lampu gedung diantara RUL 1 dan RUL 2 mati 1', '018611410', '', NULL, NULL),
(486, 'WO2025J4R', '2025-06-02 21:36:37', 'Ticket Submited. Kategori: Repair(Repair building)', 'Lampu gedung diarea pojok RUL 1 (Gerbang baru) mati 1', '018611410', '', NULL, NULL),
(487, 'WO2025J8S', '2025-06-02 21:37:38', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Lampu mesin bagian dalam R2A mati 2 ', '018611410', '', NULL, NULL),
(488, 'WO20251HN', '2025-06-02 21:38:47', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tirai belakang oven 3 rusak', '018611410', '', NULL, NULL),
(489, 'WO2025STU', '2025-06-02 21:39:41', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Tirai belakang oven 4 rusak', '018611410', '', NULL, NULL),
(490, 'WO2025V0W', '2025-06-02 21:40:55', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Pengunci tombol two hand operate mesin R2C rusak', '018611410', '', NULL, NULL),
(491, 'WO202587L', '2025-06-02 21:44:44', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan pintu pada pagar samping oven 4. Kondisi saat ini jika terdapat material gagal feeding, operator harus masuk ke bagian bawah oven untuk mengambil material yang jatuh sehingga kurang safety.', '018611410', '', NULL, NULL),
(492, 'WO2025UDT', '2025-06-03 09:58:41', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 30 mei - 02 juni 2025', '047511607', '', NULL, NULL),
(493, 'WO2025KF5', '2025-06-04 08:35:52', 'On Process', '', '002611305', '', NULL, NULL),
(494, 'WO2025KF5', '2025-06-04 08:36:53', 'Ticket Closed. Progress: 100 %', 'Nanaboshi sudah diganti baru', '002611305', 'WhatsApp_Image_2025-06-04_at_08_37_43.jpeg', '683fa33594660.png', NULL),
(495, 'wGSHK7Dk0', '2025-06-04 08:40:44', 'On Process', '', '002611305', '', NULL, NULL),
(496, 'wGSHK7Dk0', '2025-06-04 08:41:51', 'Ticket Closed. Progress: 100 %', 'Posisi emergency sudah di pindah dan ganti emergency baru', '002611305', 'WhatsApp_Image_2025-06-04_at_08_43_54.jpeg', '683fa45f22485.png', NULL),
(497, 'WO2025JIL', '2025-06-04 08:46:47', 'Ticket Closed. Progress: 100 %', 'Emergency sudah terpasang.', '053811708', 'WhatsApp_Image_2025-06-04_at_08_48_08.jpeg', '683fa58754284.png', NULL),
(498, 'WO2025WYT', '2025-06-04 12:33:39', 'Ticket Submited. Kategori: Request(Request)', 'Baut Roda belakang kurang satu. Mohon diadvance karena berkaitan dengan Safety', '159812407', '', NULL, NULL),
(499, 'WO2025NLD', '2025-06-04 12:39:18', 'Ticket Submited. Kategori: Repair(Repair building)', 'Perbaikan Engsel dan pemasangan kembali plat pada Engsel', '159812407', '', NULL, NULL),
(500, 'WO2025K2H', '2025-06-04 12:41:32', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Lampu Sign sebelah kanan mati. Mohon diadvance karena bekaitan dengan safety', '159812407', '', NULL, NULL),
(501, 'WO2025K2H', '2025-06-04 12:45:01', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(502, 'WO2025NLD', '2025-06-04 12:45:20', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL);
INSERT INTO `tracking` (`id_tracking`, `id_ticket`, `tanggal`, `status`, `deskripsi`, `id_user`, `filefoto`, `signature`, `answerfoto`) VALUES
(503, 'WO2025WYT', '2025-06-04 12:45:43', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(504, 'WO2025UDT', '2025-06-04 12:45:57', 'Ticket Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(505, 'WO2025CB0', '2025-06-04 15:57:25', 'On Process', '', '072611806', '', NULL, NULL),
(506, 'WO2025CB0', '2025-06-04 16:08:04', 'Ticket Closed. Progress: 100 %', 'Sudah dibuakan 1 palet untuk prototype , jika sudah oke. silahkan request lagi. 1 minggu bisa bikin 1 palet saja yaa pak.', '072611806', 'WhatsApp_Image_2025-06-04_at_11_11_28.jpeg', '68400cf443f69.png', NULL),
(507, 'WO2025QI4', '2025-06-04 23:09:15', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Menghilangkat tempat clip pada meja inpeksi N4 belakang', '107612010', '', NULL, NULL),
(508, 'WO2025ZLV', '2025-06-04 23:12:02', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan meja inpeksi N5 belakang ( melengkung ) agar lurus seperti meja lainnya', '107612010', '', NULL, NULL),
(509, 'WO2025ZLV', '2025-06-05 08:19:19', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(510, 'WO2025QI4', '2025-06-05 08:19:34', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(511, 'WO20257UH', '2025-06-05 08:19:48', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(512, 'WO2025PIA', '2025-06-05 08:19:54', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(513, 'WO2025STU', '2025-06-05 08:20:23', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(514, 'WO2025V0W', '2025-06-05 08:20:27', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(515, 'WO2025J8S', '2025-06-05 08:20:30', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(516, 'WO20251HN', '2025-06-05 08:20:34', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(517, 'WO202587L', '2025-06-05 08:21:03', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(518, 'WO2025J4R', '2025-06-05 08:21:11', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(519, 'WO202551F', '2025-06-05 08:21:22', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(520, 'WO2025BSV', '2025-06-05 08:21:42', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(521, 'WO2025RGU', '2025-06-05 08:21:55', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(522, 'WO2025YDH', '2025-06-05 08:22:29', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(523, 'WO2025HQQ', '2025-06-05 08:23:42', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(524, 'WO2025KCA', '2025-06-05 08:23:51', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(525, 'WO2025WFO', '2025-06-05 08:24:34', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(526, 'WO2025QRY', '2025-06-05 08:24:40', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(527, 'WO2025SNF', '2025-06-05 08:24:46', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(528, 'WO2025U2U', '2025-06-05 08:24:51', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(529, 'WO2025MTC', '2025-06-05 08:24:57', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(530, 'WO2025X6C', '2025-06-05 08:25:08', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(531, 'WO2025U5I', '2025-06-05 08:25:16', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(532, 'WO2025TGS', '2025-06-05 08:25:23', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(533, 'WO2025XHM', '2025-06-05 08:26:37', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(534, 'WO20256K5', '2025-06-05 08:26:46', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(535, 'WO20251LU', '2025-06-05 08:26:52', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(536, 'WO2025VE6', '2025-06-05 08:27:02', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(537, 'WO2025WI5', '2025-06-05 08:27:45', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(538, 'WO2025UMU', '2025-06-05 08:27:53', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(539, 'WO2025R4L', '2025-06-05 08:28:00', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(540, 'WO2025SEL', '2025-06-05 08:28:09', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(541, 'WO20258EE', '2025-06-05 08:28:15', 'Ticket Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(542, 'WO2025DNP', '2025-06-05 09:20:51', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return customer tanggal 03-04 Juni 2025', '047511607', '', NULL, NULL),
(543, 'WO2025DIQ', '2025-06-05 09:23:47', 'Ticket Submited. Kategori: Request(Request)', 'Pembuatan sekat karpet untuk palet Outer YHA', '047511607', '', NULL, NULL),
(544, 'WO2025ZLV', '2025-06-05 10:39:27', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(545, 'WO2025QI4', '2025-06-05 10:39:40', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(546, 'WO2025K2H', '2025-06-05 10:40:01', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(547, 'WO2025NLD', '2025-06-05 10:40:48', 'Ticket Returned', 'Tolong siapkan engselnya, jika sudah ready ajukan kembali WO nya', '159912408', '', NULL, NULL),
(548, 'WO2025WYT', '2025-06-05 10:41:02', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(549, 'WO2025UDT', '2025-06-05 10:41:12', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(550, 'WO2025V0W', '2025-06-05 10:43:14', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(551, 'WO2025STU', '2025-06-05 10:43:37', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(552, 'WO20251HN', '2025-06-05 10:43:50', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(553, 'WO2025J8S', '2025-06-05 10:44:06', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(554, 'WO2025J4R', '2025-06-05 10:44:17', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(555, 'WO2025PIA', '2025-06-05 10:44:34', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(556, 'WO202551F', '2025-06-05 10:44:44', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(557, 'WO2025BSV', '2025-06-05 10:44:57', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(558, 'WO20257UH', '2025-06-05 10:45:09', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(559, 'WO2025RGU', '2025-06-05 10:45:40', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(560, 'WO2025HQQ', '2025-06-05 10:45:53', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(561, 'WO2025YDH', '2025-06-05 10:46:04', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(562, 'WO2025KCA', '2025-06-05 10:46:41', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(563, 'WO2025WFO', '2025-06-05 10:46:59', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(564, 'WO2025QRY', '2025-06-05 10:48:26', 'Ticket Rejected', 'Mohon untuk didisposal sendiri/WO ini arahkan ke engineering (Pak Rahadian)', '159912408', '', NULL, NULL),
(565, 'WO2025SNF', '2025-06-05 10:49:14', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(566, 'WO2025U2U', '2025-06-05 10:49:27', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(567, 'WO2025X6C', '2025-06-05 10:51:48', 'Ticket Returned', 'Tolong buatkan design tangga safety yang diinginkan seperti apa. Supaya sesuai dengan yang diinginkan', '159912408', '', NULL, NULL),
(568, 'WO2025U5I', '2025-06-05 10:52:04', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(569, 'WO2025TGS', '2025-06-05 10:53:07', 'Ticket Returned', 'Kami sedang membuatkan 1 contoh tangga yang proper, jika sudah sesuai WO ini bisa dijalankan', '159912408', '', NULL, NULL),
(570, 'WO2025XHM', '2025-06-05 10:53:28', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(571, 'WO20256K5', '2025-06-05 10:53:46', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(572, 'WO20251LU', '2025-06-05 10:54:12', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(573, 'WO2025VE6', '2025-06-05 10:54:28', 'Ticket Assign To', 'Ticket Assign to SPVU', '159912408', '', NULL, NULL),
(574, 'WO2025WI5', '2025-06-05 10:54:47', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(575, 'WO2025UMU', '2025-06-05 10:55:09', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(576, 'WO2025R4L', '2025-06-05 10:55:48', 'Ticket Rejected', 'Mohon diganti sendiri ya', '159912408', '', NULL, NULL),
(577, 'WO2025SEL', '2025-06-05 10:56:10', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(578, 'WO20258EE', '2025-06-05 10:57:31', 'Ticket Returned', 'Apakah troli ini punya produksi/warehouse?\r\nJika pemiliknya warehouse, maka sebaiknya WO dibuat oleh warehouse untuk mencegah kesalahan', '159912408', '', NULL, NULL),
(579, 'WO2025HX7', '2025-06-05 10:57:40', 'Ticket Assign To', 'Ticket Assign to SPVM', '159912408', '', NULL, NULL),
(580, 'WO2025OY9', '2025-06-05 10:58:46', 'Ticket Returned', 'Menunggu approval top management terkait penggantian seluruh atap pabrik', '159912408', '', NULL, NULL),
(581, 'WO2025VE6', '2025-06-05 13:06:31', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(582, 'WO2025K2H', '2025-06-05 13:32:34', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(583, 'WO2025WYT', '2025-06-05 13:33:36', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(584, 'WO2025STU', '2025-06-05 13:33:53', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(585, 'WO20251HN', '2025-06-05 13:34:07', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(586, 'WO2025J8S', '2025-06-05 13:34:22', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(587, 'WO2025J4R', '2025-06-05 13:36:38', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(588, 'WO2025PIA', '2025-06-05 13:36:53', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(589, 'WO202551F', '2025-06-05 13:37:12', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(590, 'WO2025BSV', '2025-06-05 13:37:28', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(591, 'WO2025RGU', '2025-06-05 13:37:52', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(592, 'WO2025HQQ', '2025-06-05 13:38:12', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(593, 'WO2025KCA', '2025-06-05 13:38:27', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(594, 'WO2025WFO', '2025-06-05 13:38:42', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(595, 'WO2025SNF', '2025-06-05 13:38:59', 'Ticket Received', 'Priority of the ticket is set to Low and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(596, 'WO2025U5I', '2025-06-05 13:41:54', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '162112408', '', NULL, NULL),
(597, 'WO2025ZLV', '2025-06-05 14:11:43', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(598, 'WO2025QI4', '2025-06-05 14:11:57', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(599, 'WO2025UDT', '2025-06-05 14:12:10', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(600, 'WO2025V0W', '2025-06-05 14:12:32', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(601, 'WO20257UH', '2025-06-05 14:12:46', 'Ticket Received', 'Priority of the ticket is set to High and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(602, 'WO2025YDH', '2025-06-05 14:13:01', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(603, 'WO2025XHM', '2025-06-05 14:13:30', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(604, 'WO20256K5', '2025-06-05 14:13:45', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(605, 'WO20251LU', '2025-06-05 14:13:59', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(606, 'WO2025WI5', '2025-06-05 14:14:17', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(607, 'WO2025UMU', '2025-06-05 14:14:35', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(608, 'WO2025HX7', '2025-06-05 14:14:51', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to Leader MTC.', '144222308', '', NULL, NULL),
(609, 'WO202551F', '2025-06-05 15:06:12', 'Pending', '', '053811708', '', NULL, NULL),
(610, 'WO2025PIA', '2025-06-05 15:06:23', 'Pending', '', '053811708', '', NULL, NULL),
(611, 'WO2025J4R', '2025-06-05 15:06:28', 'Pending', '', '053811708', '', NULL, NULL),
(612, 'WO2025WYT', '2025-06-05 15:58:06', 'On Process', '', '053811708', '', NULL, NULL),
(613, 'WO2025WYT', '2025-06-05 15:59:49', 'Ticket Closed. Progress: 100 %', 'Baut roda sudah dilengkapi', '053811708', 'WhatsApp_Image_2025-06-05_at_15_58_10.jpeg', '68415c85637b4.png', NULL),
(614, 'WO2025KV5', '2025-06-07 13:29:53', 'Ticket Submited. Kategori: Fabrikasi(Jig)', 'PEMBUATAN JIG UPLID 2GN ,KARENA JIG ADA 1PCS\r\n#CONTOH JIG TERLAMPIR', '009211410', '', NULL, NULL),
(615, 'WO2025XRK', '2025-06-07 13:32:13', 'Ticket Submited. Kategori: Repair(Repair dies)', 'Perbaikan dies hood 560b cavity 3 bagian belang ada yang gompal\r\n#gambar terlampir', '009211410', '', NULL, NULL),
(616, 'WO2025IFP', '2025-06-07 13:37:56', 'Ticket Submited. Kategori: Repair(Repair dies)', 'Perbaikan dies hood 5h45 cavity 1 bagian belakang ,ada seperti garis bekas lalasan ,dan timbul garis di part', '009211410', '', NULL, NULL),
(617, 'WO2025WUT', '2025-06-08 11:09:53', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikan cctv', '007811310', '', NULL, NULL),
(627, 'WO2025M8G', '2025-06-08 12:23:56', 'Ticket Submited and Approved. Kategori: Fabrikasi(Dies)', 'Perbaikan dies', '058711706', '', NULL, NULL),
(628, 'BQEDi3NCJ', '2025-06-08 12:24:36', 'Ticket Submited and Approved. Kategori: Fabrikasi(Dies)', 'Perbaikan dies', '058711706', '', NULL, NULL),
(630, 'q6l3YrxVE', '2025-06-08 14:04:31', 'Ticket Submited and Approved. Kategori: Fabrikasi(Building)', '(URGENT) Relayout Area Tim Delivery. Mohon dikerjakan saat Hari Minggu', '058711706', '', NULL, NULL),
(631, 'PZgdESB3n', '2025-06-08 20:38:35', 'Ticket Submited. Kategori: Repair(Repair building)', 'Antara rul 2 dan rul 3,', '005711310', '', NULL, NULL),
(632, '9nkcvIfKC', '2025-06-08 20:57:47', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Baut danabolt pagar mesin andon NVH depan lepas , repiar / ganti dengan yang baru agar pagar tidak geser ', '044811610', '', NULL, NULL),
(633, '8VRwfx35B', '2025-06-09 01:12:28', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Penggantian teflon meja heater D, sudah rusak dan tidak nempel', '005711310', '', NULL, NULL),
(634, 'WO2025WIV', '2025-06-09 08:21:27', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return customer tanggal 5 Juni 20025', '047511607', '', NULL, NULL),
(635, 'WO2025BKE', '2025-06-09 09:04:57', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Support pemasangan cctv area gedung baru', '154412305', '', NULL, NULL),
(636, 'WO2025KCA', '2025-06-09 09:26:43', 'On Process', '', '053811708', '', NULL, NULL),
(637, 'WO2025KCA', '2025-06-09 09:27:36', 'Work Order Closed. Progress: 100 %', 'Baut cover sudah di lengkapi', '053811708', 'WhatsApp_Image_2025-06-09_at_09_29_50.jpeg', '68464698af4ff.png', NULL),
(638, 'WO2025BKE', '2025-06-09 09:45:43', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(639, 'WO2025UXW', '2025-06-09 10:00:31', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Request penarikan kabel dari meja pak agung CFO ke ruang server lt3', '154412305', '', NULL, NULL),
(640, 'WO2025TM3', '2025-06-09 10:01:31', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Melanjutkan pengaktifan cctv area gedung baru', '154412305', '', NULL, NULL),
(641, 'WO2025UXW', '2025-06-09 10:01:51', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(642, 'WO2025TM3', '2025-06-09 10:25:14', 'Work Order Returned', 'Job utk maintenance ngapain Pak?', '159912408', '', NULL, NULL),
(643, 'WO2025QI4', '2025-06-09 10:35:03', 'On Process', '', '072611806', '', NULL, NULL),
(644, 'WO2025UMU', '2025-06-09 10:42:40', 'On Process', '', '072611806', '', NULL, NULL),
(645, 'WO20251LU', '2025-06-09 10:43:03', 'On Process', '', '072611806', '', NULL, NULL),
(646, 'WO2025QI4', '2025-06-09 10:53:01', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-09_at_10_21_44_(1).jpeg', '68465a9dedfaa.png', NULL),
(647, 'WO20258E5', '2025-06-09 10:57:23', 'Ticket Submited and Approved. Kategori: Request(Request)', 'Kabel berserakan di area kerja, dan ada bagian kabel terkelupas yg diisolasi.\r\n1. Buatkan tempat jalur kabel yang fix di area meja kerja\r\n2. Buatkan saklar yang fix di area meja kerja dengan dibantali isolator dari kayu. (Saklar-Kayu-Besi)\r\n3. Buatkan semacam roll atau tempat menggantungkan sisa kabel\r\n', '163122511', '', NULL, NULL),
(648, 'WO2025VOZ', '2025-06-09 10:59:25', 'Ticket Submited and Approved. Kategori: Request(Request)', '1. Bersihkan terminal charger forklift yang berdebu dan sarang laba-laba\r\n2. Rapikan kabel di area belakang dan tutup dengan tray yg rapat dan rapi.', '163122511', '', NULL, NULL),
(649, 'WO2025CVN', '2025-06-09 10:59:32', 'Ticket Submited. Kategori: Request(Request)', 'Cover kurang pas/masih ada celah potensi tangan masuk dan cover riskan tersenggol anggota tubuh', '018511410', '', NULL, NULL),
(650, 'WO2025VDN', '2025-06-09 11:01:55', 'Ticket Submited and Approved. Kategori: Request(Request)', 'Dinding terbuka dan kabel terekspose. ', '163122511', '', NULL, NULL),
(651, 'WO2025TM3', '2025-06-09 11:06:04', 'Work Order Resubmit', 'connect kabel dengan scissor lift pak di area warehouse,sebelumnya dengan faiq', '154412305', '', NULL, NULL),
(652, 'WO2025X4T', '2025-06-09 11:22:46', 'Ticket Submited. Kategori: Request(Request)', 'Untuk mempermudah setting mtl yang geser/kurang center saat proses berlangsung, tanpa harus memutar lewat depan', '018511410', '', NULL, NULL),
(653, 'WO2025OBM', '2025-06-09 11:25:34', 'Ticket Submited. Kategori: Request(Request)', 'Meminimalisir benda asing atau yang lainnya jatuh dari lantai 3 mixing', '018511410', '', NULL, NULL),
(655, 'WO202587L', '2025-06-09 11:52:19', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(656, 'WO2025MTC', '2025-06-09 11:57:05', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(657, 'WO202587L', '2025-06-09 12:17:35', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(658, 'WO2025VDN', '2025-06-09 12:17:54', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(659, 'WO2025VOZ', '2025-06-09 12:18:22', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(660, 'WO20258E5', '2025-06-09 12:18:44', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(661, 'WO2025TM3', '2025-06-09 12:19:09', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(663, 'WO2025OBM', '2025-06-09 12:47:09', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(664, 'WO2025X4T', '2025-06-09 12:47:21', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(665, 'WO2025CVN', '2025-06-09 12:47:31', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(666, '8VRwfx35B', '2025-06-09 12:47:43', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(667, 'WO20251SX', '2025-06-09 13:04:16', 'Ticket Submited. Kategori: Request(Request)', 'Tangga diposisikan kesamping agar tidak mengganggu MP calenderoll, pagar dilebarkan agar muat untuk pejalan kaki dan merapikan ram besi yang beberapa potongannya sedikit tajam, berpotensi tangan tergores saat memegang pagar', '018511410', '', NULL, NULL),
(668, 'WO2025SEL', '2025-06-09 13:11:16', 'Pending', '', '144222308', '', NULL, NULL),
(669, 'WO2025U2U', '2025-06-09 13:12:48', 'Pending', '', '144222308', '', NULL, NULL),
(670, 'WO20256RW', '2025-06-09 13:36:42', 'On Process', '', '002611305', '', NULL, NULL),
(671, 'WO20256RW', '2025-06-09 13:36:47', 'On Process', '', '002611305', '', NULL, NULL),
(672, 'WO20256RW', '2025-06-09 13:42:21', 'Work Order Closed. Progress: 100 %', 'Relayout DustCollector', '002611305', 'WhatsApp_Image_2025-06-08_at_16_50_40.jpeg', '6846824d51980.png', NULL),
(673, 'WO2025J8S', '2025-06-09 13:43:43', 'On Process', '', '002611305', '', NULL, NULL),
(674, 'WO2025U5I', '2025-06-09 13:43:48', 'On Process', '', '002611305', '', NULL, NULL),
(675, 'WO2025U5I', '2025-06-09 13:44:39', 'Work Order Closed. Progress: 100 %', 'Penggantian Lampu  ', '002611305', 'WhatsApp_Image_2025-06-09_at_06_29_45.jpeg', '684682d76ba9e.png', NULL),
(676, 'WO2025J8S', '2025-06-09 13:46:06', 'Work Order Closed. Progress: 100 %', 'Penggantian Lampu ', '002611305', 'WhatsApp_Image_2025-06-09_at_06_29_451.jpeg', '6846832e6f4ed.png', NULL),
(677, 'WO2025BSV', '2025-06-09 13:53:36', 'On Process', '', '002611305', '', NULL, NULL),
(678, 'WO2025BSV', '2025-06-09 13:54:17', 'Work Order Closed. Progress: 100 %', 'Penggantian lampu', '002611305', 'WhatsApp_Image_2025-06-09_at_06_39_40.jpeg', '6846851942952.png', NULL),
(679, 'WO2025UXQ', '2025-06-09 14:37:58', 'On Process', '', '072611806', '', NULL, NULL),
(680, 'WO20257UH', '2025-06-09 14:38:19', 'On Process', '', '072611806', '', NULL, NULL),
(681, 'WO2025ZLV', '2025-06-09 14:38:24', 'On Process', '', '072611806', '', NULL, NULL),
(682, 'WO20257UH', '2025-06-09 14:43:17', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-09_at_11_10_21.jpeg', '68469095b8fed.png', NULL),
(683, 'WO2025UXQ', '2025-06-09 14:51:22', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki dan hasil sesuai parameter setting', '072611806', 'WhatsApp_Image_2025-05-28_at_05_13_53.jpeg', '6846927a8ff3e.png', NULL),
(684, 'WO2025ZLV', '2025-06-09 14:53:30', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-09_at_10_21_44.jpeg', '684692fa74725.png', NULL),
(685, 'WO2025ZLV', '2025-06-09 14:53:35', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-09_at_10_21_441.jpeg', '684692ff0d979.png', NULL),
(686, 'WO20251LU', '2025-06-09 14:55:09', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki dan di welding', '072611806', 'WhatsApp_Image_2025-06-09_at_11_12_44.jpeg', '6846935dbc0c5.png', NULL),
(687, 'WO2025UMU', '2025-06-09 15:07:38', 'Work Order Closed. Progress: 100 %', 'Sudah di ganti baru pakai roda 5 inchi', '072611806', 'WhatsApp_Image_2025-06-04_at_21_34_14.jpeg', '6846964a24266.png', NULL),
(688, 'WO2025IYU', '2025-06-09 15:18:22', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Roda rusak ', '018511410', '', NULL, NULL),
(689, 'WO20256TP', '2025-06-09 15:23:33', 'On Process', '', '072611806', '', NULL, NULL),
(690, 'WO20256K5', '2025-06-09 15:26:25', 'On Process', '', '072611806', '', NULL, NULL),
(691, 'WO20257NY', '2025-06-09 16:17:33', 'On Process', '', '072611806', '', NULL, NULL),
(692, 'WO20256TP', '2025-06-09 16:19:42', 'Work Order Closed. Progress: 100 %', 'Kipas tidak bisa di perbaiki karna kondisi seperti jatuh / ketabrak .', '072611806', 'WhatsApp_Image_2025-06-02_at_12_53_15.jpeg', '6846a72eeb050.png', NULL),
(693, 'WO20257NY', '2025-06-09 16:20:42', 'Work Order Closed. Progress: 100 %', 'Sudah di pasang addres layout', '072611806', 'WhatsApp_Image_2025-06-09_at_10_21_45_(1).jpeg', '6846a76a4f01a.png', NULL),
(694, 'WO2025BLV', '2025-06-09 16:51:33', 'Ticket Submited. Kategori: Request(Request)', 'Pergantian lampu penerangan utama rul 4 di atas oven 7 ', '011911410', '', NULL, NULL),
(695, 'WO2025FES', '2025-06-09 17:11:54', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '038321605', '', NULL, NULL),
(696, 'WO2025D5J', '2025-06-09 17:11:57', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '038321605', '', NULL, NULL),
(697, 'WO2025RER', '2025-06-09 17:12:02', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Minta tolong kabel area meja bu Anissa berantakan khawatir terjadi tegangan arus listrik', '038321605', '', NULL, NULL),
(698, 'WO2025NAB', '2025-06-09 17:22:02', 'On Process', '', '002611305', '', NULL, NULL),
(699, 'WO2025NAB', '2025-06-09 17:22:34', 'Work Order Closed. Progress: 100 %', 'Pemasangan lampu meja Assy', '002611305', 'WhatsApp_Image_2025-06-09_at_16_59_59.jpeg', '6846b5eaf36d0.png', NULL),
(700, 'WO2025BKE', '2025-06-09 19:01:35', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(701, 'WO2025UXW', '2025-06-09 19:02:38', 'Pending', '', '162112408', '', NULL, NULL),
(702, 'WO2025TM3', '2025-06-09 19:03:19', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(703, 'WO2025TM3', '2025-06-09 19:03:23', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(704, 'WO2025UXW', '2025-06-09 19:03:55', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(705, 'WO20258E5', '2025-06-09 19:04:29', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(706, 'WO2025XHM', '2025-06-09 19:04:37', 'On Process', '', '072611806', '', NULL, NULL),
(707, 'WO2025V0W', '2025-06-09 19:04:58', 'On Process', '', '072611806', '', NULL, NULL),
(708, 'WO2025VOZ', '2025-06-09 19:05:13', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(709, 'WO2025YDH', '2025-06-09 19:05:39', 'On Process', '', '072611806', '', NULL, NULL),
(710, 'WO2025VDN', '2025-06-09 19:05:40', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(711, 'WO2025C9Z', '2025-06-09 19:06:20', 'On Process', '', '072611806', '', NULL, NULL),
(712, 'WO20256K5', '2025-06-09 19:07:33', 'Work Order Closed. Progress: 100 %', 'Sudah di lepas dudukan kipas', '072611806', 'WhatsApp_Image_2025-06-09_at_19_07_06.jpeg', '6846ce85b9c1e.png', NULL),
(713, 'WO2025C9Z', '2025-06-09 19:08:30', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki, ', '072611806', 'WhatsApp_Image_2025-06-09_at_19_07_05.jpeg', '6846cebeef766.png', NULL),
(714, 'WO2025XHM', '2025-06-09 19:10:40', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki dan setting supaya bisa putar kanan kiri', '072611806', 'WhatsApp_Image_2025-06-09_at_19_07_38.jpeg', '6846cf40dafc2.png', NULL),
(715, 'WO2025YDH', '2025-06-09 19:12:11', 'Work Order Closed. Progress: 100 %', 'Sudah di tambahkan menggunakan impraboard dan di baut roping supaya tidak lepas.', '072611806', 'WhatsApp_Image_2025-06-09_at_19_07_06_(1).jpeg', '6846cf9c01eec.png', NULL),
(716, 'WO2025SBR', '2025-06-09 19:21:17', 'Work Order Closed. Progress: 100 %', 'Sudah di ganti acrilic baru', '072611806', 'WhatsApp_Image_2025-06-09_at_19_22_19.jpeg', '6846d1bdd6b0e.png', NULL),
(717, 'WO2025OWH', '2025-06-09 19:22:21', 'Work Order Closed. Progress: 100 %', 'Sudah di ganti acrlic baru', '072611806', 'WhatsApp_Image_2025-06-09_at_19_22_191.jpeg', '6846d1fd1e8de.png', NULL),
(718, 'WO2025OBM', '2025-06-10 07:50:44', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(719, 'WO2025X4T', '2025-06-10 07:51:19', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(720, 'WO2025CVN', '2025-06-10 07:51:43', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(721, '8VRwfx35B', '2025-06-10 07:52:33', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(722, 'WO2025CUT', '2025-06-10 08:39:57', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return customer tanggal 09 juni 2025', '047511607', '', NULL, NULL),
(723, 'WO2025VOZ', '2025-06-10 09:52:02', 'On Process', '', '053811708', '', NULL, NULL),
(724, 'WO2025K2H', '2025-06-10 09:52:18', 'On Process', '', '053811708', '', NULL, NULL),
(725, 'WO2025K2H', '2025-06-10 09:54:09', 'Work Order Closed. Progress: 100 %', 'Penggantian Lampu sein Forklift WH 02', '053811708', 'WhatsApp_Image_2025-06-09_at_23_37_13.jpeg', '68479e51e0baa.png', NULL),
(726, 'WO2025VOZ', '2025-06-10 09:57:06', 'Work Order Closed. Progress: 100 %', 'Perapin kabel di area charger forklift', '053811708', 'WhatsApp_Image_2025-06-09_at_17_07_47.jpeg', '68479f02dee84.png', NULL),
(727, 'WO2025WI5', '2025-06-10 10:34:59', 'On Process', '', '072611806', '', NULL, NULL),
(728, 'WO2025WI5', '2025-06-10 10:37:37', 'Work Order Closed. Progress: 100 %', 'Sudah di tambahkan cover pakai eva spon', '072611806', 'WhatsApp_Image_2025-06-10_at_10_36_03.jpeg', '6847a881ef036.png', NULL),
(729, 'WO2025CVN', '2025-06-10 10:41:12', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(730, 'WO2025CVN', '2025-06-10 10:58:39', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(731, 'WO202587L', '2025-06-10 10:59:42', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(732, 'WO2025CUT', '2025-06-10 12:31:38', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(733, 'WO2025WIV', '2025-06-10 12:32:05', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(734, 'WO2025DNP', '2025-06-10 12:33:48', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(735, 'WO2025DIQ', '2025-06-10 12:36:43', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(736, 'WO2025MDR', '2025-06-10 13:11:09', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Penarikan kabel jaringan untuk cctv monitoring material aspalt dari lantai 2 ke lantai 3 aspalt ', '154412305', '', NULL, NULL),
(746, 'WO2025MDR', '2025-06-10 14:31:45', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(747, 'WO2025OBM', '2025-06-10 14:32:17', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(748, 'WO2025X4T', '2025-06-10 14:32:44', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(749, '8VRwfx35B', '2025-06-10 14:33:05', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(750, 'WO2025MTC', '2025-06-10 14:33:33', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(751, 'WO2025OBM', '2025-06-10 15:23:06', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(752, 'WO2025X4T', '2025-06-10 15:31:27', 'Pending', '', '144222308', '', NULL, NULL),
(753, 'WO2025MTC', '2025-06-10 15:31:47', 'Pending', '', '144222308', '', NULL, NULL),
(754, 'WO2025CPW', '2025-06-10 15:51:36', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Selang bagian geser garpu  forklif 10 TON bocor sehingga oli hidraulik cepas habis dan oli berceceran di lantai.', '025511510', '', NULL, NULL),
(755, 'WO2025NTI', '2025-06-10 15:55:23', 'Ticket Submited. Kategori: Repair(Repair building)', 'Pintu chamber NVH rusak di bagian engsel ', '025511510', '', NULL, NULL),
(756, 'WO2025CVN', '2025-06-10 16:12:30', 'On Process', '', '072611806', '', NULL, NULL),
(757, 'WO2025CVN', '2025-06-10 16:14:38', 'Work Order Closed. Progress: 100 %', 'Sudah di modifikasi di buat posisi leter L', '072611806', 'WhatsApp_Image_2025-06-10_at_16_17_51.jpeg', '6847f77e793ef.png', NULL),
(758, 'WO2025HFB', '2025-06-11 09:06:06', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Blower dinding yang kecil kecil  dibagian atas mesin N1 dan N2 mati, ', '128012210', '', NULL, NULL),
(759, 'WO2025L4T', '2025-06-11 09:09:39', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Plat meja heater N3 melengkung. untuk pemagangan kurang mereta di part', '128012210', '', NULL, NULL),
(760, 'WO2025L4T', '2025-06-11 10:31:24', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(761, 'WO2025L4T', '2025-06-11 10:31:30', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(762, 'WO2025L4T', '2025-06-11 12:26:53', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(763, 'WO2025L4T', '2025-06-11 12:29:45', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(764, 'WO20252FE', '2025-06-11 12:33:55', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Repair Pallet NG Recycle Asphalt dan melakukan modifikasi pallet existing', '159812407', '', NULL, NULL),
(765, 'WO20252TF', '2025-06-11 13:33:09', 'Ticket Submited. Kategori: Request(Request)', 'Preventive maintenance chamber ', '134322209', '', NULL, NULL),
(766, 'WO2025WHY', '2025-06-11 14:13:07', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Putaran conveyor tersendat-sendat (conveyor bagian bawah)', '018511410', '', NULL, NULL),
(767, 'WO2025GGY', '2025-06-11 14:47:15', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 10 juni 2025', '047511607', '', NULL, NULL),
(768, 'WO2025TGP', '2025-06-12 03:02:45', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan nozel kerucut pada mesin rul 3 untuk jalan proses Fr Toyota, untuk memudakan aplikasi lem pasta', '005711310', '', NULL, NULL),
(769, 'WO2025C9B', '2025-06-12 03:08:26', 'Ticket Submited. Kategori: Request(Request)', 'Pmindahan legra  mesin hotmelt / gluroll karena kebutuhan flow proses,\r\n- R1A pindah R1B\r\n- R2A pindah R2B\r\n- R3A pindah R3B', '005711310', '', NULL, NULL),
(770, 'WO2025PJ3', '2025-06-12 09:02:41', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Tolong dibantu ya team MTC, terkait kebocoran wastafel tersebut. \r\nkarena khawatir akan banyak genangan air di area tersebut. sehingga menimbulkan banyak potensi bahaya terjadi.\r\nTerima kasih banyak.', '038321605', '', NULL, NULL),
(771, 'WO2025YWB', '2025-06-12 09:04:34', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Tolong dibantu ya team MTC, terkait kebocoran wastafel tersebut. karena khawatir akan banyak genangan air di area tersebut. sehingga menimbulkan banyak potensi bahaya terjadi. Terima kasih banyak.', '038321605', '', NULL, NULL),
(772, 'WO20259DY', '2025-06-12 09:43:51', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Tolong dibantu ya team MTC, terkait acrilic area merokok pecah dan keluar dari tempatnya. Terima kasih banyak.', '038321605', '', NULL, NULL),
(773, 'WO2025GGY', '2025-06-12 10:51:41', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(774, 'WO20252FE', '2025-06-12 10:52:28', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(775, 'WO2025OBM', '2025-06-12 11:13:41', 'On Process', '', '072611806', '', NULL, NULL),
(776, 'WO2025OBM', '2025-06-12 11:14:39', 'Work Order Closed. Progress: 100 %', 'Sudah dibuatkan cover sesuai request', '072611806', 'WhatsApp_Image_2025-06-12_at_11_08_31.jpeg', '684a543000fbb.png', NULL),
(777, 'WO2025DNP', '2025-06-12 11:25:10', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(778, 'WO2025DIQ', '2025-06-12 11:26:13', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(779, 'WO2025DIQ', '2025-06-12 11:26:16', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(780, 'WO2025WIV', '2025-06-12 11:26:31', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(781, 'WO2025CUT', '2025-06-12 11:26:58', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(782, 'WO20252FE', '2025-06-12 11:27:16', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(783, 'WO2025GGY', '2025-06-12 11:27:29', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(784, 'WO2025GGY', '2025-06-12 12:50:59', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(785, 'WO20252FE', '2025-06-12 12:51:28', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(786, 'WO2025CUT', '2025-06-12 12:51:57', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(787, 'WO2025WIV', '2025-06-12 12:52:21', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(788, 'WO2025DIQ', '2025-06-12 12:56:01', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(789, 'WO2025K8U', '2025-06-12 13:14:35', 'Ticket Submited. Kategori: Request(Request)', 'AC tidak dingin suhu sudah max namun tidak dingin ', '145612310', '', NULL, NULL),
(790, 'WO2025IQ8', '2025-06-12 13:15:56', 'Ticket Submited and Approved. Kategori: Support(Support)', 'Support IT mengaktifkan cctv area workshop maintennce', '154412305', '', NULL, NULL),
(791, 'WO2025K8U', '2025-06-12 14:17:33', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(792, 'WO2025C9B', '2025-06-12 14:17:48', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(793, 'WO2025TGP', '2025-06-12 14:18:03', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(794, 'WO2025K8U', '2025-06-12 14:52:23', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(795, 'WO2025HFB', '2025-06-12 14:52:25', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(796, 'WO2025WHY', '2025-06-12 14:52:38', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(797, 'WO2025C9B', '2025-06-12 14:52:48', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(798, 'WO2025NTI', '2025-06-12 14:52:52', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(799, 'WO2025CPW', '2025-06-12 14:53:06', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(800, 'WO2025BLV', '2025-06-12 14:53:35', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(801, 'WO2025IYU', '2025-06-12 14:54:04', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(802, 'WO20251SX', '2025-06-12 14:54:23', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(803, '9nkcvIfKC', '2025-06-12 14:56:10', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(804, 'PZgdESB3n', '2025-06-12 14:56:28', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(805, 'WO2025TGP', '2025-06-12 14:56:35', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(806, 'WO2025WUT', '2025-06-12 14:56:54', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(807, 'WO2025WHY', '2025-06-12 14:57:01', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(808, 'WO2025IFP', '2025-06-12 14:57:27', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(809, 'WO2025XRK', '2025-06-12 14:57:44', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(810, 'WO2025HFB', '2025-06-12 14:57:53', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(811, 'WO2025KV5', '2025-06-12 14:57:57', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(812, 'WO2025NTI', '2025-06-12 14:58:15', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(813, 'WO2025CPW', '2025-06-12 14:58:36', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(814, 'WO2025BLV', '2025-06-12 15:00:31', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(815, 'WO2025IYU', '2025-06-12 15:01:11', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(816, 'WO20251SX', '2025-06-12 15:02:13', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(817, '9nkcvIfKC', '2025-06-12 15:03:19', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(818, 'PZgdESB3n', '2025-06-12 15:05:35', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(819, 'WO2025IFP', '2025-06-12 15:09:00', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(820, 'WO2025XRK', '2025-06-12 15:09:39', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(821, 'WO2025KV5', '2025-06-12 15:09:57', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(822, 'WO2025IQ8', '2025-06-12 15:10:36', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(823, 'WO2025K8U', '2025-06-12 15:10:55', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(824, 'WO2025C9B', '2025-06-12 15:11:12', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(825, 'WO2025TGP', '2025-06-12 15:11:55', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(826, 'WO2025WHY', '2025-06-12 15:12:30', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(827, 'WO2025HFB', '2025-06-12 15:12:50', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(828, 'WO2025NTI', '2025-06-12 15:13:12', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(829, 'WO2025CPW', '2025-06-12 15:13:38', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(830, 'WO2025BLV', '2025-06-12 15:14:00', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(831, 'WO2025IYU', '2025-06-12 15:14:35', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(832, 'WO20251SX', '2025-06-12 15:15:03', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(833, '9nkcvIfKC', '2025-06-12 15:15:25', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(834, 'PZgdESB3n', '2025-06-12 15:15:45', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(835, 'WO2025IFP', '2025-06-12 15:16:10', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(836, 'WO2025XRK', '2025-06-12 15:17:30', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(837, 'WO2025KV5', '2025-06-12 15:18:08', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(838, 'WO2025DNP', '2025-06-12 15:18:33', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(839, 'WO20256UU', '2025-06-12 16:08:44', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Jumlah 2 Biji, Ukuran detail request to rizaldi. Material sudah Ready.', '159812407', '', NULL, NULL),
(840, 'WO2025SMX', '2025-06-12 16:18:20', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Follow Up WO repair pallet Feltline, yang dikembalikan sebelumnya karena material belum ready. Sekarang material sudah ada.', '159812407', '', NULL, NULL),
(841, 'WO2025SMX', '2025-06-12 16:20:30', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(842, 'WO20256UU', '2025-06-12 16:20:40', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(843, 'WO2025MFO', '2025-06-12 16:22:15', 'Ticket Submited. Kategori: Repair(Repair building)', 'Replace Roda Tangga RM', '159812407', '', NULL, NULL),
(844, 'WO2025SHC', '2025-06-12 16:23:56', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan lubang colokan (4 colokan) karena tim RM kekurangan colokan.', '159812407', '', NULL, NULL),
(845, 'WO20256UU', '2025-06-12 16:28:02', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(846, 'WO2025SMX', '2025-06-12 16:28:24', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(847, 'WO2025SHC', '2025-06-12 16:34:27', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(848, 'WO2025MFO', '2025-06-12 16:34:45', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(849, 'WO20257DZ', '2025-06-13 08:01:02', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Pengubahan Hanging Rak dari Horizontal ke Vertikal untuk Optimasi Area. Ukuran detail langsung diskusi dengan Rizaldi. Material sudah siap', '159812407', '', NULL, NULL),
(850, 'WO2025QEC', '2025-06-13 08:25:50', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan identitas nomor dan keterangan bahwa kabel heater atas dan bawah agar mudah dikenali dan difahami', '127912210', '', NULL, NULL),
(851, 'WO2025DWN', '2025-06-13 08:31:15', 'Ticket Submited. Kategori: Request(Request)', 'Request pembuatan kembali tangki penampungan oli untuk dimesin R1B bagian luar yang hilang ', '127912210', '', NULL, NULL),
(852, 'WO2025GGY', '2025-06-13 08:41:22', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(853, 'WO2025NTI', '2025-06-13 08:43:17', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(854, 'WO2025CUT', '2025-06-13 08:43:40', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(855, 'WO2025IYU', '2025-06-13 08:45:00', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(856, 'WO20251SX', '2025-06-13 08:46:16', 'Work Order Received', 'Priority of the Work Order is set to High and assigned to technician.', '144222308', '', NULL, NULL),
(857, 'WO2025WIV', '2025-06-13 08:46:41', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(858, '9nkcvIfKC', '2025-06-13 08:47:09', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(859, 'WO2025IFP', '2025-06-13 08:47:58', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(860, 'WO2025XRK', '2025-06-13 08:48:24', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(861, 'WO2025DIQ', '2025-06-13 08:50:07', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(862, 'WO2025DNP', '2025-06-13 08:50:31', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(863, 'WO20252FE', '2025-06-13 09:10:02', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '144222308', '', NULL, NULL),
(864, 'WO2025XFK', '2025-06-13 09:16:55', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Pergantian kipas meja inpeksi N4 belakang 1 pcs dan meja inpeksi N5 depan 1 pcs', '107612010', '', NULL, NULL);
INSERT INTO `tracking` (`id_tracking`, `id_ticket`, `tanggal`, `status`, `deskripsi`, `id_user`, `filefoto`, `signature`, `answerfoto`) VALUES
(865, 'WO2025RMS', '2025-06-13 09:40:22', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return Customer tanggal 11-12 juni 2025', '047511607', '', NULL, NULL),
(866, 'WO2025KV5', '2025-06-13 09:44:33', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(867, 'WO2025LGX', '2025-06-13 09:53:12', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Modifikasi palet Hood 2JX ke Hood YTB untuk kebutuhan delivery & stok FG', '047511607', '', NULL, NULL),
(868, 'WO2025IYU', '2025-06-13 10:19:35', 'On Process', '', '072611806', '', NULL, NULL),
(869, 'WO2025IYU', '2025-06-13 10:30:36', 'Work Order Closed. Progress: 100 %', 'Sudah di ganti roda baru', '072611806', 'WhatsApp_Image_2025-06-09_at_16_30_56.jpeg', '684b9b5c0cbd1.png', NULL),
(870, 'WO2025SHC', '2025-06-13 10:33:24', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(871, 'WO2025MFO', '2025-06-13 10:33:52', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(872, 'WO2025TQY', '2025-06-13 10:49:29', 'Ticket Submited. Kategori: Fabrikasi(Dies)', 'Penambahan pin (6) di dies outer 3GN dikarenakan ada problem melipat di part, maka itu untuk minimalisir/ menghilangkan problem tersebut dilakukan penambahan pin pada dies untuk mengaitkan nonwoven.', '128012210', '', NULL, NULL),
(873, 'WO2025SHC', '2025-06-13 11:04:47', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(874, 'WO2025MFO', '2025-06-13 11:05:05', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(875, 'WO2025SMX', '2025-06-13 11:05:26', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(876, 'WO20256UU', '2025-06-13 11:05:45', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(877, 'WO2025LGX', '2025-06-13 13:26:22', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(878, 'WO2025RMS', '2025-06-13 13:26:43', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(879, 'WO20257DZ', '2025-06-13 13:26:53', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(880, 'WO20257DZ', '2025-06-13 14:11:13', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(881, 'WO2025RMS', '2025-06-13 14:11:23', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(882, 'WO2025LGX', '2025-06-13 14:11:38', 'Work Order Approved', 'Approved by Manager Dept', '156312407', '', NULL, NULL),
(883, 'WO20250SU', '2025-06-13 14:35:03', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'PLAT NO : T 8518 FL', '159812407', '', NULL, NULL),
(884, 'WO2025ZNI', '2025-06-13 15:07:46', 'On Process', '', '072611806', '', NULL, NULL),
(885, 'WO20257Y6', '2025-06-13 15:18:07', 'On Process', '', '072611806', '', NULL, NULL),
(886, 'WO2025O80', '2025-06-13 15:18:42', 'On Process', '', '072611806', '', NULL, NULL),
(887, 'WO20255IS', '2025-06-13 15:19:02', 'On Process', '', '072611806', '', NULL, NULL),
(888, 'WO2025UDT', '2025-06-13 15:19:33', 'On Process', '', '072611806', '', NULL, NULL),
(889, 'WO2025DNP', '2025-06-13 15:19:52', 'On Process', '', '072611806', '', NULL, NULL),
(890, 'WO2025CTD', '2025-06-13 15:32:27', 'Ticket Submited. Kategori: Repair(Repair dies)', 'Repair cutting in line outer no 3 cavity 2.', '128012210', '', NULL, NULL),
(891, 'WO2025LGX', '2025-06-13 16:07:28', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(892, 'WO2025RMS', '2025-06-13 16:07:45', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(893, 'WO2025RNE', '2025-06-14 09:22:02', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Cover sensor press continue kurang kuat.', '018511410', '', NULL, NULL),
(894, 'WO2025IYU', '2025-06-14 09:22:17', 'Closed', '', '018511410', '', NULL, NULL),
(895, 'WO2025JIL', '2025-06-14 09:22:37', 'Closed', '', '018511410', '', NULL, NULL),
(896, 'WO2025COT', '2025-06-14 09:22:43', 'Closed', '', '018511410', '', NULL, NULL),
(897, 'WO2025CVN', '2025-06-14 09:22:48', 'Closed', '', '018511410', '', NULL, NULL),
(898, 'WO2025OBM', '2025-06-14 09:22:53', 'Closed', '', '018511410', '', NULL, NULL),
(899, 'WO2025WN7', '2025-06-14 10:12:38', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Tuas berada disebelah kanan dekat dengan panel mesin press continue, agar memudahkan proses setting material', '018511410', '', NULL, NULL),
(900, 'WO2025TNE', '2025-06-14 10:14:23', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Ada tetesan oli boiler pada silinder calenderoll', '018511410', '', NULL, NULL),
(901, 'WO20258FL', '2025-06-14 10:17:21', 'Ticket Submited. Kategori: Fabrikasi(Mesin)', 'Bagian bawah conveyor coating, talang/tampungan kurang lebar, resin menetes kelantai', '018511410', '', NULL, NULL),
(902, 'WO2025H7H', '2025-06-14 10:21:44', 'Ticket Submited. Kategori: Request(Request)', 'Power sebelumnya dari panel conveyor recycle, dipindah kepanel calenderoll, agar teteap stand by sampai akhir shift, karena jika dari panel conveyor recycle, 1 jam sebelum pulang sudah mati.', '018511410', '', NULL, NULL),
(903, 'WO2025VL1', '2025-06-14 10:25:10', 'Ticket Submited. Kategori: Request(Request)', 'Tutup rapat area output agar debu tidak berterbangan dan pasang tirai (plastik fiber bening) dibuka tutup untuk penggantian box jika sudah penuh', '018511410', '', NULL, NULL),
(904, 'WO2025LCD', '2025-06-14 10:28:59', 'Ticket Submited. Kategori: Request(Request)', 'Jig agar bisa disetting sesuai ketebalan ( 1 s/d 5 mm ) material yang akan diproses, meminimalisir double proses magnetic', '018511410', '', NULL, NULL),
(905, 'WO2025X80', '2025-06-14 11:17:32', 'Ticket Submited. Kategori: Request(Request)', 'Menggunakan besi holo ukuran 2x2cm, untuk memudahkan pembersihan/pemotongan material.', '018511410', '', NULL, NULL),
(906, 'WO2025PSY', '2025-06-14 11:20:26', 'Ticket Submited. Kategori: Request(Request)', 'Roller ukuran kecil dibagian depan roller spon, untuk menahan material agar tidak terlalu menekan material, yang akan cepat merusak roller spon ', '018511410', '', NULL, NULL),
(907, 'WO2025PZT', '2025-06-14 11:25:04', 'Ticket Submited. Kategori: Request(Request)', 'Menggunakan besi holo 2x4cm, menggantikan kayu yang sudah ada.', '018511410', '', NULL, NULL),
(908, 'WO2025XR6', '2025-06-14 13:14:02', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Sudah rusak/rapuh', '018511410', '', NULL, NULL),
(909, 'WO20255IS', '2025-06-14 13:22:38', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_52_(1).jpeg', '684d152ec3884.png', NULL),
(910, 'WO20257Y6', '2025-06-14 13:23:22', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_52.jpeg', '684d155a1eebd.png', NULL),
(911, 'WO2025DNP', '2025-06-14 13:24:43', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_51_(1).jpeg', '684d15ab192a0.png', NULL),
(912, 'WO2025O80', '2025-06-14 13:25:34', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_51.jpeg', '684d15de3f930.png', NULL),
(913, 'WO2025UDT', '2025-06-14 13:26:42', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_511.jpeg', '684d16226fc87.png', NULL),
(914, 'WO2025ZNI', '2025-06-14 13:28:18', 'Work Order Closed. Progress: 100 %', 'Palet sudh di perbaiki', '072611806', 'WhatsApp_Image_2025-06-14_at_13_25_521.jpeg', '684d16825f2fa.png', NULL),
(915, 'WO2025VDN', '2025-06-15 15:26:46', 'On Process', '', '053811708', '', NULL, NULL),
(916, 'WO2025JWB', '2025-06-15 23:44:38', 'Ticket Submited. Kategori: Request(Request)', 'Dipindah kepanel calenderoll agar memudahkan pengoperasiannya.', '018511410', '', NULL, NULL),
(917, 'WO2025CGN', '2025-06-16 03:22:16', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Perbaikan oli slide N5n bagian depan 2 titik tidak keluar ( tampungan oli kering )', '107612010', '', NULL, NULL),
(918, 'WO2025WUT', '2025-06-16 07:39:13', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(919, 'WO2025AXM', '2025-06-16 07:50:40', 'Ticket Submited. Kategori: Request(Request)', 'Modifikasi Box Hood MMKI untuk delivery Hood YHA ke Tambun, dengan menambahkan sekat menggunakan Impraboard untuk setiap part. Detail modifikasi disscuss dengan Rizaldi. Attachment merupakan foto Temporary Packing Method', '159812407', '', NULL, NULL),
(920, 'WO2025N5C', '2025-06-16 07:52:45', 'Ticket Submited. Kategori: Request(Request)', 'Modifikasi Box untuk delivery Outer ke Tambun, dengan menambahkan Spons dibagian dasar Box sebagai stopper untuk masing - masing part. SNP 12 Pcs. Detail bisa disscuss dengan Rizaldi', '159812407', '', NULL, NULL),
(921, 'WO2025LGX', '2025-06-16 08:35:53', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(922, 'WO2025RMS', '2025-06-16 08:36:16', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(923, 'WO2025MFO', '2025-06-16 08:41:21', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(924, 'WO2025SMX', '2025-06-16 08:42:56', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(925, 'WO20256UU', '2025-06-16 08:43:37', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '144222308', '', NULL, NULL),
(926, 'WO2025GGY', '2025-06-16 09:49:11', 'On Process', '', '072611806', '', NULL, NULL),
(927, 'WO2025YO2', '2025-06-16 09:49:38', 'On Process', '', '072611806', '', NULL, NULL),
(928, 'WO2025WIV', '2025-06-16 09:54:00', 'On Process', '', '072611806', '', NULL, NULL),
(929, 'WO2025CUT', '2025-06-16 09:54:04', 'On Process', '', '072611806', '', NULL, NULL),
(930, 'WO2025RMS', '2025-06-16 09:56:17', 'On Process', '', '072611806', '', NULL, NULL),
(931, 'WO2025FWA', '2025-06-16 09:58:27', 'On Process', '', '072611806', '', NULL, NULL),
(932, 'WO2025FWA', '2025-06-16 10:04:01', 'Progress: 90 %', 'Sudah di kerjakan hari sabtu 14/6/2025', '072611806', 'WhatsApp_Image_2025-06-16_at_10_07_24.jpeg', '684f89a187a67.png', NULL),
(933, 'WO2025FWA', '2025-06-16 10:09:42', 'Progress: 90 %', 'Sudah di perbaiki oleh mas aji tgl 14/6/2025', '072611806', 'WhatsApp_Image_2025-06-16_at_10_07_241.jpeg', '684f8af6e471a.png', NULL),
(934, 'WO2025CGN', '2025-06-16 10:25:38', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(935, 'WO2025CGN', '2025-06-16 10:33:51', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(936, 'WO2025CGN', '2025-06-16 10:42:59', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(937, 'WO20257DZ', '2025-06-16 10:43:31', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(938, 'WO2025WUT', '2025-06-16 10:45:13', 'Work Order Returned', 'Pak Lutpi, kabel yg mau direpair yg mana? mohon informasi detailnya, terima kasih.', '159912408', '', NULL, NULL),
(939, 'WO2025KNR', '2025-06-16 13:42:23', 'Ticket Submited. Kategori: Request(Request)', 'Penambahan spon pada palet outer 2GN untuk kebutuhan produksi tanggal 19 juni 2025\r\ntotal kebutuhan produksi 9 palet', '047511607', '', NULL, NULL),
(940, 'WO2025CPW', '2025-06-16 14:28:32', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(941, 'WO2025MDR', '2025-06-16 14:29:01', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(942, 'WO2025CGN', '2025-06-16 14:29:26', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(943, 'WO2025SHC', '2025-06-16 14:29:57', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(944, 'WO2025IQ8', '2025-06-16 14:30:20', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(945, 'WO2025K8U', '2025-06-16 14:30:42', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '162112408', '', NULL, NULL),
(946, 'WO2025C9B', '2025-06-16 14:31:16', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(947, 'WO2025TGP', '2025-06-16 14:31:45', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(948, 'WO2025TGP', '2025-06-16 14:31:48', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(949, 'WO2025WHY', '2025-06-16 14:32:10', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(950, 'WO2025L4T', '2025-06-16 14:32:36', 'Pending waiting sparepart', '', '162112408', '', NULL, NULL),
(951, 'WO2025HFB', '2025-06-16 14:33:01', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '162112408', '', NULL, NULL),
(952, 'WO2025BLV', '2025-06-16 14:33:37', 'Pending waiting sparepart', '', '162112408', '', NULL, NULL),
(953, 'PZgdESB3n', '2025-06-16 14:38:34', 'Pending waiting sparepart', '', '162112408', '', NULL, NULL),
(954, 'WO2025JWB', '2025-06-16 15:08:16', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(955, 'WO2025XR6', '2025-06-16 15:08:31', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(956, 'WO2025PZT', '2025-06-16 15:08:42', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(957, 'WO2025PSY', '2025-06-16 15:08:54', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(958, 'WO2025X80', '2025-06-16 15:09:14', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(959, 'WO2025LCD', '2025-06-16 15:10:06', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(960, 'WO2025KNR', '2025-06-16 16:05:25', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(961, 'WO2025N5C', '2025-06-16 16:09:24', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(962, 'WO2025AXM', '2025-06-16 16:11:02', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(963, 'WO20250SU', '2025-06-16 16:11:20', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(964, '9nkcvIfKC', '2025-06-16 16:20:03', 'On Process', '', '072611806', '', NULL, NULL),
(965, 'WO2025NTI', '2025-06-16 16:20:08', 'On Process', '', '072611806', '', NULL, NULL),
(966, 'WO20251SX', '2025-06-16 16:20:33', 'On Process', '', '072611806', '', NULL, NULL),
(967, 'WO2025KV5', '2025-06-16 16:20:51', 'On Process', '', '072611806', '', NULL, NULL),
(968, 'WO2025MFO', '2025-06-16 16:21:10', 'On Process', '', '072611806', '', NULL, NULL),
(969, 'WO202587L', '2025-06-16 16:21:38', 'On Process', '', '072611806', '', NULL, NULL),
(970, 'WO20251SX', '2025-06-16 16:26:36', 'Work Order Closed. Progress: 100 %', 'Sudah di rubah posisi tangga', '072611806', 'WhatsApp_Image_2025-06-16_at_14_11_23_(3).jpeg', '684fe34c855c3.png', NULL),
(971, '9nkcvIfKC', '2025-06-16 16:27:19', 'Work Order Closed. Progress: 100 %', 'Sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-16_at_14_11_23_(2).jpeg', '684fe377a0570.png', NULL),
(972, 'WO2025MFO', '2025-06-16 16:28:41', 'Work Order Closed. Progress: 100 %', 'Roda sudah di ganti', '072611806', 'WhatsApp_Image_2025-06-16_at_15_23_12.jpeg', '684fe3c9de195.png', NULL),
(973, 'WO2025FWA', '2025-06-16 19:37:06', 'Work Order Closed. Progress: 100 %', 'Sudah di repair hari sabtu tgl 14/6/2025', '072611806', 'WhatsApp_Image_2025-06-16_at_10_07_242.jpeg', '68500ff241318.png', NULL),
(974, 'WO202587L', '2025-06-16 19:38:50', 'Work Order Closed. Progress: 100 %', 'Sudah di modifikasi tambahkan pintu', '072611806', 'WhatsApp_Image_2025-06-16_at_19_41_34.jpeg', '6850105a951b1.png', NULL),
(975, 'WO2025KV5', '2025-06-16 19:40:27', 'Work Order Closed. Progress: 100 %', 'Sudah di tambahkan jig go nogo untuk produk uplide 2GN', '072611806', 'WhatsApp_Image_2025-06-16_at_16_41_21.jpeg', '685010bb9014f.png', NULL),
(976, 'WO2025NTI', '2025-06-16 19:42:22', 'Work Order Closed. Progress: 100 %', 'Engsel Pintu chamber sudah di welding', '072611806', 'WhatsApp_Image_2025-06-16_at_15_23_12_(1).jpeg', '6850112e80a38.png', NULL),
(977, 'WO2025GZE', '2025-06-17 01:14:37', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Lampu gedung nvh depan kondisi menyala tetapi redup. pencahyaan area nvh jadi kurang maksimal', '128012210', '', NULL, NULL),
(978, 'WO2025MBF', '2025-06-17 03:17:22', 'Ticket Submited. Kategori: Request(Request)', 'Pengelasan kembali roda meja waiting yang copot dibagian las-lasan nya, qty 1 pcs yg copot (meja waiting/pendingin rul ) ', '127912210', '', NULL, NULL),
(979, 'WO20250RN', '2025-06-17 03:21:06', 'Ticket Submited. Kategori: Repair(Repair jig)', 'Roda pada jig D26A lepas 1 pcs dan bengkok 1 pcs total 2 roda butuh perbaikan pergantian roda yang baru (pemasangan roda baru pada jig tersebut)', '127912210', '', NULL, NULL),
(980, 'WO2025JWB', '2025-06-17 07:23:33', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(981, 'WO2025XR6', '2025-06-17 07:23:49', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(982, 'WO2025PZT', '2025-06-17 07:24:04', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(983, 'WO2025PSY', '2025-06-17 07:24:54', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(984, 'WO2025X80', '2025-06-17 07:25:21', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(985, 'WO2025LCD', '2025-06-17 07:26:21', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(986, 'WO2025ACC', '2025-06-17 07:31:36', 'Ticket Submited. Kategori: Repair(Repair jig)', 'Posisi panel berada di bawah sehingga sedikit menyulitkan saat cek jig, dan panel juga cepat kotor debu \r\n\r\nNote: di rubah posisi panel seperti jig liner 5j45 ', '005711310', '', NULL, NULL),
(987, 'WO2025WAN', '2025-06-17 09:55:45', 'Ticket Submited. Kategori: Fabrikasi(Jig)', 'Jig untuk pengujian asphalt \r\nSteel plat 1mm\r\nJumlah : 6pcs', '134322209', '', NULL, NULL),
(988, 'WO2025ACC', '2025-06-17 10:15:49', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(989, 'WO20250RN', '2025-06-17 10:16:07', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(990, 'WO20250RN', '2025-06-17 10:16:11', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(991, 'WO2025MBF', '2025-06-17 10:16:29', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(992, 'WO2025GZE', '2025-06-17 10:16:40', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(993, 'WO2025VL1', '2025-06-17 10:17:38', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(994, 'WO2025H7H', '2025-06-17 10:18:05', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(995, 'WO20258FL', '2025-06-17 10:18:44', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(996, 'WO2025TNE', '2025-06-17 10:19:22', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(997, 'WO2025WN7', '2025-06-17 10:19:40', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(998, 'WO2025RNE', '2025-06-17 10:20:01', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(999, 'WO2025CTD', '2025-06-17 10:21:15', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(1000, 'WO2025QEC', '2025-06-17 10:21:35', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(1001, 'WO2025TQY', '2025-06-17 10:22:02', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(1002, 'WO2025XFK', '2025-06-17 10:22:18', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(1003, 'WO2025DWN', '2025-06-17 10:23:22', 'Work Order Approved', 'Approved by Supervisor Dept', '050411610', '', NULL, NULL),
(1004, 'WO2025ACC', '2025-06-17 10:28:36', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1005, 'WO20250RN', '2025-06-17 10:29:02', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1006, 'WO2025MBF', '2025-06-17 10:29:16', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1007, 'WO2025GZE', '2025-06-17 10:29:31', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1008, 'WO2025VL1', '2025-06-17 10:30:18', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1009, 'WO2025H7H', '2025-06-17 10:30:40', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1010, 'WO20258FL', '2025-06-17 10:31:23', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1011, 'WO2025TNE', '2025-06-17 10:31:47', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1012, 'WO2025WN7', '2025-06-17 10:33:00', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1013, 'WO2025RNE', '2025-06-17 10:34:10', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1014, 'WO2025CTD', '2025-06-17 10:34:27', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1015, 'WO2025TQY', '2025-06-17 10:35:25', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1016, 'WO2025XFK', '2025-06-17 10:36:06', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1017, 'WO2025DWN', '2025-06-17 10:36:53', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1018, 'WO2025QEC', '2025-06-17 10:37:30', 'Work Order Approved', 'Approved by Manager Dept', '009611410', '', NULL, NULL),
(1019, 'WO2025ACC', '2025-06-17 11:07:32', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1020, 'WO20250RN', '2025-06-17 11:07:53', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1021, 'WO2025MBF', '2025-06-17 11:08:11', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1022, 'WO2025GZE', '2025-06-17 11:08:56', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1023, 'WO2025JWB', '2025-06-17 11:09:55', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1024, 'WO2025XR6', '2025-06-17 11:10:29', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1025, 'WO2025PZT', '2025-06-17 11:10:48', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1026, 'WO2025PSY', '2025-06-17 11:11:14', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1027, 'WO2025PSY', '2025-06-17 11:11:21', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1028, 'WO2025X80', '2025-06-17 11:12:22', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1029, 'WO2025LCD', '2025-06-17 11:15:04', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1030, 'WO2025CUT', '2025-06-17 11:15:34', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-17_at_11_15_36_(1).jpeg', '6850ebe675c74.png', NULL),
(1031, 'WO2025VL1', '2025-06-17 11:15:39', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1032, 'WO2025GGY', '2025-06-17 11:18:50', 'Work Order Closed. Progress: 100 %', 'Palet sudah di repair', '072611806', 'WhatsApp_Image_2025-06-17_at_11_15_36.jpeg', '6850ecaa7f093.png', NULL),
(1033, 'WO202550M', '2025-06-17 11:19:24', 'Ticket Submited. Kategori: Repair(Repair pallet)', 'Palet NG return customer tanggal 13 & 16 Juni 2025', '047511607', '', NULL, NULL),
(1034, 'WO2025RMS', '2025-06-17 11:19:42', 'Work Order Closed. Progress: 100 %', 'Palet sudah di repair', '072611806', 'WhatsApp_Image_2025-06-17_at_11_15_35_(2).jpeg', '6850ecde513f3.png', NULL),
(1035, 'WO2025WIV', '2025-06-17 11:23:15', 'Work Order Closed. Progress: 100 %', 'Palet sudah di perbaiki', '072611806', 'WhatsApp_Image_2025-06-17_at_11_15_35_(2)1.jpeg', '6850edb35b369.png', NULL),
(1036, 'WO2025YO2', '2025-06-17 11:27:18', 'Work Order Closed. Progress: 100 %', 'Palet progress modifikasi penambahan dudukan barcode RFID , target selesai bulan juli', '072611806', 'WhatsApp_Image_2025-06-17_at_11_30_30.jpeg', '6850eea63a899.png', NULL),
(1037, 'WO2025IFP', '2025-06-17 11:41:28', 'On Process', '', '072611806', '', NULL, NULL),
(1038, 'WO2025H7H', '2025-06-17 15:08:12', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1039, 'WO20258FL', '2025-06-17 15:08:34', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1040, 'WO2025TNE', '2025-06-17 15:08:56', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1041, 'WO2025WN7', '2025-06-17 15:09:22', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1042, 'WO2025RNE', '2025-06-17 15:09:44', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1043, 'WO2025CTD', '2025-06-17 15:10:00', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1044, 'WO2025TQY', '2025-06-17 15:10:33', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1045, 'WO2025XFK', '2025-06-17 15:10:53', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1046, 'WO2025XFK', '2025-06-17 15:10:58', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1047, 'WO2025DWN', '2025-06-17 15:11:17', 'Work Order Assign To', 'Work Order Assign to SPVM', '159912408', '', NULL, NULL),
(1048, 'WO202550M', '2025-06-17 15:11:40', 'Work Order Approved', 'Approved by Supervisor Dept', '000521205', '', NULL, NULL),
(1049, 'WO2025QEC', '2025-06-17 15:12:09', 'Work Order Assign To', 'Work Order Assign to SPVU', '159912408', '', NULL, NULL),
(1050, 'WO2025IFP', '2025-06-17 15:56:25', 'Work Order Closed. Progress: 100 %', 'Sudah di grinding finishing', '072611806', 'WhatsApp_Image_2025-06-17_at_06_40_52.jpeg', '68512db96adaf.png', NULL),
(1051, 'WO20250RN', '2025-06-17 18:34:09', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(1052, 'WO2025MBF', '2025-06-17 18:35:37', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(1053, 'WO20257DZ', '2025-06-17 18:42:25', 'Work Order Received', 'Priority of the Work Order is set to Low and assigned to technician.', '144222308', '', NULL, NULL),
(1054, 'WO2025DWN', '2025-06-17 18:46:03', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(1055, 'WO2025TQY', '2025-06-17 18:55:51', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(1056, 'WO20258FL', '2025-06-17 19:00:42', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL),
(1057, 'WO2025RNE', '2025-06-17 19:01:25', 'Work Order Received', 'Priority of the Work Order is set to Medium and assigned to technician.', '144222308', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `level` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
(14, 'it', '25d55ad283aa400af464c76d713c07ad', 'Admin'),
(19, '144222308', '25d55ad283aa400af464c76d713c07ad', 'SPVM'),
(20, '072611806', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(21, '159912408', '25d55ad283aa400af464c76d713c07ad', 'MGR'),
(22, '053811708', 'f448af652069fe22c400771f31b12b49', 'Technician'),
(23, '002611305', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(24, '162112408', '25d55ad283aa400af464c76d713c07ad', 'SPVU'),
(25, '007811310', '25d55ad283aa400af464c76d713c07ad', 'User'),
(26, '018511410', '18ca120d8ee1ac0b41011a9fb7ee0a1a', 'User'),
(27, '015311410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(28, '025511510', '8b673313118bc645787d4285c3f773c0', 'User'),
(29, '050411610', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(30, '127012210', '25d55ad283aa400af464c76d713c07ad', 'User'),
(31, '044811610', '25d55ad283aa400af464c76d713c07ad', 'User'),
(32, '107612010', '25d55ad283aa400af464c76d713c07ad', 'User'),
(33, '142612210', '25d55ad283aa400af464c76d713c07ad', 'User'),
(34, '010411410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(35, '127912210', '25d55ad283aa400af464c76d713c07ad', 'User'),
(36, '016911410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(37, '009211410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(38, '046311610', '25d55ad283aa400af464c76d713c07ad', 'User'),
(39, '011911410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(40, '128012210', 'c7921e9ce49ecdab321e6abdcf3d8950', 'User'),
(41, '107512010', '25d55ad283aa400af464c76d713c07ad', 'User'),
(42, '047511607', '25d55ad283aa400af464c76d713c07ad', 'User'),
(43, '159812407', 'c43a87e89b4555bd089f0648fb118061', 'User'),
(44, '000521205', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(45, '018611410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(46, '008611410', '25d55ad283aa400af464c76d713c07ad', 'User'),
(47, '154412305', '25d55ad283aa400af464c76d713c07ad', 'MGRD'),
(59, '005711310', '25d55ad283aa400af464c76d713c07ad', 'User'),
(60, '145612310', '25d55ad283aa400af464c76d713c07ad', 'User'),
(61, 'informasi teknology', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(62, '124312110', '20ab37bf2c9d88266407fa505cb53e5e', 'User'),
(63, '009611410', '95d47be0d380a7cd3bb5bbe78e8bed49', 'MGRD'),
(64, '156312407', '049615e3698158c8e5cf37fa7391f622', 'MGRD'),
(65, '162922505', '25d55ad283aa400af464c76d713c07ad', 'MGRD'),
(66, '127412209', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(67, '117112106', '25d55ad283aa400af464c76d713c07ad', 'MGRD'),
(68, '144022305', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(69, '058711706', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(70, '281131', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(71, '038321605', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(72, '157012409', '25d55ad283aa400af464c76d713c07ad', 'User'),
(73, '134322209', '25d55ad283aa400af464c76d713c07ad', 'User'),
(74, '163122511', 'ea320a86cb2b16846ae6be090faf4ed3', 'MGRD'),
(75, '028111510', '25d55ad283aa400af464c76d713c07ad', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_dept`);

--
-- Indexes for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  ADD PRIMARY KEY (`id_bagian_dept`),
  ADD KEY `fk_id_dept` (`id_dept`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_informasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  ADD PRIMARY KEY (`id_sub_kategori`),
  ADD KEY `fk_id_kategori` (`id_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `fk_id_bagian_dept` (`id_bagian_dept`),
  ADD KEY `fk_id_jabatan` (`id_jabatan`);

--
-- Indexes for table `prioritas`
--
ALTER TABLE `prioritas`
  ADD PRIMARY KEY (`id_prioritas`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `reported` (`reported`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `id_sub_kategori` (`id_sub_kategori`);

--
-- Indexes for table `ticket_message`
--
ALTER TABLE `ticket_message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id_tracking`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_nik` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  MODIFY `id_bagian_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prioritas`
--
ALTER TABLE `prioritas`
  MODIFY `id_prioritas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ticket_message`
--
ALTER TABLE `ticket_message`
  MODIFY `id_message` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id_tracking` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1058;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  ADD CONSTRAINT `fk_id_dept` FOREIGN KEY (`id_dept`) REFERENCES `departemen` (`id_dept`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `informasi`
--
ALTER TABLE `informasi`
  ADD CONSTRAINT `informasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  ADD CONSTRAINT `fk_id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_id_bagian_dept` FOREIGN KEY (`id_bagian_dept`) REFERENCES `departemen_bagian` (`id_bagian_dept`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`reported`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`id_sub_kategori`) REFERENCES `kategori_sub` (`id_sub_kategori`);

--
-- Constraints for table `ticket_message`
--
ALTER TABLE `ticket_message`
  ADD CONSTRAINT `ticket_message_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_message_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracking_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_nik` FOREIGN KEY (`username`) REFERENCES `pegawai` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

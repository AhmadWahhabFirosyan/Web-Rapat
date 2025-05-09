-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2025 at 02:29 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meeting_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int NOT NULL,
  `theme` varchar(255) NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` time NOT NULL,
  `status` enum('Online','Offline') NOT NULL,
  `attendees` text NOT NULL,
  `notes` text NOT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `leader` varchar(100) NOT NULL,
  `department` enum('IT','Marketing','HR','Keuangan','Produksi','Sales') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `theme`, `meeting_date`, `meeting_time`, `status`, `attendees`, `notes`, `meeting_link`, `file_path`, `leader`, `department`, `created_at`) VALUES
(1, 'Rapat Kickoff Proyek A', '2025-01-05', '09:00:00', 'Online', 'Budi, Ani, Citra, Doni, Eka', 'Membahas timeline proyek dan pembagian tugas. Deadline minggu depan.', 'https://zoom.us/j/123456789', 'uploads/agenda_proyek_a.pdf', 'Pak Budi', 'IT', '2025-01-01 01:00:00'),
(2, 'Evaluasi Bulanan Tim Marketing', '2025-01-10', '14:00:00', 'Offline', 'Fajar, Gita, Hadi, Indah', 'Hasil kampanye bulan ini meningkat 20%. Perlu strategi baru untuk Q2.', NULL, NULL, 'Bu Gita', 'Marketing', '2025-01-05 03:00:00'),
(3, 'Brainstorming Ide Produk Baru', '2025-01-15', '10:30:00', 'Online', 'Joko, Kania, Luki, Mira, Nanda', 'Ide: aplikasi manajemen tugas dengan AI. Perlu riset lebih lanjut.', 'https://meet.google.com/abc-defg-hij', NULL, 'Pak Joko', 'Produksi', '2025-01-10 02:00:00'),
(4, 'Rapat Koordinasi Tim IT', '2025-01-20', '13:00:00', 'Offline', 'Omar, Putri, Rian, Siti', 'Server down 2x minggu ini. Perlu upgrade infrastruktur.', NULL, 'uploads/laporan_it_jan.pdf', 'Bu Putri', 'IT', '2025-01-15 04:00:00'),
(5, 'Rapat Penutup Proyek B', '2025-01-25', '15:00:00', 'Online', 'Tina, Udin, Vina, Wawan, Xena', 'Proyek selesai tepat waktu. Klien puas dengan hasil.', 'https://zoom.us/j/987654321', NULL, 'Pak Udin', 'IT', '2025-01-20 07:00:00'),
(6, 'Rapat Anggaran Q1', '2025-02-01', '09:30:00', 'Offline', 'Yani, Zaki, Ardi, Bela', 'Anggaran disetujui. Fokus pada pengeluaran marketing.', NULL, NULL, 'Bu Yani', 'Keuangan', '2025-01-25 01:30:00'),
(7, 'Pelatihan Tim Sales', '2025-02-05', '11:00:00', 'Online', 'Candra, Dita, Eko, Fina, Gani', 'Materi: Teknik negosiasi. Peserta aktif bertanya.', 'https://meet.google.com/xyz-1234-abc', 'uploads/materi_sales.pdf', 'Pak Eko', 'Sales', '2025-02-01 03:00:00'),
(8, 'Rapat Evaluasi Proyek C', '2025-02-10', '14:30:00', 'Offline', 'Hendra, Ika, Juna, Kiki', 'Proyek tertunda karena kurangnya sumber daya. Perlu rekrutmen.', NULL, NULL, 'Bu Ika', 'IT', '2025-02-05 06:00:00'),
(9, 'Diskusi Strategi Pemasaran', '2025-02-15', '10:00:00', 'Online', 'Lia, Miko, Nita, Oki, Prita', 'Fokus pada media sosial untuk menarik Gen Z.', 'https://zoom.us/j/456789123', NULL, 'Bu Lia', 'Marketing', '2025-02-10 02:00:00'),
(10, 'Rapat Tim Desain Produk', '2025-02-20', '13:30:00', 'Offline', 'Rudi, Siska, Tono, Umi', 'Desain UI/UX perlu revisi berdasarkan feedback pengguna.', NULL, 'uploads/desain_produk.pdf', 'Pak Rudi', 'Produksi', '2025-02-15 05:00:00'),
(11, 'Rapat Kickoff Proyek D', '2025-02-25', '09:00:00', 'Online', 'Vera, Wandi, Xena, Yudi, Zizi', 'Membahas scope dan ekspektasi klien.', 'https://meet.google.com/def-4567-ghi', NULL, 'Bu Vera', 'IT', '2025-02-20 01:00:00'),
(12, 'Rapat Bulanan Tim HR', '2025-03-01', '14:00:00', 'Offline', 'Andi, Bima, Cici, Dedi', 'Diskusi kebijakan WFH baru. Karyawan setuju.', NULL, NULL, 'Pak Andi', 'HR', '2025-02-25 06:00:00'),
(13, 'Workshop Kepemimpinan', '2025-03-05', '10:00:00', 'Online', 'Evi, Fani, Geri, Hana, Indra', 'Materi: Kepemimpinan adaptif. Peserta antusias.', 'https://zoom.us/j/789123456', 'uploads/materi_leadership.pdf', 'Bu Evi', 'HR', '2025-03-01 02:00:00'),
(14, 'Rapat Proyek E', '2025-03-10', '15:00:00', 'Offline', 'Jaka, Kiki, Lani, Mira', 'Progres 50%. Tantangan: komunikasi dengan vendor.', NULL, NULL, 'Pak Jaka', 'IT', '2025-03-05 07:00:00'),
(15, 'Rapat Strategi Penjualan Q2', '2025-03-15', '11:30:00', 'Online', 'Nana, Opi, Puji, Raka, Sani', 'Target penjualan naik 15%. Fokus pada produk baru.', 'https://meet.google.com/ghi-7890-jkl', NULL, 'Bu Nana', 'Sales', '2025-03-10 03:00:00'),
(16, 'Rapat Tim Keuangan', '2025-03-20', '13:00:00', 'Offline', 'Tika, Umi, Vino, Wira', 'Laporan keuangan Q1 disetujui. Pengeluaran sesuai anggaran.', NULL, 'uploads/laporan_keuangan_q1.pdf', 'Pak Vino', 'Keuangan', '2025-03-15 05:00:00'),
(17, 'Rapat Penutup Proyek F', '2025-03-25', '09:30:00', 'Online', 'Xavi, Yani, Zaka, Arif, Bela', 'Proyek selesai dengan sedikit kendala teknis.', 'https://zoom.us/j/321654987', NULL, 'Bu Yani', 'IT', '2025-03-20 01:30:00'),
(18, 'Rapat Koordinasi Tim Operasional', '2025-04-01', '14:00:00', 'Offline', 'Cici, Dedi, Eko, Fina', 'Efisiensi operasional meningkat 10%.', NULL, NULL, 'Pak Dedi', 'Produksi', '2025-03-25 06:00:00'),
(19, 'Rapat Kickoff Proyek G', '2025-04-05', '10:00:00', 'Online', 'Gani, Hana, Indra, Jaka, Kania', 'Membahas rencana kerja dan risiko proyek.', 'https://meet.google.com/jkl-0123-mno', 'uploads/agenda_proyek_g.pdf', 'Bu Hana', 'IT', '2025-04-01 02:00:00'),
(20, 'Rapat Evaluasi Tim Produksi', '2025-04-10', '15:00:00', 'Offline', 'Lani, Mira, Nanda, Oki', 'Produksi bulan ini sesuai target.', NULL, NULL, 'Pak Nanda', 'Produksi', '2025-04-05 07:00:00'),
(21, 'Brainstorming Kampanye Baru', '2025-04-15', '11:00:00', 'Online', 'Prita, Rudi, Siska, Tono, Umi', 'Ide: Kampanye bertema sustainability.', 'https://zoom.us/j/654987321', NULL, 'Bu Prita', 'Marketing', '2025-04-10 03:00:00'),
(22, 'Rapat Tim Pengembangan', '2025-04-20', '13:30:00', 'Offline', 'Vera, Wandi, Xena, Yudi', 'Fitur baru selesai 80%. Perlu uji coba.', NULL, 'uploads/laporan_dev_apr.pdf', 'Pak Wandi', 'IT', '2025-04-15 05:00:00'),
(23, 'Rapat Anggaran Q2', '2025-04-25', '09:00:00', 'Online', 'Zizi, Andi, Bima, Cici, Dedi', 'Anggaran disetujui dengan penyesuaian kecil.', 'https://meet.google.com/mno-3456-pqr', NULL, 'Bu Zizi', 'Keuangan', '2025-04-20 01:00:00'),
(24, 'Rapat Bulanan Tim Sales', '2025-05-01', '14:00:00', 'Offline', 'Eko, Fina, Gani, Hana', 'Penjualan bulan ini naik 10%.', NULL, NULL, 'Pak Eko', 'Sales', '2025-04-25 06:00:00'),
(25, 'Workshop Digital Marketing', '2025-05-05', '10:30:00', 'Online', 'Indra, Jaka, Kania, Lani, Mira', 'Materi: SEO dan SEM. Peserta aktif.', 'https://zoom.us/j/987321654', 'uploads/materi_digital_marketing.pdf', 'Bu Kania', 'Marketing', '2025-05-01 02:00:00'),
(26, 'Rapat Proyek H', '2025-05-10', '15:00:00', 'Offline', 'Nanda, Oki, Prita, Rudi', 'Progres 70%. Deadline akhir bulan.', NULL, NULL, 'Pak Oki', 'IT', '2025-05-05 07:00:00'),
(27, 'Rapat Strategi Penjualan Q3', '2025-05-15', '11:00:00', 'Online', 'Siska, Tono, Umi, Vera, Wandi', 'Target penjualan naik 20%. Fokus pada klien besar.', 'https://meet.google.com/pqr-6789-stu', NULL, 'Bu Siska', 'Sales', '2025-05-10 03:00:00'),
(28, 'Rapat Tim Keuangan', '2025-05-20', '13:30:00', 'Offline', 'Xena, Yudi, Zizi, Andi', 'Pengeluaran bulan ini melebihi anggaran.', NULL, 'uploads/laporan_keuangan_mei.pdf', 'Pak Yudi', 'Keuangan', '2025-05-15 05:00:00'),
(29, 'Rapat Penutup Proyek I', '2025-05-25', '09:00:00', 'Online', 'Bima, Cici, Dedi, Eko, Fina', 'Proyek selesai dengan hasil memuaskan.', 'https://zoom.us/j/123789456', NULL, 'Bu Cici', 'IT', '2025-05-20 01:00:00'),
(30, 'Rapat Koordinasi Tim IT', '2025-05-30', '14:00:00', 'Offline', 'Gani, Hana, Indra, Jaka', 'Upgrade server selesai. Performa meningkat.', NULL, NULL, 'Pak Indra', 'IT', '2025-05-25 06:00:00'),
(31, 'Rapat Kickoff Proyek J', '2025-05-31', '10:00:00', 'Online', 'Kania, Lani, Mira, Nanda, Oki', 'Membahas jadwal dan sumber daya proyek.', 'https://meet.google.com/stu-9012-vwx', 'uploads/agenda_proyek_j.pdf', 'Bu Mira', 'IT', '2025-05-30 02:00:00'),
(32, 'Rapat Evaluasi Tim Marketing', '2025-05-02', '15:00:00', 'Offline', 'Prita, Rudi, Siska, Tono', 'Kampanye bulan ini berhasil.', NULL, NULL, 'Pak Rudi', 'Marketing', '2025-05-01 07:00:00'),
(33, 'Brainstorming Produk Baru', '2025-05-03', '11:30:00', 'Online', 'Umi, Vera, Wandi, Xena, Yudi', 'Ide: Platform edukasi online.', 'https://zoom.us/j/456123789', NULL, 'Bu Umi', 'Produksi', '2025-05-02 03:00:00'),
(34, 'Rapat Tim Desain', '2025-05-04', '13:00:00', 'Offline', 'Zizi, Andi, Bima, Cici', 'Desain baru disetujui klien.', NULL, 'uploads/desain_mei.pdf', 'Pak Andi', 'Produksi', '2025-05-03 05:00:00'),
(35, 'Rapat Anggaran Q3', '2025-05-06', '09:30:00', 'Online', 'Dedi, Eko, Fina, Gani, Hana', 'Anggaran disetujui dengan revisi.', 'https://meet.google.com/vwx-2345-yza', NULL, 'Bu Fina', 'Keuangan', '2025-05-05 01:30:00'),
(36, 'Rapat Bulanan Tim HR', '2025-05-07', '14:00:00', 'Offline', 'Indra, Jaka, Kania, Lani', 'Diskusi kenaikan gaji tahunan.', NULL, NULL, 'Pak Jaka', 'HR', '2025-05-06 06:00:00'),
(37, 'Workshop Kepemimpinan Lanjutan', '2025-05-08', '10:00:00', 'Online', 'Mira, Nanda, Oki, Prita, Rudi', 'Materi: Kepemimpinan transformasional.', 'https://zoom.us/j/789456123', 'uploads/materi_leadership_mei.pdf', 'Bu Nanda', 'HR', '2025-05-07 02:00:00'),
(38, 'Rapat Proyek K', '2025-05-09', '15:00:00', 'Offline', 'Siska, Tono, Umi, Vera', 'Progres 30%. Perlu tambahan tim.', NULL, NULL, 'Pak Tono', 'IT', '2025-05-08 07:00:00'),
(39, 'Rapat Strategi Penjualan Q4', '2025-05-11', '11:00:00', 'Online', 'Wandi, Xena, Yudi, Zizi, Andi', 'Target penjualan akhir tahun ambisius.', 'https://meet.google.com/yza-5678-bcd', NULL, 'Bu Xena', 'Sales', '2025-05-10 03:00:00'),
(40, 'Rapat Tim Keuangan', '2025-05-12', '13:30:00', 'Offline', 'Bima, Cici, Dedi, Eko', 'Laporan keuangan Q2 disetujui.', NULL, 'uploads/laporan_keuangan_q2.pdf', 'Pak Bima', 'Keuangan', '2025-05-11 05:00:00'),
(41, 'Rapat Penutup Proyek L', '2025-05-13', '09:00:00', 'Online', 'Fina, Gani, Hana, Indra, Jaka', 'Proyek selesai dengan sedikit revisi.', 'https://zoom.us/j/123456789', NULL, 'Bu Gani', 'IT', '2025-05-12 01:00:00'),
(42, 'Rapat Koordinasi Tim Operasional', '2025-05-14', '14:00:00', 'Offline', 'Kania, Lani, Mira, Nanda', 'Efisiensi operasional stabil.', NULL, NULL, 'Pak Lani', 'Produksi', '2025-05-13 06:00:00'),
(43, 'Rapat Kickoff Proyek M', '2025-05-15', '10:00:00', 'Online', 'Oki, Prita, Rudi, Siska, Tono', 'Membahas ekspektasi klien dan timeline.', 'https://meet.google.com/bcd-9012-efg', 'uploads/agenda_proyek_m.pdf', 'Bu Prita', 'IT', '2025-05-14 02:00:00'),
(44, 'Rapat Evaluasi Tim Produksi', '2025-05-16', '15:00:00', 'Offline', 'Umi, Vera, Wandi, Xena', 'Produksi bulan ini sedikit tertunda.', NULL, NULL, 'Pak Wandi', 'Produksi', '2025-05-15 07:00:00'),
(45, 'Brainstorming Kampanye Baru', '2025-05-17', '11:30:00', 'Online', 'Yudi, Zizi, Andi, Bima, Cici', 'Ide: Kampanye bertema inklusivitas.', 'https://zoom.us/j/456789123', NULL, 'Bu Zizi', 'Marketing', '2025-05-16 03:00:00'),
(46, 'Rapat Tim Pengembangan', '2025-05-18', '13:00:00', 'Offline', 'Dedi, Eko, Fina, Gani', 'Fitur baru selesai 90%.', NULL, 'uploads/laporan_dev_mei.pdf', 'Pak Eko', 'IT', '2025-05-17 05:00:00'),
(47, 'Rapat Anggaran Q4', '2025-05-19', '09:30:00', 'Online', 'Hana, Indra, Jaka, Kania, Lani', 'Anggaran disetujui dengan catatan.', 'https://meet.google.com/efg-3456-hij', NULL, 'Bu Hana', 'Keuangan', '2025-05-18 01:30:00'),
(48, 'Rapat Bulanan Tim Sales', '2025-05-20', '14:00:00', 'Offline', 'Mira, Nanda, Oki, Prita', 'Penjualan bulan ini sesuai target.', NULL, NULL, 'Pak Oki', 'Sales', '2025-05-19 06:00:00'),
(49, 'Workshop Digital Marketing Lanjutan', '2025-05-21', '10:00:00', 'Online', 'Rudi, Siska, Tono, Umi, Vera', 'Materi: Iklan berbasis data.', 'https://zoom.us/j/789123456', 'uploads/materi_digital_marketing_mei.pdf', 'Bu Siska', 'Marketing', '2025-05-20 02:00:00'),
(50, 'Rapat Proyek N', '2025-05-22', '15:00:00', 'Offline', 'Wandi, Xena, Yudi, Zizi', 'Progres 40%. Perlu koordinasi lebih lanjut.', NULL, NULL, 'Pak Yudi', 'IT', '2025-05-21 07:00:00'),
(51, 'SINFO IT', '2025-05-09', '09:00:00', 'Online', 'wahhab, rifqi, alvin, jason, dean, jambu', 'Rapat ini membahas beberapa masa depan web3 yang akan kami kembangkan menggunakan crypto.', 'https://meet.google.com/stu-9012', '', 'Pak Wahhab', 'IT', '2025-05-09 02:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('Admin','Peserta') DEFAULT 'Peserta',
  `department` enum('IT','Marketing','HR','Keuangan','Produksi','Sales') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `department`, `created_at`) VALUES
(1, 'wahhab', '$2y$10$pZJKBYGOjZtAWrcvzwsElOD5cPFPVkCZ5lqpYZPUb0rcHDJV0j63C', 'ahmadwahhabfirosyan@gmail.com', 'Admin', 'IT', '2025-05-09 01:54:26'),
(2, 'rifqii', '$2y$10$XiPqBgXZ4hGZNOqBWcE5O.tvOEyqP0xRSfpc3dXUOGZPQMopDGYXq', 'rifqiboi@gmail.com', 'Peserta', 'Keuangan', '2025-05-09 02:04:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

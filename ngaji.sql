-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `expired_day` int(11) DEFAULT 0,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`id`, `name`, `details`, `price`, `image`) VALUES
(111, 'Dr. Vora', 'Dr. Vora', 1000000, 'Dr.VoraR.png'),
(112, 'Dr. Mike', 'Dr. Mike', 1250000, 'Dr.MikeR.png'),
(113, 'Dr. Jonny', 'Dr. Jonny', 1500000, 'Dr.JonnyR.png');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(14, 0, 'tes', 'fiqri@gmail.com', '123', '123'),
(15, 0, 'fiqri', '123@gmail.com', '081234567', 'haloo halo halo'),
(16, 22, 'piqri', '123@gmail', '0812121', 'fiqri heheheheaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(11) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `expired_at` timestamp NULL DEFAULT NULL,
  `expired_day` int(11) DEFAULT 0,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `expired_at`, `expired_day`, `type`) VALUES
(48, 20, 'fiqri', '123456789', 'fiqri@gmail.com', 'BCA', '', ' 3 Month - Gold (1) ', 100000, '2024-07-08 12:29:21', 'Completed', '2024-10-06 07:29:21', 90, 'product'),
(49, 20, 'fiqri', '1221212', 'fiqri@gmail.com', 'BCA', '', ' Dr. Mike (1) ', 1250000, '2024-07-08 12:29:46', 'Completed', '2024-07-08 07:29:46', 0, 'konsultasi');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `expired_day` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image`, `expired_day`) VALUES
(22, '1 Month - Bronze', 'Bronze Medal', 50000, 'bronzeR.png', 30),
(23, '2 Month - Silver', 'Silver Medal', 75000, 'silverR.png', 60),
(24, '3 Month - Gold', 'Gold Medal', 100000, 'goldR.png', 90);

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `details` varchar(500) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`id`, `name`, `location`, `time`, `price`, `contact`, `details`, `image`) VALUES
(8, 'Building Character in the Digital Age', 'Yogyakarta', '09:00 - 11:00 AM', '30000', '08123456789', 'This seminar explores how parents can effectively nurture their children\'s character development amidst the influences of digital media and technology. Learn strategies to balance screen time and instill values in your child.\r\n', 'seminar2.jpg'),
(9, 'Wise Parents, Brilliant Children', 'Pontianak', '08:00 - 10:30 AM', '25000', '08123456789', 'Discover the secrets to becoming a wise parent who can foster brilliance and success in your child. This seminar provides insights into effective communication, setting boundaries, and encouraging intellectual growth.', 'seminar3.jpg'),
(10, 'Effective Parenting Strategies', 'Jakarta', '13:00 - 15:00 PM', '35000', '08123456789', 'Join us to learn about proven parenting strategies that can help you navigate the challenges of raising children. Topics include discipline techniques, fostering independence, and building strong parent-child relationships.', 'seminar4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `solving`
--

CREATE TABLE `solving` (
  `id` int(11) NOT NULL,
  `keluhan` varchar(255) NOT NULL,
  `cara_mengatasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solving`
--

INSERT INTO `solving` (`id`, `keluhan`, `cara_mengatasi`) VALUES
(1, 'Masalah Perilaku Anak', '1. Tetap Tenang: Jangan merespons dengan marah atau frustrasi.\n2. Validasi Emosi Anak: Akui perasaan anak dan beri tahu bahwa Anda memahami.\n3. Alihkan Perhatian: Gunakan teknik pengalihan untuk mengubah fokus anak.\n4. Ajarkan Empati: Bantu anak memahami perasaan orang lain.\n5. Modelkan Perilaku yang Baik: Tunjukkan cara berinteraksi dengan tenang dan sopan.'),
(2, 'Komunikasi Efektif', '1. Bicara dengan Jelas dan Sederhana: Gunakan bahasa yang mudah dipahami anak.\r\n2. Gunakan Teknik Mendengarkan Aktif: Tunjukkan perhatian penuh saat anak berbicara.\r\n3. Respon dengan Empati: Tunjukkan bahwa Anda peduli dan mengerti perasaan mereka.\r\n4. Hindari Menghakimi: Biarkan anak berbicara tanpa merasa dihakimi atau dikritik.'),
(3, 'Pengelolaan Waktu dan Rutinitas', '1. Prioritaskan Tugas: Buat daftar prioritas dan alokasikan waktu untuk setiap aktivitas.\r\n2. Libatkan Anak: Ajarkan anak untuk merencanakan hari mereka.\r\n3. Konsistensi: Terapkan rutinitas yang sama setiap hari.\r\n4. Fleksibilitas: Berikan sedikit kelonggaran jika ada perubahan tak terduga.'),
(4, 'Pendidikan dan Pengembangan Anak', '1. Sediakan Lingkungan Belajar yang Menyenangkan: Ciptakan sudut belajar yang menarik.\r\n2. Berikan Dukungan dan Dorongan: Puji usaha dan prestasi anak.\r\n3. Identifikasi Kebutuhan Khusus: Bekerjasama dengan guru untuk memahami kesulitan anak.\r\n4. Sediakan Bantuan Tambahan: Pertimbangkan les tambahan atau tutor jika perlu.\r\n'),
(5, 'Perubahan Perilaku Sosial', '1. Tetapkan Batasan Waktu: Batasi waktu penggunaan gadget sesuai usia anak.\r\n2. Kontrol Konten: Awasi dan kontrol konten yang diakses anak.\r\n3. Ajarkan Keterampilan Sosial: Latih anak untuk berbagi, bergiliran, dan berempati.\r\n4. Hadapi Perundungan (Bullying): Ajarkan anak untuk berbicara dan mencari bantuan jika diperlukan.\r\n'),
(6, 'Masalah Kesehatan Mental', '1. Pahami Tanda-tanda: Kenali gejala kecemasan, depresi, dan masalah emosional lainnya.\r\n2. Cari Bantuan Profesional: Jangan ragu untuk mencari bantuan psikolog atau konselor jika diperlukan.\r\n3. Sediakan Waktu untuk Bicara: Buat waktu rutin untuk mendengarkan anak.\r\n4. Dorong Ekspresi Emosi: Ajarkan anak untuk mengungkapkan perasaan mereka secara sehat.'),
(7, 'Disiplin dan Pengaturan Batasan', '1. Gunakan Disiplin Positif: Fokus pada penguatan positif daripada hukuman.\r\n2. Jelaskan Konsekuensi Logis: Bantu anak memahami akibat dari tindakan mereka.\r\n3. Buat Aturan yang Jelas: Tetapkan aturan yang sederhana dan mudah dimengerti.\r\n4. Terapkan Secara Konsisten: Pastikan aturan diterapkan dengan konsistensi.'),
(8, 'Keseimbangan Antara Kasih Sayang dan Otoritas', '1. Tunjukkan Kasih Sayang: Berikan pelukan, kata-kata dukungan, dan perhatian.\r\n2. Tetapkan Batasan yang Jelas: Jelaskan aturan dan harapan dengan tegas tetapi lembut.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
(10, 'admin A', 'admin01@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'admin', '2024-07-05 13:13:07'),
(15, 'user B', 'user02@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2024-07-05 13:13:07'),
(16, 'bara', 'bara@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2024-07-05 13:13:07'),
(17, 'bayu', 'bayu@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'admin', '2024-07-05 13:13:07'),
(19, 'Piqri', 'Piqri@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'admin', '2024-07-05 13:13:07'),
(20, 'fiqri', 'fiqri@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2024-07-05 13:13:07'),
(21, 'ilcs', 'ilcs@ilcs.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'admin', '2024-07-05 13:13:07'),
(22, 'fiqri1', 'fiqri1@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-07-07 15:40:51'),
(23, 'fiqri2', 'fiqri2@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'user', '2024-07-07 16:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `video` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `kategori` enum('balita','anak_7_tahun','pelajari','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `name`, `details`, `video`, `image`, `kategori`) VALUES
(13, 'Balita 1', 'Balita 1', 'SampleVideo_1280x720_20mb.mp4', 'balita.jpg', 'balita'),
(14, 'Balita 2', 'Balita 2', 'SampleVideo_1280x720_20mb.mp4', 'balita.jpg', 'balita'),
(15, 'Anak Umur 7 Tahun 1', 'Anak Umur 7 Tahun 1', 'SampleVideo_1280x720_20mb.mp4', 'anak7tahun.jpg', 'anak_7_tahun'),
(16, 'Anak Umur 7 Tahun 2', 'Anak Umur 7 Tahun 2', 'SampleVideo_1280x720_20mb.mp4', 'anak7tahun.jpg', 'anak_7_tahun'),
(17, 'Pelajari 1', 'Pelajari 1', 'SampleVideo_1280x720_20mb.mp4', 'pelajari.jpg', 'pelajari'),
(18, 'Pelajari 2', 'Pelajari 2', 'SampleVideo_1280x720_20mb.mp4', 'pelajari.jpg', 'pelajari');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solving`
--
ALTER TABLE `solving`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `seminar`
--
ALTER TABLE `seminar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `solving`
--
ALTER TABLE `solving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

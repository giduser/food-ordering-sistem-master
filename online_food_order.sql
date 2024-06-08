-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 07:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_food_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(9, 'admin1234', '0192023a7bbd73250516f069df18b500', 'admin@gmail.com', 'QFE6ZM', '2022-04-08 08:24:52'),
(12, 'superadmin', 'd138768d3b5eca407f0dd579c5ca3767', 'superadmin@gmail.com', 'QMTZ2J', '2024-06-05 08:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(222) NOT NULL,
  `codes` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_codes`
--

INSERT INTO `admin_codes` (`id`, `codes`) VALUES
(1, 'QX5ZMN'),
(2, 'QFE6ZM'),
(3, 'QMZR92'),
(4, 'QPGIOV'),
(5, 'QSTE52'),
(6, 'QMTZ2J');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `num_reviews` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`, `rating`, `num_reviews`) VALUES
(22, 56, 'Ayam Bakar', 'enak dan mengenyangkan', 25000.00, 'ayamBakar.jfif', 5.00, 1),
(23, 58, 'Ikan Bakar', 'ikan segar yang rasanya nikmat', 20000.00, 'ikanBakar.jpg', 4.00, 1),
(24, 60, 'Sop Iga', 'sop yang segar dengan porsi kumbo', 38000.00, 'sopIga.jpg', 4.00, 1),
(25, 57, 'Ayam Goreng', 'Ayam segar yang digoreng diminyak kelapa dan ditambah kremesan', 25000.00, 'ayamGoreng.jpeg', 0.00, 0),
(26, 59, 'Ikan Goreng', 'ikan yg digoreng dengan minyak kelapa dan dimarinasi dengan bumbu rahasia', 20000.00, 'ikanGoreng.jpg', 0.00, 0),
(27, 61, 'Sop Ayam', 'sop ayam yang segar dan enak dengan sayuran segar ', 15000.00, 'sopAyam.jpg', 0.00, 0),
(28, 62, 'Lalapan', 'lalapan untuk menemani menu utama anda', 10000.00, 'Lalapan.jpg', 0.00, 0),
(29, 63, 'Air Mineral', 'air putih yang sehat dan menyegarkan', 5000.00, 'airMineral.jfif', 0.00, 0),
(30, 64, 'Es Buah', 'minuman segar dengan buah segar dengan rasa manis', 15000.00, 'esBuah.jpg', 0.00, 0),
(31, 65, 'Es Jeruk', 'minuman segar dengan jerus asli tanpa pemanis buatan', 10000.00, 'esJeruk.jpg', 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(71, 41, 'in process', 'in proses', '2022-04-08 08:40:37'),
(72, 44, 'in process', 'sedang di masak', '2022-05-25 04:21:29'),
(73, 44, 'closed', 'sedang di antar', '2022-05-29 12:50:12'),
(74, 44, 'in process', 'sedang di masak', '2022-06-04 00:43:02'),
(75, 44, 'in process', 'sedang di buat', '2022-06-07 11:48:43'),
(76, 49, 'in process', 'sedang di masak', '2022-06-08 11:44:59'),
(77, 49, 'in process', 'process bre', '2022-06-13 08:45:15'),
(78, 49, 'closed', 'silahkan menikmati\r\n', '2022-06-13 12:02:40'),
(79, 50, 'closed', 'segera datang', '2022-06-13 12:12:59'),
(80, 50, 'in process', 'sdad', '2022-06-13 12:14:13'),
(81, 54, 'closed', 'sedang diantar', '2024-06-05 08:51:02'),
(82, 54, 'closed', 'sadasda', '2024-06-05 08:51:22'),
(83, 49, 'closed', 'mantab cuyyy', '2024-06-05 13:16:41'),
(84, 58, 'closed', 'nyampeee', '2024-06-05 13:19:05'),
(85, 50, 'closed', 'kelasss', '2024-06-05 13:19:29'),
(86, 59, 'closed', 'sudah diterima', '2024-06-06 10:25:27'),
(87, 61, 'closed', 'sudah diterima pembayarannya', '2024-06-07 09:35:10'),
(88, 62, 'closed', 'sukses', '2024-06-07 09:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `description`, `image`, `date`) VALUES
(56, 8, 'Ayam Bakar', 'Ayam segar yang dibakar dengan arang kelapa dan bumbu rahasia', 'ayamBakar.jfif', '2024-06-07 04:46:16'),
(57, 8, 'Ayam Goreng', 'Ayam segar yang digoreng diminyak kelapa dan ditambah kremesan', 'ayamGoreng.jpeg', '2024-06-07 05:25:49'),
(58, 11, 'Ikan Bakar', 'Ikan segar yang dibakar dan diberi bumbu spesial', 'ikanBakar.jpg', '2024-06-07 04:49:17'),
(59, 11, 'Ikan Goreng', 'ikan yg digoreng dengan minyak kelapa dan dimarinasi dengan bumbu rahasia', 'ikanGoreng.jpg', '2024-06-07 05:26:16'),
(60, 12, 'Sop Iga', 'sop iga sapi yang segar dan enak cocok ditemani dengan nasi hangat', 'sopIga.jpg', '2024-06-07 04:52:07'),
(61, 12, 'Sop Ayam', 'sop ayam yang segar dan enak dengan sayuran segar ', 'sopAyam.jpg', '2024-06-07 04:55:18'),
(62, 13, 'Lalapan', 'lalapan untuk menemani menu utama anda', 'Lalapan.jpg', '2024-06-07 04:55:18'),
(63, 17, 'Air Mineral', 'air putih yang sehat dan menyegarkan', 'airMineral.jfif', '2024-06-07 04:57:27'),
(64, 17, 'Es Buah', 'minuman segar dengan buah segar dengan rasa manis', 'esBuah.jpg', '2024-06-07 04:57:27'),
(65, 17, 'Es Jeruk', 'minuman segar dengan jerus asli tanpa pemanis buatan', 'esJeruk.jpg', '2024-06-07 04:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(8, 'Ayam', '2024-06-06 15:17:42'),
(11, 'Ikan', '2024-06-06 15:17:53'),
(12, 'Sop', '2024-06-06 15:18:04'),
(13, 'Lalapan', '2024-06-06 15:18:18'),
(17, 'Minuman', '2024-06-06 15:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dish_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `rating`, `review`, `created_at`, `dish_id`) VALUES
(32, 'admin 123', 'admin123@gmail.com', 5, 'enak banget', '2024-06-07 05:42:19', 22),
(33, 'admin 123', 'admin123@gmail.com', 4, 'Resto lesehan konsep garden classic yang asik dan lengkap menunya untuk keluarga.\r\nAneka olahan ayam, nasi, sayur, ikan , dan minuman yang komplit.', '2024-06-07 09:30:37', 23),
(34, 'admin 123', 'admin123@gmail.com', 4, 'Kesini karena lewat dan kelihatannya menarik. Pesan beberapa menu yang ternyata perlu dikonfirmasi dulu ke orang dapur kalau stoknya masih ada atau ga ada hehe.\r\nAkhirnya pesan:\r\n1. Cah kangkung / Tumis Kangkung â­4/5\r\nRasanya standar, ga terlalu istimewa, kangkungnya  bagian batang masih agak keras.\r\n2. Sup ikan â­4.5/5\r\nIni enak, asam segar, porsi cukup untuk 2-3 orang. Ikannya matang dengan baik dan bersih\r\n3. Ikan bakar â­4.5/5\r\nLupa pesan ikan apa karena beberapa kali dikonfirmasi ikan yang diinginkan ga ada hehe. Terus ganti ke ikan lain. Bumbunya lumayan oke.\r\n\r\nNilai plus selain menu karena toiletnya lumayan bersih, ada mushola dan tempatnya cukup terang.\r\nSayangnya, kurang koordinasi antara pelayan dengan bagian dapur, jadi untuk menu perlu konfirmasi bolak balik antara pelayan dan bagian dapur. Kedepannya mungkin bisa lebih ditingkatkan pelayanannya.\r\n\r\nOhiya, akan ada yang nawarin makanan tahu walik, lumayan enak, cuma harganya cukup mahal, padahal menu lain harganya cenderung affordable hehe.', '2024-06-07 09:32:30', 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`, `is_admin`) VALUES
(33, 'rikoairlan', 'Riko', 'Airlan', 'rikoairlan@gmail.com', '08990761528', 'a15f31d3578991b0d7734fc6179068e5', 'jl.blok duku', 1, '2022-04-08 08:35:14', 0),
(36, 'test1', 'riko', 'airlan', 'rikoairlan1111@gmail.com', '08990761525', 'a15f31d3578991b0d7734fc6179068e5', 'jl.blok duku\r\nrt004 rw 010', 1, '2022-06-14 04:17:26', 0),
(37, 'admin123', 'admin', '123', 'admin123@gmail.com', '09837373783838', '0192023a7bbd73250516f069df18b500', 'qweqwdqsdasd', 1, '2024-06-05 08:38:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`) VALUES
(61, 37, 'Ayam Bakar', 1, 25000.00, 'closed', '2024-06-07 09:35:10'),
(62, 37, 'Ayam Bakar', 13, 25000.00, 'closed', '2024-06-07 09:35:31'),
(63, 37, 'Ayam Bakar', 13, 25000.00, NULL, '2024-06-07 06:17:40'),
(64, 37, 'Ayam Bakar', 13, 25000.00, NULL, '2024-06-07 06:18:22'),
(65, 37, 'Ikan Bakar', 13, 20000.00, NULL, '2024-06-07 06:18:49'),
(66, 37, 'Ikan Bakar', 13, 20000.00, NULL, '2024-06-07 09:34:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `admin_codes`
--
ALTER TABLE `admin_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_dishes` (`dish_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_dishes` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`d_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

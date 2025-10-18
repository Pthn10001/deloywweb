-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2021 at 04:44 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elaravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_05_085614_create_tbl_admin_table', 1),
(6, '2021_09_10_140306_create_tbl_category_product', 2),
(7, '2021_09_10_143211_create_tbl_category_product', 3),
(8, '2021_09_18_124808_create_tbl_brand_product', 4),
(9, '2021_09_18_125549_create_tbl_brand_product', 5),
(10, '2021_09_19_140924_create_tbl_product', 6),
(11, '2021_10_17_155637_tbl_customer', 7),
(13, '2021_10_18_022544_tbl_shipping', 8),
(14, '2021_10_21_135556_tbl_payment', 8),
(15, '2021_10_21_135819_tbl_order', 8),
(16, '2021_10_21_140803_tbl_details_id', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `admin_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_email`, `admin_password`, `admin_name`, `admin_phone`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$A7CeYPwtjZFV2BtbzDv86uc1Ex86JllohWCYzR/1ESEPGQj1tb8Ie', 'Dũng Anh', '0997654329', '2021-09-21 09:25:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand_product`
--

CREATE TABLE `tbl_brand_product` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `brand_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keyword` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_brand_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_brand_product`
--

INSERT INTO `tbl_brand_product` (`brand_id`, `brand_name`, `meta_keyword`, `slug_brand_product`, `brand_desc`, `brand_status`, `created_at`, `updated_at`) VALUES
(14, 'Adidas', 'adidas', 'adidas', '<p>Thương hiệu adidas</p>', 1, NULL, NULL),
(15, 'Homere', 'homere', 'homere', '<p>Thương hiệu Homere&nbsp;</p>', 0, NULL, NULL),
(16, 'Blabla', 'blabla', 'blabla', '<p>blabla</p>', 0, NULL, NULL),
(17, 'NIKE', 'nike', 'Giày nike', '<p>nike</p>', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_product`
--

CREATE TABLE `tbl_category_product` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keyword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_category_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_category_product`
--

INSERT INTO `tbl_category_product` (`category_id`, `category_name`, `category_desc`, `meta_keyword`, `slug_category_product`, `category_status`, `created_at`, `updated_at`) VALUES
(36, 'ĐỒ NAM', '<p>Quần &aacute;o nam cao cấp</p>', 'ao thun cao cap', 'aothun', 0, NULL, NULL),
(37, 'ĐỒ NỮ', '<p>Quần &aacute;o nữ cao cấp</p>', 'ao khoac', 'aokhoac', 0, NULL, NULL),
(38, 'ĐỒ ĐÔI', '<p>Quần &aacute;o đ&ocirc;i cao cấp</p>', 'quan jean nam', 'quanjean', 0, NULL, NULL),
(39, 'ÁO KHOÁC', '<p>&Aacute;o kho&aacute;c cao cấp</p>', 'quanshort', 'quanshort', 0, NULL, NULL),
(40, 'GIÀY THỂ THAO', '<p>Gi&agrave;y thể thao</p>', 'áo sơ mi', 'aosomi', 0, NULL, NULL),
(41, 'PHỤ KIỆN', '<p>Phụ kiện</p>', 'Váy xinh', 'vayxinh', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_name`, `customer_email`, `customer_password`, `customer_phone`) VALUES
(14, 'user', 'user@gmail.com', '$2y$10$3peNSz1D8idKfA.R3lGxguAlfpzjOKSBcjGOgL0NgTlSGOWdGcvSC', '0123456789'),
(15, 'mdung', 'mrdung@gmail.com', '$2y$10$a6z6JmfZjaSUFJL2aabhH.bUJnti25vKMj.wEs1OejzeBIl3ZdHLi', '0965546526'),
(16, 'vantinh', 'vantinh@gmail.com', '$2y$10$2/TiNp2b4VR2yb9e/2lU0.ZYOwCNLx.rbiyA7hIbK1u26BqiELAr.', '0965546526');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_details_id`
--

CREATE TABLE `tbl_details_id` (
  `order_detail_id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` double(8,2) NOT NULL,
  `product_sales_qty` int(11) NOT NULL,
  `product_size` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_details_id`
--

INSERT INTO `tbl_details_id` (`order_detail_id`, `order_code`, `product_id`, `product_name`, `product_price`, `product_sales_qty`, `product_size`) VALUES
(51, '72257', 67, 'Áo thun Kpp9', 319000.00, 3, 'M'),
(52, '72257', 66, 'Áo thun Kyn1', 390000.00, 3, 'L'),
(53, '72257', 63, 'Váy ngắn', 499000.00, 1, 'S'),
(60, '90e4a', 65, 'Áo thun nam', 299000.00, 2, 'M'),
(61, '90e4a', 63, 'Váy ngắn', 499000.00, 1, 'M'),
(62, '90e4a', 59, 'Áo thun nữ W1AT', 399000.00, 1, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipping_id` int(11) NOT NULL,
  `order_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `customer_id`, `shipping_id`, `order_code`, `order_status`, `created_at`) VALUES
(79, 15, 66, '72257', '2', '2021-11-07 08:31:24'),
(100, 15, 87, '90e4a', '1', '2021-11-15 02:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_status` int(11) NOT NULL,
  `product_quantity` int(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `category_id`, `brand_id`, `product_desc`, `product_content`, `product_price`, `product_image`, `product_status`, `product_quantity`, `created_at`, `updated_at`) VALUES
(46, 'Giày Nike', 40, 17, 'giay nike', 'giay nike', '1699000', 'giay3.jpg', 0, 10, NULL, NULL),
(47, 'Giày Nike T1', 40, 17, 'Giày Nike T1', 'Giày Nike T1', '1549000', 'giay1.jpg', 0, 20, NULL, NULL),
(48, 'Giày Nike F1', 40, 17, 'Giày Nike F1', 'Giày Nike F1 đẹp', '2399000', 'giay.jpg', 0, 11, NULL, NULL),
(49, 'Túi xách adidas', 41, 14, 'Túi xách adidas', 'Túi xách adidas', '899000', 'phukien2.jpg', 0, 21, NULL, NULL),
(50, 'Túi xách adidas V1', 41, 14, 'Túi xách adidas V1', 'Túi xách adidas V1', '999000', 'phukien1.jpg', 0, 12, NULL, NULL),
(51, 'Túi xách adidas SS1', 41, 14, 'Túi xách adidas SS1', 'Túi xách adidas SS1', '1390000', 'phukien.jpg', 0, 6, NULL, NULL),
(52, 'Mũ tf blue', 41, 16, 'Mũ tf blue', 'Mũ tf blue', '230000', 'phukien4.jpg', 0, 9, NULL, NULL),
(53, 'Áo khoác U1AKU1031001', 39, 15, 'Áo khoác', 'Áo khoác', '585000', 'product8.jpg', 0, 13, NULL, NULL),
(54, 'Áo khoác W1AKD4061002', 39, 15, 'Áo khoác', 'Áo khoác', '999000', 'aokhoac3.jpg', 0, 17, NULL, NULL),
(55, 'Áo khoác U1AKD4061002', 39, 15, 'Áo khoác', 'Áo khoác', '799000', 'aokhoac2.jpg', 0, 18, NULL, NULL),
(56, 'Áo thun D1ATN2051002', 38, 15, 'đồ đôi', 'đồ đôi', '690000', 'dodoi1.jpg', 0, 20, NULL, NULL),
(57, 'Áo thun 1ATN2051001', 38, 15, 'đồ đôi', 'đồ đôi', '650000', 'dodoi3.jpg', 0, 22, NULL, NULL),
(58, 'Áo khoác U1AKD4061092', 38, 15, 'Áo khoác đôi', 'Áo khoác đôi', '1480000', 'dodoi.jpg', 0, 9, NULL, NULL),
(59, 'Áo thun nữ W1AT', 37, 16, 'Áo thun nữ', 'Áo thun nữ', '399000', 'donu.jpg', 0, 16, NULL, NULL),
(60, 'Quần jean nữ HH1AT', 37, 16, 'Áo thun nữ', 'Áo thun nữ', '299000', 'donu1.jpg', 0, 3, NULL, NULL),
(61, 'Áo thun nữ Khk1', 37, 16, 'Áo thun nữ', 'Áo thun nữ', '359000', 'donu4.jpg', 0, 9, NULL, NULL),
(62, 'Váy xinh', 37, 16, 'Váy xinh', 'Váy xinh', '299000', 'donu3.jpg', 0, 10, NULL, NULL),
(63, 'Váy ngắn', 37, 16, 'Váy ngắn', 'Váy ngắn', '499000', 'productone.jpg', 0, 9, NULL, NULL),
(64, 'Áo sơ mi nam', 36, 15, 'Áo sơ mi nam', 'Áo sơ mi nam', '399000', 'aosomi1.jpg', 0, 19, NULL, NULL),
(65, 'Áo thun nam', 36, 15, 'Áo thun nam', 'Áo thun nam', '299000', 'aothun1.jpg', 0, 31, NULL, NULL),
(66, 'Áo thun Kyn1', 36, 15, 'Áo thun Kyn1', 'Áo thun Kyn1', '390000', 'aothun2.jpg', 0, 4, NULL, NULL),
(67, 'Áo thun Kpp9', 36, 15, 'Áo thun Kpp9', 'Áo thun Kpp9', '319000', 'aothun3.jpg', 0, 18, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping`
--

CREATE TABLE `tbl_shipping` (
  `shipping_id` int(10) UNSIGNED NOT NULL,
  `payment_method` int(10) NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` int(11) NOT NULL,
  `shipping_notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_shipping`
--

INSERT INTO `tbl_shipping` (`shipping_id`, `payment_method`, `shipping_name`, `shipping_email`, `shipping_address`, `shipping_phone`, `shipping_notes`) VALUES
(64, 2, 'Trần Anh Dũng', 'mrdung@gmail.com', 'kyanh-hatinh', 965546526, 'bla'),
(65, 2, 'Trần Anh Dũng', 'mrdung@gmail.com', '13 Kỳ anh Hà Tĩnh', 965546526, 'ghi chú'),
(66, 1, 'Trần Anh Dũng', 'user@gmail.com', 'kyanh-hatinh', 123456789, 'bla'),
(87, 2, 'Trần Anh Dũng', 'mrdung@gmail.com', 'kyanh-hatinh', 965546526, 'bug');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_brand_product`
--
ALTER TABLE `tbl_brand_product`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_details_id`
--
ALTER TABLE `tbl_details_id`
  ADD PRIMARY KEY (`order_detail_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_brand_product`
--
ALTER TABLE `tbl_brand_product`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_details_id`
--
ALTER TABLE `tbl_details_id`
  MODIFY `order_detail_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  MODIFY `shipping_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

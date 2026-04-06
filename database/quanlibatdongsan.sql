-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2026 at 07:56 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlibatdongsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `batdongsan`
--

DROP TABLE IF EXISTS `batdongsan`;
CREATE TABLE IF NOT EXISTS `batdongsan` (
  `bdsid` int NOT NULL,
  `loaiid` int DEFAULT NULL,
  `khid` int DEFAULT NULL,
  `tinhtrang` int DEFAULT NULL,
  `dientich` float DEFAULT NULL,
  `dongia` float DEFAULT NULL,
  `chieudai` float DEFAULT NULL,
  `chieurong` float DEFAULT NULL,
  `masoqsdd` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hinhanh` longblob,
  `mota` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `huehong` float DEFAULT NULL,
  `tenduong` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sonha` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phuong` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thanhpho` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`bdsid`),
  KEY `loaiid` (`loaiid`),
  KEY `khid` (`khid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinhbds`
--

DROP TABLE IF EXISTS `hinhbds`;
CREATE TABLE IF NOT EXISTS `hinhbds` (
  `hinhid` int NOT NULL,
  `hinh` longblob,
  `bdsid` int DEFAULT NULL,
  PRIMARY KEY (`hinhid`),
  KEY `bdsid` (`bdsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hopdongchuyennhuong`
--

DROP TABLE IF EXISTS `hopdongchuyennhuong`;
CREATE TABLE IF NOT EXISTS `hopdongchuyennhuong` (
  `cnid` int NOT NULL,
  `khid` int DEFAULT NULL,
  `bdsid` int DEFAULT NULL,
  `dcid` int DEFAULT NULL,
  `giatri` float DEFAULT NULL,
  `ngaylap` date DEFAULT NULL,
  `trangthai` bit(1) DEFAULT NULL,
  PRIMARY KEY (`cnid`),
  KEY `khid` (`khid`),
  KEY `bdsid` (`bdsid`),
  KEY `dcid` (`dcid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hopdongdatcoc`
--

DROP TABLE IF EXISTS `hopdongdatcoc`;
CREATE TABLE IF NOT EXISTS `hopdongdatcoc` (
  `dcid` int NOT NULL,
  `khid` int DEFAULT NULL,
  `bdsid` int DEFAULT NULL,
  `ngaylap` date DEFAULT NULL,
  `ngayhethan` date DEFAULT NULL,
  `trangthai` bit(1) DEFAULT NULL,
  `giatri` float DEFAULT NULL,
  `tinhtrang` int DEFAULT NULL,
  PRIMARY KEY (`dcid`),
  KEY `khid` (`khid`),
  KEY `bdsid` (`bdsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hopdongkygui`
--

DROP TABLE IF EXISTS `hopdongkygui`;
CREATE TABLE IF NOT EXISTS `hopdongkygui` (
  `kgid` int NOT NULL,
  `khid` int DEFAULT NULL,
  `bdsid` int DEFAULT NULL,
  `giatri` float DEFAULT NULL,
  `chiphidv` float DEFAULT NULL,
  `ngaybd` date DEFAULT NULL,
  `ngayketthuc` date DEFAULT NULL,
  `trangthai` bit(1) DEFAULT NULL,
  PRIMARY KEY (`kgid`),
  KEY `khid` (`khid`),
  KEY `bdsid` (`bdsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `khid` int NOT NULL,
  `nvid` int DEFAULT NULL,
  `hoten` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `diachi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diachitt` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cmnd` int DEFAULT NULL,
  `ngaysinh` datetime DEFAULT NULL,
  `sodienthoai` int DEFAULT NULL,
  `gioitinh` tinyint(1) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `loaikh` bit(1) DEFAULT NULL,
  `mota` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trangthai` bit(1) DEFAULT NULL,
  PRIMARY KEY (`khid`),
  UNIQUE KEY `cmnd` (`cmnd`),
  KEY `nvid` (`nvid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loaibds`
--

DROP TABLE IF EXISTS `loaibds`;
CREATE TABLE IF NOT EXISTS `loaibds` (
  `loaiid` int NOT NULL,
  `tenloai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`loaiid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `nvid` int NOT NULL,
  `taikhoan` char(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `matkhau` char(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tennv` char(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sdt` int DEFAULT NULL,
  `diachi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `gioitinh` tinyint(1) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doanhthu` float DEFAULT '0',
  `quyen` bit(1) DEFAULT NULL,
  `trangthai` bit(1) DEFAULT NULL,
  PRIMARY KEY (`nvid`),
  UNIQUE KEY `taikhoan` (`taikhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`nvid`, `taikhoan`, `matkhau`, `tennv`, `sdt`, `diachi`, `ngaysinh`, `gioitinh`, `email`, `doanhthu`, `quyen`, `trangthai`) VALUES
(1, 'admin', 'admin', 'admin', 0, NULL, NULL, 1, NULL, 0, b'0', b'1'),
(2, 'nhut', '123', 'nhut', 248554387, NULL, NULL, 1, NULL, 0, b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `yeucaukhachhang`
--

DROP TABLE IF EXISTS `yeucaukhachhang`;
CREATE TABLE IF NOT EXISTS `yeucaukhachhang` (
  `ycid` int NOT NULL,
  `loaiid` int DEFAULT NULL,
  `khid` int DEFAULT NULL,
  `dientich` float DEFAULT NULL,
  `vitri` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mota` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `giat` float DEFAULT NULL,
  `giaf` float DEFAULT NULL,
  `dait` float DEFAULT NULL,
  `daif` float DEFAULT NULL,
  `rongt` float DEFAULT NULL,
  `rongf` float DEFAULT NULL,
  PRIMARY KEY (`ycid`),
  KEY `loaiid` (`loaiid`),
  KEY `khid` (`khid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batdongsan`
--
ALTER TABLE `batdongsan`
  ADD CONSTRAINT `batdongsan_ibfk_1` FOREIGN KEY (`loaiid`) REFERENCES `loaibds` (`loaiid`),
  ADD CONSTRAINT `batdongsan_ibfk_2` FOREIGN KEY (`khid`) REFERENCES `khachhang` (`khid`);

--
-- Constraints for table `hinhbds`
--
ALTER TABLE `hinhbds`
  ADD CONSTRAINT `hinhbds_ibfk_1` FOREIGN KEY (`bdsid`) REFERENCES `batdongsan` (`bdsid`);

--
-- Constraints for table `hopdongchuyennhuong`
--
ALTER TABLE `hopdongchuyennhuong`
  ADD CONSTRAINT `hopdongchuyennhuong_ibfk_1` FOREIGN KEY (`khid`) REFERENCES `khachhang` (`khid`),
  ADD CONSTRAINT `hopdongchuyennhuong_ibfk_2` FOREIGN KEY (`bdsid`) REFERENCES `batdongsan` (`bdsid`),
  ADD CONSTRAINT `hopdongchuyennhuong_ibfk_3` FOREIGN KEY (`dcid`) REFERENCES `hopdongdatcoc` (`dcid`);

--
-- Constraints for table `hopdongdatcoc`
--
ALTER TABLE `hopdongdatcoc`
  ADD CONSTRAINT `hopdongdatcoc_ibfk_1` FOREIGN KEY (`khid`) REFERENCES `khachhang` (`khid`),
  ADD CONSTRAINT `hopdongdatcoc_ibfk_2` FOREIGN KEY (`bdsid`) REFERENCES `batdongsan` (`bdsid`);

--
-- Constraints for table `hopdongkygui`
--
ALTER TABLE `hopdongkygui`
  ADD CONSTRAINT `hopdongkygui_ibfk_1` FOREIGN KEY (`khid`) REFERENCES `khachhang` (`khid`),
  ADD CONSTRAINT `hopdongkygui_ibfk_2` FOREIGN KEY (`bdsid`) REFERENCES `batdongsan` (`bdsid`);

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`nvid`) REFERENCES `nhanvien` (`nvid`);

--
-- Constraints for table `yeucaukhachhang`
--
ALTER TABLE `yeucaukhachhang`
  ADD CONSTRAINT `yeucaukhachhang_ibfk_1` FOREIGN KEY (`loaiid`) REFERENCES `loaibds` (`loaiid`),
  ADD CONSTRAINT `yeucaukhachhang_ibfk_2` FOREIGN KEY (`khid`) REFERENCES `khachhang` (`khid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

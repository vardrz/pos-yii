-- Adminer 4.8.1 MySQL 10.6.7-MariaDB-2ubuntu1.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) NOT NULL,
  `harga_satuan` double NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`barang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `barang` (`barang_id`, `nama_barang`, `harga_satuan`, `stok`) VALUES
(1,	'Laptop Acer Swift 3 Sf313-51 4/256 SSD',	8499000,	3),
(2,	'Laptop Lenovo IdeaPad Slim 3 14ADA05 4/256 SSD',	4599000,	4),
(3,	'Laptop Lenovo IdeaPad Slim 3 14ADA05 8/256 SSD',	5199000,	3),
(4,	'Laptop Lenovo Yoga 6 13ALC6 BEID 16/512 SSD',	14799000,	4),
(5,	'Laptop ACER Aspire 3 Slim A314-22-R430 4/256 SSD',	4499000,	3),
(6,	'RAM IMPERION DDR4 4GB 2666MHz PC21300 LONGDIMM',	219000,	12),
(7,	'RAM Samsung DDR4 4GB PC2666 SODIMM',	374000,	8),
(8,	'SSD ADATA SU650 120GB - SSD SATA 3',	266000,	20),
(9,	'SSD ADATA SU650 240GB - SSD SATA 3',	410000,	29),
(10,	'SSD ADATA SU650 512GB - SSD SATA 3',	870000,	19);

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan` (
  `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  PRIMARY KEY (`pelanggan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pelanggan` (`pelanggan_id`, `nama_pelanggan`, `alamat`, `nomor_hp`) VALUES
(1,	'Bill Gates',	'New York',	'123456'),
(2,	'Elon Musk',	'Texas',	'1234567'),
(3,	'Umum',	'Umum',	'123');

DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan` (
  `nomor_nota` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`nomor_nota`),
  KEY `pelanggan_id` (`pelanggan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `penjualan_ibfk_3` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`pelanggan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `penjualan` (`nomor_nota`, `tanggal`, `pelanggan_id`, `total`, `user_id`) VALUES
('1662272472',	'2022-09-04',	3,	15669000,	1);

DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail` (
  `penjualan_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_nota` varchar(100) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` double NOT NULL,
  `jumlah` double NOT NULL,
  `subtotal` double NOT NULL,
  PRIMARY KEY (`penjualan_detail_id`),
  KEY `nomor_nota` (`nomor_nota`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `penjualan_detail_ibfk_3` FOREIGN KEY (`nomor_nota`) REFERENCES `penjualan` (`nomor_nota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_detail_ibfk_4` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `penjualan_detail` (`penjualan_detail_id`, `nomor_nota`, `barang_id`, `harga`, `jumlah`, `subtotal`) VALUES
(1,	'1662272472',	4,	14799000,	1,	14799000),
(2,	'1662272472',	10,	870000,	1,	870000);

DELIMITER ;;

CREATE TRIGGER `penjualan_detail_ai` AFTER INSERT ON `penjualan_detail` FOR EACH ROW
begin
update barang set stok=stok-new.jumlah where barang_id=new.barang_id;
update penjualan set total=total+new.subtotal where nomor_nota=new.nomor_nota;
end;;

CREATE TRIGGER `penjualan_detail_ad` AFTER DELETE ON `penjualan_detail` FOR EACH ROW
begin
update barang set stok=stok+old.jumlah where barang_id=old.barang_id;
update penjualan set total=total-old.subtotal where nomor_nota=old.nomor_nota;
end;;

DELIMITER ;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `auth_key` varchar(100) NOT NULL,
  `access_token` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`user_id`, `username`, `password`, `auth_key`, `access_token`) VALUES
(1,	'admin',	'21232f297a57a5a743894a0e4a801fc3',	'123',	'123');

-- 2022-09-04 06:36:11
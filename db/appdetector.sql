-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for appdetector
CREATE DATABASE IF NOT EXISTS `appdetector` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `appdetector`;

-- Dumping structure for table appdetector.detection_logs
CREATE TABLE IF NOT EXISTS `detection_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mac_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detected_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.detection_logs: ~120 rows (approximately)
REPLACE INTO `detection_logs` (`id`, `pc_name`, `user_name`, `app_name`, `ip_address`, `mac_address`, `path`, `source`, `detected_at`, `created_at`, `updated_at`) VALUES
	(1, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$R5KPRAF\\www\\Web-Starter-Template-master\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:09', '2025-07-03 02:22:10', '2025-07-03 02:22:10'),
	(2, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RE0TS6N\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:10', '2025-07-03 02:22:10', '2025-07-03 02:22:10'),
	(3, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RE0TS6N\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:10', '2025-07-03 02:22:10', '2025-07-03 02:22:10'),
	(4, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RE0TS6N\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:10', '2025-07-03 02:22:10', '2025-07-03 02:22:10'),
	(5, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RE0TS6N\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:11', '2025-07-03 02:22:11'),
	(6, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RV84HF2\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:11', '2025-07-03 02:22:11'),
	(7, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RV84HF2\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:11', '2025-07-03 02:22:11'),
	(8, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RV84HF2\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:11', '2025-07-03 02:22:11'),
	(9, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RV84HF2\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:11', '2025-07-03 02:22:11'),
	(10, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RZU6M11\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:11', '2025-07-03 02:22:12', '2025-07-03 02:22:12'),
	(11, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RZU6M11\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:12', '2025-07-03 02:22:12', '2025-07-03 02:22:12'),
	(12, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RZU6M11\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:12', '2025-07-03 02:22:12', '2025-07-03 02:22:12'),
	(13, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\$Recycle.Bin\\S-1-5-21-2730341512-2851221768-2521805584-1003\\$RZU6M11\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:12', '2025-07-03 02:22:12', '2025-07-03 02:22:12'),
	(14, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:12', '2025-07-03 02:22:12', '2025-07-03 02:22:12'),
	(15, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:12', '2025-07-03 02:22:13', '2025-07-03 02:22:13'),
	(16, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:13', '2025-07-03 02:22:13', '2025-07-03 02:22:13'),
	(17, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:13', '2025-07-03 02:22:13', '2025-07-03 02:22:13'),
	(18, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence-request\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:13', '2025-07-03 02:22:13', '2025-07-03 02:22:13'),
	(19, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence-request\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:13', '2025-07-03 02:22:13', '2025-07-03 02:22:13'),
	(20, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\folder old rico\\data xampp rico\\xampp\\htdocs\\absence-request\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:13', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(21, 'ITSA-RN-0005', 'Barbatos', 'apr_portable.h', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\bin\\apache\\httpd-2.4.35-win64-VC15\\include\\apr_portable.h', 'File Scan', '2025-07-03 09:22:14', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(22, 'ITSA-RN-0005', 'Barbatos', 'Portable.txt', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\bin\\cmder\\vendor\\conemu-maximus5\\ConEmu\\Portable.txt', 'File Scan', '2025-07-03 09:22:14', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(23, 'ITSA-RN-0005', 'Barbatos', 'README.portable', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\bin\\git\\README.portable', 'File Scan', '2025-07-03 09:22:14', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(24, 'ITSA-RN-0005', 'Barbatos', 'portable.lock', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\bin\\heidisql\\portable.lock', 'File Scan', '2025-07-03 09:22:14', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(25, 'ITSA-RN-0005', 'Barbatos', 'portable_settings.txt', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\bin\\heidisql\\portable_settings.txt', 'File Scan', '2025-07-03 09:22:14', '2025-07-03 02:22:14', '2025-07-03 02:22:14'),
	(26, 'ITSA-RN-0005', 'Barbatos', 'auto.System-Detection-Software-Crack-and-Unlicense.test.conf', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\etc\\apache2\\sites-enabled\\auto.System-Detection-Software-Crack-and-Unlicense.test.conf', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:15', '2025-07-03 02:22:15'),
	(27, 'ITSA-RN-0005', 'Barbatos', 'System-Detection-Software-Crack-and-Unlicense', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\System-Detection-Software-Crack-and-Unlicense', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:15', '2025-07-03 02:22:15'),
	(28, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\app-itreqbor\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:15', '2025-07-03 02:22:15'),
	(29, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\app-itreqbor\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:15', '2025-07-03 02:22:15'),
	(30, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\app-itreqbor\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:15', '2025-07-03 02:22:15'),
	(31, 'ITSA-RN-0005', 'Barbatos', 'ReportablePrinter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\app-itreqbor\\vendor\\nunomaduro\\collision\\src\\Adapters\\Phpunit\\Printers\\ReportablePrinter.php', 'File Scan', '2025-07-03 09:22:15', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(32, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\app-itreqbor\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(33, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\appsBorrowIt\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(34, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\appsBorrowIt\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(35, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\appsBorrowIt\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(36, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\appsBorrowIt\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:16', '2025-07-03 02:22:16'),
	(37, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\backendAppTrains\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:16', '2025-07-03 02:22:17', '2025-07-03 02:22:17'),
	(38, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\backendAppTrains\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:17', '2025-07-03 02:22:17', '2025-07-03 02:22:17'),
	(39, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\backendAppTrains\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:17', '2025-07-03 02:22:17', '2025-07-03 02:22:17'),
	(40, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\backendAppTrains\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:17', '2025-07-03 02:22:17', '2025-07-03 02:22:17'),
	(41, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:17', '2025-07-03 02:22:17', '2025-07-03 02:22:17'),
	(42, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:17', '2025-07-03 02:22:18', '2025-07-03 02:22:18'),
	(43, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\AsyncAwsS3\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:18', '2025-07-03 02:22:18', '2025-07-03 02:22:18'),
	(44, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\AwsS3V3\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:18', '2025-07-03 02:22:18', '2025-07-03 02:22:18'),
	(45, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\GoogleCloudStorage\\PortableVisibilityHandler.php', 'File Scan', '2025-07-03 09:22:18', '2025-07-03 02:22:18', '2025-07-03 02:22:18'),
	(46, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:18', '2025-07-03 02:22:18', '2025-07-03 02:22:18'),
	(47, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverterTest.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverterTest.php', 'File Scan', '2025-07-03 09:22:18', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(48, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\digital-assets\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:19', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(49, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\itborrow-request\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:19', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(50, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\itborrow-request\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:19', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(51, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\itborrow-request\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:19', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(52, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\itborrow-request\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:19', '2025-07-03 02:22:19', '2025-07-03 02:22:19'),
	(53, 'ITSA-RN-0005', 'Barbatos', 'ReportableHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Exceptions\\ReportableHandler.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:20', '2025-07-03 02:22:20'),
	(54, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityGuard.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\PortableVisibilityGuard.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:20', '2025-07-03 02:22:20'),
	(55, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\AsyncAwsS3\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:20', '2025-07-03 02:22:20'),
	(56, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\AwsS3V3\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:20', '2025-07-03 02:22:20'),
	(57, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityHandler.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\GoogleCloudStorage\\PortableVisibilityHandler.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:20', '2025-07-03 02:22:20'),
	(58, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverter.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverter.php', 'File Scan', '2025-07-03 09:22:20', '2025-07-03 02:22:21', '2025-07-03 02:22:21'),
	(59, 'ITSA-RN-0005', 'Barbatos', 'PortableVisibilityConverterTest.php', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\league\\flysystem\\src\\UnixVisibility\\PortableVisibilityConverterTest.php', 'File Scan', '2025-07-03 09:22:21', '2025-07-03 02:22:21', '2025-07-03 02:22:21'),
	(60, 'ITSA-RN-0005', 'Barbatos', 'portable-ascii', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\laragon\\www\\portal-itsa\\vendor\\voku\\portable-ascii', 'File Scan', '2025-07-03 09:22:21', '2025-07-03 02:22:21', '2025-07-03 02:22:21'),
	(61, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', 'File Scan', '2025-07-03 09:23:09', '2025-07-03 02:23:10', '2025-07-03 02:23:10'),
	(62, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', 'File Scan', '2025-07-03 09:23:10', '2025-07-03 02:23:10', '2025-07-03 02:23:10'),
	(63, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', 'File Scan', '2025-07-03 09:23:10', '2025-07-03 02:23:10', '2025-07-03 02:23:10'),
	(64, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:10', '2025-07-03 02:23:10', '2025-07-03 02:23:10'),
	(65, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:10', '2025-07-03 02:23:10', '2025-07-03 02:23:10'),
	(66, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', 'File Scan', '2025-07-03 09:23:10', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(67, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', 'File Scan', '2025-07-03 09:23:11', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(68, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-Portable-Devices-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', 'File Scan', '2025-07-03 09:23:11', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(69, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:11', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(70, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:11', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(71, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', 'File Scan', '2025-07-03 09:23:11', '2025-07-03 02:23:11', '2025-07-03 02:23:11'),
	(72, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:12', '2025-07-03 02:23:12'),
	(73, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:12', '2025-07-03 02:23:12'),
	(74, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~en-GB~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:12', '2025-07-03 02:23:12'),
	(75, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~en-US~10.0.26100.1.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:12', '2025-07-03 02:23:12'),
	(76, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.1301.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:12', '2025-07-03 02:23:12'),
	(77, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4202.cat', 'File Scan', '2025-07-03 09:23:12', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(78, 'ITSA-RN-0005', 'Barbatos', 'Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\catroot\\{F750E6C3-38EE-11D1-85E5-00C04FC295EE}\\Microsoft-Windows-WPD-UltimatePortableDeviceFeature-Feature-WOW64-Package~31bf3856ad364e35~amd64~~10.0.26100.4484.cat', 'File Scan', '2025-07-03 09:23:13', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(79, 'ITSA-RN-0005', 'Barbatos', 'portabledevicestatus.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\en-GB\\portabledevicestatus.dll.mui', 'File Scan', '2025-07-03 09:23:13', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(80, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceSyncProvider.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\en-GB\\PortableDeviceSyncProvider.dll.mui', 'File Scan', '2025-07-03 09:23:13', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(81, 'ITSA-RN-0005', 'Barbatos', 'portabledevicestatus.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\en-US\\portabledevicestatus.dll.mui', 'File Scan', '2025-07-03 09:23:13', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(82, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceSyncProvider.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\en-US\\PortableDeviceSyncProvider.dll.mui', 'File Scan', '2025-07-03 09:23:13', '2025-07-03 02:23:13', '2025-07-03 02:23:13'),
	(83, 'ITSA-RN-0005', 'Barbatos', 'Windows Portable Devices', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\LogFiles\\Windows Portable Devices', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:14', '2025-07-03 02:23:14'),
	(84, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceapi.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\wbem\\portabledeviceapi.mof', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:14', '2025-07-03 02:23:14'),
	(85, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceclassextension.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\wbem\\portabledeviceclassextension.mof', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:14', '2025-07-03 02:23:14'),
	(86, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceconnectapi.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\wbem\\portabledeviceconnectapi.mof', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:14', '2025-07-03 02:23:14'),
	(87, 'ITSA-RN-0005', 'Barbatos', 'portabledevicetypes.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\wbem\\portabledevicetypes.mof', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:14', '2025-07-03 02:23:14'),
	(88, 'ITSA-RN-0005', 'Barbatos', 'portabledevicewiacompat.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\System32\\wbem\\portabledevicewiacompat.mof', 'File Scan', '2025-07-03 09:23:14', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(89, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceStatus.dll.mun', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SystemResources\\PortableDeviceStatus.dll.mun', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(90, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceApi.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceApi.dll', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(91, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceClassExtension.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceClassExtension.dll', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(92, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceConnectApi.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceConnectApi.dll', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(93, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceStatus.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceStatus.dll', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:15', '2025-07-03 02:23:15'),
	(94, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceSyncProvider.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceSyncProvider.dll', 'File Scan', '2025-07-03 09:23:15', '2025-07-03 02:23:16', '2025-07-03 02:23:16'),
	(95, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceTypes.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceTypes.dll', 'File Scan', '2025-07-03 09:23:16', '2025-07-03 02:23:16', '2025-07-03 02:23:16'),
	(96, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceWiaCompat.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\PortableDeviceWiaCompat.dll', 'File Scan', '2025-07-03 09:23:16', '2025-07-03 02:23:16', '2025-07-03 02:23:16'),
	(97, 'ITSA-RN-0005', 'Barbatos', 'Windows.Devices.Portable.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\Windows.Devices.Portable.dll', 'File Scan', '2025-07-03 09:23:16', '2025-07-03 02:23:16', '2025-07-03 02:23:16'),
	(98, 'ITSA-RN-0005', 'Barbatos', 'portabledevicestatus.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\en-GB\\portabledevicestatus.dll.mui', 'File Scan', '2025-07-03 09:23:16', '2025-07-03 02:23:16', '2025-07-03 02:23:16'),
	(99, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceSyncProvider.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\en-GB\\PortableDeviceSyncProvider.dll.mui', 'File Scan', '2025-07-03 09:23:16', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(100, 'ITSA-RN-0005', 'Barbatos', 'portabledevicestatus.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\en-US\\portabledevicestatus.dll.mui', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(101, 'ITSA-RN-0005', 'Barbatos', 'PortableDeviceSyncProvider.dll.mui', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\en-US\\PortableDeviceSyncProvider.dll.mui', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(102, 'ITSA-RN-0005', 'Barbatos', 'Windows Portable Devices', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\LogFiles\\Windows Portable Devices', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(103, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceapi.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\wbem\\portabledeviceapi.mof', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(104, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceclassextension.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\wbem\\portabledeviceclassextension.mof', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:17', '2025-07-03 02:23:17'),
	(105, 'ITSA-RN-0005', 'Barbatos', 'portabledeviceconnectapi.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\wbem\\portabledeviceconnectapi.mof', 'File Scan', '2025-07-03 09:23:17', '2025-07-03 02:23:18', '2025-07-03 02:23:18'),
	(106, 'ITSA-RN-0005', 'Barbatos', 'portabledevicetypes.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\wbem\\portabledevicetypes.mof', 'File Scan', '2025-07-03 09:23:18', '2025-07-03 02:23:18', '2025-07-03 02:23:18'),
	(107, 'ITSA-RN-0005', 'Barbatos', 'portabledevicewiacompat.mof', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\SysWOW64\\wbem\\portabledevicewiacompat.mof', 'File Scan', '2025-07-03 09:23:18', '2025-07-03 02:23:18', '2025-07-03 02:23:18'),
	(108, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1150_none_5677fa35d46ef99a', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1150_none_5677fa35d46ef99a', 'File Scan', '2025-07-03 09:23:18', '2025-07-03 02:23:18', '2025-07-03 02:23:18'),
	(109, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_566800f9d47bc18f', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_566800f9d47bc18f', 'File Scan', '2025-07-03 09:23:18', '2025-07-03 02:23:18', '2025-07-03 02:23:18'),
	(110, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-portableworkspace-adm_31bf3856ad364e35_10.0.26100.1_none_432724cd5ef2dc5c', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portableworkspace-adm_31bf3856ad364e35_10.0.26100.1_none_432724cd5ef2dc5c', 'File Scan', '2025-07-03 09:23:18', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(111, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-portableworkspaces-sso_31bf3856ad364e35_10.0.26100.1882_none_b3fd7233aebbb250', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portableworkspaces-sso_31bf3856ad364e35_10.0.26100.1882_none_b3fd7233aebbb250', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(112, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-portableworkspaces-sso_31bf3856ad364e35_10.0.26100.1_none_1552a64367282174', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portableworkspaces-sso_31bf3856ad364e35_10.0.26100.1_none_1552a64367282174', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(113, 'ITSA-RN-0005', 'Barbatos', 'amd64_microsoft-windows-wpd-portabledeviceapi_31bf3856ad364e35_10.0.26100.1150_none_e6e816bc9bf3d8b0', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-wpd-portabledeviceapi_31bf3856ad364e35_10.0.26100.1150_none_e6e816bc9bf3d8b0', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(114, 'ITSA-RN-0005', 'Barbatos', 'wow64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1_none_c1d8fc71c1726d97', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\wow64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1_none_c1d8fc71c1726d97', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(115, 'ITSA-RN-0005', 'Barbatos', 'wow64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_60bcab4c08dc838a', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\wow64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_60bcab4c08dc838a', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:19', '2025-07-03 02:23:19'),
	(116, 'ITSA-RN-0005', 'Barbatos', 'wow64_microsoft-windows-wpd-portabledeviceapi_31bf3856ad364e35_10.0.26100.1_none_524918f888f74cad', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\wow64_microsoft-windows-wpd-portabledeviceapi_31bf3856ad364e35_10.0.26100.1_none_524918f888f74cad', 'File Scan', '2025-07-03 09:23:19', '2025-07-03 02:23:20', '2025-07-03 02:23:20'),
	(117, 'ITSA-RN-0005', 'Barbatos', 'Windows.Devices.Portable.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1150_none_5677fa35d46ef99a\\Windows.Devices.Portable.dll', 'File Scan', '2025-07-03 09:23:20', '2025-07-03 02:23:20', '2025-07-03 02:23:20'),
	(118, 'ITSA-RN-0005', 'Barbatos', 'Windows.Devices.Portable.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.1150_none_5677fa35d46ef99a\\r\\Windows.Devices.Portable.dll', 'File Scan', '2025-07-03 09:23:20', '2025-07-03 02:23:20', '2025-07-03 02:23:20'),
	(119, 'ITSA-RN-0005', 'Barbatos', 'Windows.Devices.Portable.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_566800f9d47bc18f\\Windows.Devices.Portable.dll', 'File Scan', '2025-07-03 09:23:20', '2025-07-03 02:23:20', '2025-07-03 02:23:20'),
	(120, 'ITSA-RN-0005', 'Barbatos', 'Windows.Devices.Portable.dll', '192.168.1.90', '2c:6d:c1:67:96:4d', 'C:\\Windows\\WinSxS\\amd64_microsoft-windows-portabledevices-winrt_31bf3856ad364e35_10.0.26100.4202_none_566800f9d47bc18f\\r\\Windows.Devices.Portable.dll', 'File Scan', '2025-07-03 09:23:20', '2025-07-03 02:23:20', '2025-07-03 02:23:20');

-- Dumping structure for table appdetector.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table appdetector.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.migrations: ~6 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_06_22_091057_create_detection_logs_table', 1),
	(6, '2025_06_22_140146_add_new_field_to_detection_logs_table', 2);

-- Dumping structure for table appdetector.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.password_resets: ~0 rows (approximately)

-- Dumping structure for table appdetector.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table appdetector.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table appdetector.users: ~1 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@thaisummit.co.id', NULL, '$2y$10$CgtFBeBHDbE2aJHxAYm8/O7/LOXCwS8dJgJztgNyxiH3xI3nKUXFy', NULL, '2025-06-22 23:32:42', '2025-06-22 23:32:42');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

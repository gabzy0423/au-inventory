-- AU Inventory System Database Schema
-- Target Database: au_inventory

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ---------------------------------------------------------
-- Table structure for `categories`
-- ---------------------------------------------------------
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT 'box',
  `color` varchar(20) DEFAULT 'indigo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Table structure for `assets`
-- ---------------------------------------------------------
CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL UNIQUE,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('Available','In Use','Damaged','Under Repair') DEFAULT 'Available',
  `description` text DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `deployment_date` date DEFAULT NULL,
  `last_inspected` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Table structure for `reports`
-- ---------------------------------------------------------
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Pending','Approved','Under Repair','Fixed','Resolved') DEFAULT 'Pending',
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_asset_report` (`asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Table structure for `users`
-- ---------------------------------------------------------
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Staff') NOT NULL DEFAULT 'Staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Starter Pack: Seed Data
-- ---------------------------------------------------------

-- Insert Categories
INSERT INTO `categories` (`name`, `icon`, `color`) VALUES
('Computer Hardware', 'pc-display', 'indigo'),
('Networking Devices', 'router', 'blue'),
('Peripherals', 'printer', 'purple'),
('Storage Devices', 'database', 'emerald'),
('Power Equipment', 'bolt', 'amber');

-- Insert Sample Assets
INSERT INTO `assets` (`tag`, `name`, `category_id`, `location`, `status`, `last_inspected`) VALUES
('AU-LAP-001', 'MacBook Pro M3 Max', 1, 'Comlab 1', 'Available', '2023-10-24'),
('AU-MON-045', 'Dell UltraSharp 4K', 1, 'Comlab 1', 'Damaged', '2023-11-12'),
('AU-NET-010', 'Cisco Layer 3 Switch', 2, 'Comlab 2', 'In Use', '2023-09-15'),
('AU-AUD-009', 'Yamaha Audio Mixer', 3, 'Comlab 3', 'Under Repair', '2023-12-01'),
('AU-PWR-002', 'APC Smart-UPS 1500', 5, 'Comlab 2', 'In Use', '2024-01-10');

-- ---------------------------------------------------------
-- Constraints
-- ---------------------------------------------------------
ALTER TABLE `assets` ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
ALTER TABLE `reports` ADD CONSTRAINT `fk_asset_report` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

COMMIT;

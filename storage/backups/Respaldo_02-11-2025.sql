-- Backup creado por Laravel Database Manager
-- Fecha: 2025-11-02 11:02:21

-- Estructura de la tabla `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `cash_counts`
DROP TABLE IF EXISTS `cash_counts`;
CREATE TABLE `cash_counts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `folio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `total_sales` int NOT NULL DEFAULT '0',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transfer_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `expected_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `actual_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `difference` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('completed','pending','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_session_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_counts_folio_unique` (`folio`),
  KEY `cash_counts_folio_index` (`folio`),
  KEY `cash_counts_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `cash_counts_cash_session_id_foreign` (`cash_session_id`),
  CONSTRAINT `cash_counts_cash_session_id_foreign` FOREIGN KEY (`cash_session_id`) REFERENCES `cash_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_counts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `cash_counts`
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (1, 'EBC-ARQ-2025-10-26-001', 4, '2025-10-26 00:00:00', '2025-10-26 15:57:07', 4, 1995.00, 35.00, 500.00, 0.00, 35.00, 20.00, -15.00, NULL, 'completed', '2025-10-26 15:57:07', '2025-10-26 15:57:07', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (2, 'EBC-ARQ-2025-10-26-002', 3, '2025-10-26 00:00:00', '2025-10-26 22:41:50', 2, 405.00, 35.00, 0.00, 0.00, 35.00, 500.00, 465.00, NULL, 'completed', '2025-10-26 22:41:50', '2025-10-26 22:41:50', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (3, 'EBC-ARQ-2025-10-26-003', 3, '2025-10-26 22:41:50', '2025-10-26 22:52:52', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 250.00, 250.00, NULL, 'completed', '2025-10-26 22:52:52', '2025-10-26 22:52:52', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (4, 'EBC-ARQ-2025-10-26-004', 3, '2025-10-26 22:52:52', '2025-10-26 23:01:47', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, NULL, 'completed', '2025-10-26 23:01:47', '2025-10-26 23:01:47', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (5, 'EBC-ARQ-2025-10-27-001', 3, '2025-10-27 00:55:31', '2025-10-27 00:55:31', 0, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, NULL, 'completed', '2025-10-27 00:55:31', '2025-10-27 00:55:31', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (6, 'EBC-ARQ-2025-10-27-002', 3, '2025-10-27 01:17:07', '2025-10-27 01:17:07', 3, 304.00, 65.00, 112.00, 0.00, 565.00, 563.00, -2.00, NULL, 'completed', '2025-10-27 01:17:07', '2025-10-27 01:17:07', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (7, 'EBC-ARQ-2025-10-28-001', 3, '2025-10-28 13:46:40', '2025-10-28 13:46:40', 8, 759.84, 399.96, 81.38, 0.00, 899.96, 400.00, -499.96, NULL, 'completed', '2025-10-28 13:46:40', '2025-10-28 13:46:40', NULL);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (8, 'EBC-ARQ-2025-11-01-001', 3, '2025-11-01 00:11:31', '2025-11-01 00:11:31', 3, 971.08, 140.58, 385.00, 0.00, 640.58, 700.00, 59.42, NULL, 'completed', '2025-11-01 00:11:31', '2025-11-01 00:11:31', 13);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (9, 'EBC-ARQ-2025-11-01-002', 3, '2025-11-01 00:32:37', '2025-11-01 00:32:37', 3, 942.00, 100.00, 392.00, 0.00, 600.00, 600.00, 0.00, NULL, 'completed', '2025-11-01 00:32:37', '2025-11-01 00:32:37', 14);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (10, 'EBC-ARQ-2025-11-01-003', 3, '2025-11-01 11:35:21', '2025-11-01 11:35:21', 3, 300.00, 150.00, 150.00, 0.00, 250.00, 250.00, 0.00, NULL, 'completed', '2025-11-01 11:35:21', '2025-11-01 11:35:21', 24);
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`, `cash_session_id`) VALUES (11, 'EBC-ARQ-2025-11-01-004', 3, '2025-11-01 17:40:32', '2025-11-01 17:40:32', 1, 747.50, 97.50, 650.00, 0.00, 97.50, 97.50, 0.00, NULL, 'completed', '2025-11-01 17:40:32', '2025-11-01 17:40:32', 27);

-- Estructura de la tabla `cash_cuts`
DROP TABLE IF EXISTS `cash_cuts`;
CREATE TABLE `cash_cuts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `folio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `cut_date` timestamp NOT NULL,
  `total_sales` int NOT NULL DEFAULT '0',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transfer_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `expected_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `actual_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `difference` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('open','closed','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `secret_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `closed_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_session_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_cuts_folio_unique` (`folio`),
  KEY `cash_cuts_folio_index` (`folio`),
  KEY `cash_cuts_status_index` (`status`),
  KEY `cash_cuts_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `cash_cuts_closed_by_foreign` (`closed_by`),
  KEY `cash_cuts_cash_session_id_foreign` (`cash_session_id`),
  CONSTRAINT `cash_cuts_cash_session_id_foreign` FOREIGN KEY (`cash_session_id`) REFERENCES `cash_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_cuts_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_cuts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `cash_cuts`
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (1, 'EBC-CRTE-2025-10-26-001', 4, '2025-10-26 15:58:08', 3, 905.00, 35.00, 500.00, 0.00, 35.00, 35.00, 0.00, NULL, 'closed', 'EBCFCADMIN', '2025-10-26 15:58:20', 4, '2025-10-26 15:58:08', '2025-10-26 15:58:20', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (2, 'EBC-CRTE-2025-10-26-002', 3, '2025-10-26 22:42:18', 2, 405.00, 35.00, 0.00, 0.00, 35.00, 500.00, 465.00, NULL, 'closed', 'EBCADMIN', '2025-10-26 22:42:22', 3, '2025-10-26 22:42:18', '2025-10-26 22:42:22', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (3, 'EBC-CRTE-2025-10-26-003', 3, '2025-10-26 22:53:50', 2, 405.00, 35.00, 0.00, 0.00, 35.00, 250.00, 215.00, NULL, 'closed', 'EBCADMIN', '2025-10-26 22:53:58', 3, '2025-10-26 22:53:50', '2025-10-26 22:53:58', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (4, 'EBC-CRTE-2025-10-26-004', 3, '2025-10-26 23:02:12', 2, 405.00, 35.00, 0.00, 0.00, 35.00, 500.00, 465.00, NULL, 'closed', 'EBCADMIN', '2025-10-26 23:20:26', 3, '2025-10-26 23:02:12', '2025-10-26 23:20:26', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (5, 'EBC-CRTE-2025-10-27-001', 3, '2025-10-27 00:55:48', 0, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-10-27 00:55:54', 3, '2025-10-27 00:55:48', '2025-10-27 00:55:54', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (6, 'EBC-CRTE-2025-10-27-002', 3, '2025-10-27 01:17:35', 3, 304.00, 65.00, 112.00, 0.00, 565.00, 565.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-10-27 01:17:46', 3, '2025-10-27 01:17:35', '2025-10-27 01:17:46', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (7, 'EBC-CRTE-2025-10-28-001', 3, '2025-10-28 13:13:10', 0, 0.00, 0.00, 0.00, 0.00, 500.00, 1000.00, 500.00, NULL, 'closed', 'EBCADMIN', '2025-10-28 13:13:19', 3, '2025-10-28 13:13:10', '2025-10-28 13:13:19', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (8, 'EBC-CRTE-2025-10-28-002', 3, '2025-10-28 17:30:50', 13, 1262.00, 601.92, 141.38, 0.00, 1101.92, 1110.00, 8.08, NULL, 'closed', 'EBCADMIN', '2025-10-28 17:31:04', 3, '2025-10-28 17:30:50', '2025-10-28 17:31:04', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (9, 'EBC-CRTE-2025-10-30-001', 3, '2025-10-30 20:38:03', 0, 0.00, 0.00, 0.00, 0.00, 500.00, 1500.00, 1000.00, NULL, 'closed', 'EBCADMIN', '2025-10-30 20:38:09', 3, '2025-10-30 20:38:03', '2025-10-30 20:38:09', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (10, 'EBC-CRTE-2025-11-01-001', 3, '2025-11-01 00:13:02', 3, 971.08, 140.58, 385.00, 0.00, 640.58, 640.58, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 00:13:23', 3, '2025-11-01 00:13:02', '2025-11-01 00:13:23', 13);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (11, 'EBC-CRTE-2025-11-01-002', 3, '2025-11-01 00:33:09', 3, 942.00, 100.00, 392.00, 0.00, 600.00, 600.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 00:33:17', 3, '2025-11-01 00:33:09', '2025-11-01 00:33:17', 14);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (12, 'EBC-CRTE-2025-11-01-003', 3, '2025-11-01 01:28:19', 8, 3343.83, 892.00, 1410.80, 0.00, 1192.00, 1192.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 01:28:26', 3, '2025-11-01 01:28:19', '2025-11-01 01:28:26', 15);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (13, 'EBC-CRTE-2025-11-01-004', 3, '2025-11-01 10:34:57', 2, 945.00, 0.00, 450.00, 0.00, 500.00, 500.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 10:35:05', 3, '2025-11-01 10:34:57', '2025-11-01 10:35:05', 16);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (14, 'EBC-CRTE-2025-11-01-005', 3, '2025-11-01 10:47:14', 2, 4860.00, 0.00, 0.00, 0.00, 200.00, 1500.00, 1300.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 10:47:25', 3, '2025-11-01 10:47:14', '2025-11-01 10:47:25', 17);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (15, 'EBC-CRTE-2025-11-01-006', 3, '2025-11-01 10:52:37', 3, 5327.30, 0.00, 1100.00, 0.00, 800.00, 1600.00, 800.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 10:52:46', 3, '2025-11-01 10:52:37', '2025-11-01 10:52:46', 18);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (16, 'EBC-CRTE-2025-11-01-007', 3, '2025-11-01 10:54:06', 1, 20.00, 20.00, 0.00, 0.00, 520.00, 520.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 10:54:19', 3, '2025-11-01 10:54:06', '2025-11-01 10:54:19', 19);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (17, 'EBC-CRTE-2025-11-01-008', 3, '2025-11-01 11:15:09', 7, 1228.00, 20.00, 350.00, 0.00, 520.00, 1205.00, 685.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 11:15:26', 3, '2025-11-01 11:15:09', '2025-11-01 11:15:26', 20);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (18, 'EBC-CRTE-2025-11-01-009', 3, '2025-11-01 11:17:16', 3, 60.00, 20.00, 20.00, 0.00, 520.00, 530.00, 10.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 11:17:38', 3, '2025-11-01 11:17:16', '2025-11-01 11:17:38', 21);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (19, 'EBC-CRTE-2025-11-01-010', 3, '2025-11-01 11:24:03', 3, 107.00, 55.00, 55.00, 0.00, 555.00, 552.00, -3.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 11:24:13', 3, '2025-11-01 11:24:03', '2025-11-01 11:24:13', 22);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (20, 'EBC-CRTE-2025-11-01-011', 3, '2025-11-01 11:30:24', 3, 796.50, 396.50, 400.00, 0.00, 496.50, 496.50, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 11:30:38', 3, '2025-11-01 11:30:24', '2025-11-01 11:30:38', 23);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (21, 'EBC-CRTE-2025-11-01-012', 3, '2025-11-01 11:35:41', 3, 300.00, 150.00, 150.00, 0.00, 250.00, 250.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 11:35:47', 3, '2025-11-01 11:35:41', '2025-11-01 11:35:47', 24);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (22, 'EBC-CRTE-2025-11-01-013', 2, '2025-11-01 16:42:23', 3, 316.00, 206.00, 110.00, 0.00, 206.00, 206.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 16:42:34', 2, '2025-11-01 16:42:23', '2025-11-01 16:42:34', NULL);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (23, 'EBC-CRTE-2025-11-01-014', 3, '2025-11-01 16:43:41', 0, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 16:43:46', 3, '2025-11-01 16:43:41', '2025-11-01 16:43:46', 25);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (24, 'EBC-CRTE-2025-11-01-015', 3, '2025-11-01 16:46:27', 1, 227.50, 27.50, 200.00, 0.00, 527.50, 527.50, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-01 16:46:33', 3, '2025-11-01 16:46:27', '2025-11-01 16:46:33', 26);
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`, `cash_session_id`) VALUES (25, 'EBC-CRTE-2025-11-02-001', 3, '2025-11-02 10:37:47', 1, 747.50, 97.50, 650.00, 0.00, 97.50, 97.50, 0.00, NULL, 'closed', 'EBCADMIN', '2025-11-02 10:37:52', 3, '2025-11-02 10:37:47', '2025-11-02 10:37:52', 27);

-- Estructura de la tabla `cash_movements`
DROP TABLE IF EXISTS `cash_movements`;
CREATE TABLE `cash_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cash_session_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('withdrawal','deposit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_movements_cash_session_id_foreign` (`cash_session_id`),
  KEY `cash_movements_user_id_foreign` (`user_id`),
  CONSTRAINT `cash_movements_cash_session_id_foreign` FOREIGN KEY (`cash_session_id`) REFERENCES `cash_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `cash_movements`
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (1, 25, 3, 'withdrawal', 200.00, 'Prueba de retiro de efectivo', 'EBCADMIN', '2025-11-01 13:15:25', '2025-11-01 13:15:25');
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (2, 25, 3, 'deposit', 200.00, 'Prueba de ingreso', NULL, '2025-11-01 13:27:19', '2025-11-01 13:27:19');
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (3, 25, 3, 'withdrawal', 400.00, 'Prueba de retiro de caja', 'EBCADMIN', '2025-11-01 13:31:28', '2025-11-01 13:31:28');
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (4, 25, 3, 'deposit', 200.00, 'Prueba de Ingreso de efectivo', NULL, '2025-11-01 13:31:50', '2025-11-01 13:31:50');
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (5, 25, 3, 'deposit', 200.00, 'Prueba de ingreso de efectivo', NULL, '2025-11-01 13:42:00', '2025-11-01 13:42:00');
INSERT INTO `cash_movements` (`id`, `cash_session_id`, `user_id`, `type`, `amount`, `reason`, `secret_code`, `created_at`, `updated_at`) VALUES (6, 27, 3, 'withdrawal', 500.00, 'Prueba de retiro', 'EBCADMIN', '2025-11-01 17:40:18', '2025-11-01 17:40:18');

-- Estructura de la tabla `cash_sessions`
DROP TABLE IF EXISTS `cash_sessions`;
CREATE TABLE `cash_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `initial_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_sales` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_card` decimal(10,2) NOT NULL DEFAULT '0.00',
  `voucher_count` int NOT NULL DEFAULT '0',
  `voucher_folios` text COLLATE utf8mb4_unicode_ci,
  `start_folio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_folio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `status` enum('active','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_sessions_user_id_foreign` (`user_id`),
  CONSTRAINT `cash_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `cash_sessions`
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (1, 4, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 18:15:03', '2025-10-26 18:20:59', 'closed', '2025-10-26 18:15:03', '2025-10-26 18:20:59');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (2, 3, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 21:57:14', '2025-10-26 22:42:30', 'closed', '2025-10-26 21:57:14', '2025-10-26 22:42:30');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (3, 3, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 22:52:00', '2025-10-26 22:53:50', 'closed', '2025-10-26 22:52:00', '2025-10-26 22:53:50');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (4, 3, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 22:55:42', '2025-10-26 22:55:48', 'closed', '2025-10-26 22:55:42', '2025-10-26 22:55:48');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (5, 3, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 23:00:43', '2025-10-26 23:02:12', 'closed', '2025-10-26 23:00:43', '2025-10-26 23:02:12');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (6, 3, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-26 23:02:44', '2025-10-26 23:19:57', 'closed', '2025-10-26 23:02:44', '2025-10-26 23:19:57');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (7, 3, 500.00, 304.00, 65.00, 112.00, 2, '[\"554651\",\"99551213\"]', NULL, NULL, '2025-10-27 00:55:07', '2025-10-27 17:00:30', 'closed', '2025-10-27 00:55:07', '2025-10-27 17:00:30');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (8, 3, 500.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, '2025-10-27 17:11:51', '2025-10-27 17:22:44', 'closed', '2025-10-27 17:11:51', '2025-10-27 17:22:44');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (9, 3, 500.00, 878.70, 695.54, 83.16, 0, NULL, NULL, NULL, '2025-10-27 18:11:07', '2025-10-28 13:18:29', 'closed', '2025-10-27 18:11:07', '2025-10-28 13:18:29');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (10, 3, 500.00, 1262.00, 601.92, 141.38, 0, NULL, NULL, NULL, '2025-10-28 13:18:54', '2025-10-30 20:38:49', 'closed', '2025-10-28 13:18:54', '2025-10-30 20:38:49');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (11, 3, 500.00, 350.00, 350.00, 0.00, 0, NULL, NULL, NULL, '2025-10-30 21:14:18', '2025-10-30 21:38:57', 'closed', '2025-10-30 21:14:18', '2025-10-30 21:38:57');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (12, 3, 500.00, 370.00, 370.00, 0.00, 0, NULL, NULL, NULL, '2025-10-30 21:39:16', '2025-10-31 23:37:14', 'closed', '2025-10-30 21:39:16', '2025-10-31 23:37:14');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (13, 3, 500.00, 971.08, 140.58, 385.00, 0, NULL, 'EBC-VNTA-029', 'EBC-VNTA-031', '2025-11-01 00:06:11', '2025-11-01 00:13:43', 'closed', '2025-11-01 00:06:11', '2025-11-01 00:13:43');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (14, 3, 500.00, 942.00, 100.00, 392.00, 2, '[\"152256321\",\"1522463212\"]', 'EBC-VNTA-032', 'EBC-VNTA-034', '2025-11-01 00:30:09', '2025-11-01 00:33:34', 'closed', '2025-11-01 00:30:09', '2025-11-01 00:33:34');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (15, 3, 300.00, 3343.83, 892.00, 1410.80, 5, '[\"1522561212\",\"1822563211\",\"1512563211\",\"1522583208\",\"1522463209\"]', 'EBC-VNTA-035', 'EBC-VNTA-042', '2025-11-01 00:51:01', '2025-11-01 01:30:13', 'closed', '2025-11-01 00:51:01', '2025-11-01 01:30:13');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (16, 3, 500.00, 945.00, 0.00, 450.00, 2, '[\"15225632119\",\"15225632124\"]', 'EBC-VNTA-043', 'EBC-VNTA-044', '2025-11-01 10:32:33', '2025-11-01 10:35:05', 'closed', '2025-11-01 10:32:33', '2025-11-01 10:35:05');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (17, 3, 200.00, 4860.00, 0.00, 0.00, 2, '[\"15225632128\",\"15225632116\"]', 'EBC-VNTA-045', 'EBC-VNTA-046', '2025-11-01 10:45:06', '2025-11-01 10:47:25', 'closed', '2025-11-01 10:45:06', '2025-11-01 10:47:25');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (18, 3, 800.00, 5327.30, 0.00, 1100.00, 3, '[\"998513156\",\"1522563218\",\"95851315\"]', 'EBC-VNTA-047', 'EBC-VNTA-049', '2025-11-01 10:50:20', '2025-11-01 10:52:46', 'closed', '2025-11-01 10:50:20', '2025-11-01 10:52:46');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (19, 3, 500.00, 20.00, 20.00, 0.00, 0, NULL, 'EBC-VNTA-050', 'EBC-VNTA-050', '2025-11-01 10:53:16', '2025-11-01 10:54:19', 'closed', '2025-11-01 10:53:16', '2025-11-01 10:54:19');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (20, 3, 500.00, 1228.00, 50.00, 350.00, 6, '[\"5894656998854\",\"85546102621\",\"46655212\",\"15225632122\",\"152256321152\",\"28647931456\"]', 'EBC-VNTA-051', 'EBC-VNTA-057', '2025-11-01 11:01:35', '2025-11-01 11:15:26', 'closed', '2025-11-01 11:01:35', '2025-11-01 11:15:26');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (21, 3, 500.00, 60.00, 50.00, 20.00, 2, '[\"829371456\",\"152256321185\"]', 'EBC-VNTA-058', 'EBC-VNTA-060', '2025-11-01 11:15:55', '2025-11-01 11:17:38', 'closed', '2025-11-01 11:15:55', '2025-11-01 11:17:38');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (22, 3, 500.00, 107.00, 50.00, 15.00, 2, '[\"123456789\",\"789456123\"]', 'EBC-VNTA-061', 'EBC-VNTA-063', '2025-11-01 11:21:58', '2025-11-01 11:24:13', 'closed', '2025-11-01 11:21:58', '2025-11-01 11:24:13');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (23, 3, 100.00, 796.50, 350.00, 100.00, 2, '[\"258147369\",\"963741852\"]', 'EBC-VNTA-064', 'EBC-VNTA-066', '2025-11-01 11:27:48', '2025-11-01 11:30:38', 'closed', '2025-11-01 11:27:48', '2025-11-01 11:30:38');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (24, 3, 100.00, 300.00, 100.00, 100.00, 2, '[\"75961562189784\",\"51561189514\"]', 'EBC-VNTA-067', 'EBC-VNTA-069', '2025-11-01 11:33:36', '2025-11-01 11:35:47', 'closed', '2025-11-01 11:33:36', '2025-11-01 11:35:47');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (25, 3, 500.00, 316.00, 140.00, 10.00, 2, '[\"152256320951\",\"152256321065\"]', 'EBC-VNTA-070', 'EBC-VNTA-072', '2025-11-01 12:43:50', '2025-11-01 16:43:46', 'closed', '2025-11-01 12:43:50', '2025-11-01 16:43:46');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (26, 3, 500.00, 227.50, 0.00, 0.00, 1, '[\"152256321252\"]', 'EBC-VNTA-073', 'EBC-VNTA-073', '2025-11-01 16:44:24', '2025-11-01 16:46:33', 'closed', '2025-11-01 16:44:24', '2025-11-01 16:46:33');
INSERT INTO `cash_sessions` (`id`, `user_id`, `initial_cash`, `total_sales`, `total_cash`, `total_card`, `voucher_count`, `voucher_folios`, `start_folio`, `end_folio`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES (27, 3, 500.00, 747.50, 0.00, 0.00, 1, '[\"1522563212852\"]', 'EBC-VNTA-074', 'EBC-VNTA-074', '2025-11-01 17:25:35', '2025-11-02 10:37:52', 'closed', '2025-11-01 17:25:35', '2025-11-02 10:37:52');

-- Estructura de la tabla `categories`
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `categories`
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `is_active`) VALUES (1, 'Bebibles', '2025-10-26 15:25:32', '2025-10-26 22:22:56', 1);
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `is_active`) VALUES (2, 'Botanas', '2025-10-26 15:25:42', '2025-10-26 15:25:42', 1);
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `is_active`) VALUES (3, 'Cuidado de la piel', '2025-10-26 15:25:58', '2025-10-26 15:25:58', 1);

-- Estructura de la tabla `clients`
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paternal_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maternal_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eight_digit_barcode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_eight_digit_barcode_unique` (`eight_digit_barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=16384 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `clients`
INSERT INTO `clients` (`id`, `name`, `first_name`, `paternal_lastname`, `maternal_lastname`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`, `eight_digit_barcode`, `deleted_at`) VALUES (1, 'Eunice', 'Eunice', 'Velazquez', 'Viramontes', 9935180334, 'thelionblack92@gmail.com', NULL, NULL, '2025-10-26 15:28:36', '2025-10-26 15:28:36', 72682482, NULL);
INSERT INTO `clients` (`id`, `name`, `first_name`, `paternal_lastname`, `maternal_lastname`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`, `eight_digit_barcode`, `deleted_at`) VALUES (2, 'Abiezer Abiam', 'Abiezer Abiam', 'Velazquez', 'Viramontes', 9932563285, 'empleado@ebc.com', NULL, NULL, '2025-10-26 22:22:15', '2025-10-26 22:55:14', 47663951, NULL);

-- Estructura de la tabla `coupons`
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `coupons`
INSERT INTO `coupons` (`id`, `name`, `discount_percentage`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Descuento Cliente Frecuente', 2.00, 1, '2025-11-01 14:54:56', '2025-11-02 10:41:19', NULL);
INSERT INTO `coupons` (`id`, `name`, `discount_percentage`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'PRUEBA50', 50.00, 1, '2025-11-01 14:55:30', '2025-11-01 14:55:30', NULL);
INSERT INTO `coupons` (`id`, `name`, `discount_percentage`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'PRUEBA90', 90.00, 1, '2025-11-01 14:55:55', '2025-11-01 14:55:55', NULL);
INSERT INTO `coupons` (`id`, `name`, `discount_percentage`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 'PRUEBA25', 25.00, 1, '2025-11-01 16:44:58', '2025-11-01 16:44:58', NULL);

-- Estructura de la tabla `failed_jobs`
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `job_batches`
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `jobs`
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=585 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2025_10_22_001904_create_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2025_10_22_001905_create_products_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2025_10_22_001905_create_services_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2025_10_22_001906_create_sales_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2025_10_22_001910_create_sale_details_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2025_10_25_000001_create_categories_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2025_10_25_183546_add_soft_deletes_to_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2025_10_25_205710_add_product_id_to_products_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12, '2025_10_25_210125_update_fields_in_products_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2025_10_25_220050_add_eight_digit_barcode_to_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14, '2025_10_25_221029_add_soft_deletes_to_products_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15, '2025_10_25_221442_alter_clients_table_add_lastname_fields', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16, '2025_10_25_222011_add_name_to_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17, '2025_10_25_230020_create_stock_movements_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18, '2025_10_25_231425_add_soft_deletes_to_clients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19, '2025_10_25_235020_add_pos_fields_to_sales_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20, '2025_10_25_235039_add_soft_deletes_to_sale_details_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21, '2025_10_26_120309_create_cash_counts_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22, '2025_10_26_120325_create_cash_cuts_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23, '2025_10_26_123358_add_payment_fields_to_sales_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24, '2025_10_26_124417_update_payment_method_enum_in_sales_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25, '2025_10_26_130533_add_deletion_tracking_to_sales_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26, '2025_10_26_134358_create_suppliers_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27, '2025_10_26_134536_add_supplier_id_to_products_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28, '2025_10_26_135826_add_is_active_to_categories_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29, '2025_10_26_162432_create_cash_sessions_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30, '2025_10_26_162527_add_voucher_tracking_to_sales_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31, '2025_10_26_231443_create_historical_sales_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32, '2025_10_26_234802_add_transferida_status_to_sales_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33, '2025_10_27_000100_update_payment_method_in_historical_sales_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34, '2025_10_27_002832_add_details_to_historical_sales_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35, '2025_10_27_005133_drop_historical_sales_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36, '2025_10_27_010557_add_voucher_amount_to_sales_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37, '2025_10_27_183605_add_card_type_to_sales_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38, '2025_10_28_160513_add_fields_to_services_table_and_create_service_product_table', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39, '2025_10_28_163822_add_is_active_to_services_table', 9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40, '2025_10_31_233934_add_profile_picture_to_users_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41, '2025_10_31_234856_add_folios_to_cash_sessions_table', 11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42, '2025_10_31_235041_add_cash_session_id_to_cash_counts_table', 12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43, '2025_10_31_235048_add_cash_session_id_to_cash_cuts_table', 12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44, '2025_11_01_123400_create_cash_movements_table', 13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45, '2025_11_01_142751_create_coupons_table', 14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46, '2025_11_02_000000_add_permissions_to_users_table', 15);

-- Estructura de la tabla `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Estructura de la tabla `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sell_price` decimal(8,2) NOT NULL,
  `cost_price` decimal(8,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `presentation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_product_id_unique` (`product_id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `products`
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (1, 'EBC-PRDTO-001', 'Colágeno (360gr)', 05157494, NULL, 50.00, 30.00, 32, NULL, '2025-10-26 15:29:46', '2025-11-01 17:26:40', 3, 3, 'piezas', NULL);
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (2, 'EBC-PRDTO-002', 'Sabritas Original (42 gr)', 7500478043927, NULL, 15.00, 10.00, 39, 'products/rl7pBGJd4ws4Jmv5L50PbbtDVzYxwhMJX37ypbTp.webp', '2025-10-26 15:49:18', '2025-11-01 17:26:40', 2, 2, 'piezas', NULL);
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (3, 'EBC-PRDTO-003', 'Coca Cola (600 ml)', 75007614, NULL, 20.00, 12.00, 47, 'products/qV4Qz0SLwshtzjsJ6mG5Hz3gOzZQkPgrJp0fK7zy.webp', '2025-10-26 15:49:57', '2025-11-01 17:26:40', 1, 1, 'piezas', NULL);
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (4, 'EBC-PRDTO-004', 'Mascarilla Negra', 46195786, NULL, 42.00, 20.00, 31, NULL, '2025-10-26 22:21:20', '2025-11-01 17:26:40', 3, 3, 'cajas', NULL);

-- Estructura de la tabla `sale_details`
DROP TABLE IF EXISTS `sale_details`;
CREATE TABLE `sale_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `item_type` enum('service','product') COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `stylist_id` bigint unsigned DEFAULT NULL,
  `commission_paid` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_details_item_type_item_id_index` (`item_type`,`item_id`),
  KEY `sale_details_sale_id_foreign` (`sale_id`),
  KEY `sale_details_stylist_id_foreign` (`stylist_id`),
  CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_details_stylist_id_foreign` FOREIGN KEY (`stylist_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=1820 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `sale_details`
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (14, 6, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-27 00:56:32', '2025-10-27 00:56:32', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (15, 6, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 00:56:32', '2025-10-27 00:56:32', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (16, 7, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-27 01:15:47', '2025-10-27 01:15:47', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (17, 7, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-27 01:15:47', '2025-10-27 01:15:47', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (18, 7, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 01:15:47', '2025-10-27 01:15:47', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (19, 8, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-27 01:16:23', '2025-10-27 01:16:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (20, 8, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 01:16:23', '2025-10-27 01:16:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (21, 8, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-27 01:16:23', '2025-10-27 01:16:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (22, 8, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 01:16:23', '2025-10-27 01:16:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (23, 9, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-27 18:11:37', '2025-10-27 18:11:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (24, 9, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 18:11:37', '2025-10-27 18:11:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (25, 9, 'product', 3, 20.00, 5, NULL, 0.00, '2025-10-27 18:11:37', '2025-10-27 18:11:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (26, 9, 'product', 4, 42.00, 5, NULL, 0.00, '2025-10-27 18:11:37', '2025-10-27 18:11:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (27, 10, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 21:15:45', '2025-10-27 21:15:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (28, 10, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-27 21:15:45', '2025-10-27 21:15:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (29, 10, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 21:15:45', '2025-10-27 21:15:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (30, 11, 'product', 3, 20.00, 2, NULL, 0.00, '2025-10-27 21:47:37', '2025-10-27 21:47:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (31, 11, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 21:47:37', '2025-10-27 21:47:37', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (32, 12, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 22:17:06', '2025-10-27 22:17:06', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (33, 13, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 22:17:30', '2025-10-27 22:17:30', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (34, 14, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-27 22:21:33', '2025-10-27 22:21:33', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (35, 15, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-27 22:36:45', '2025-10-27 22:36:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (36, 15, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-27 22:36:45', '2025-10-27 22:36:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (37, 16, 'product', 4, 42.00, 2, NULL, 0.00, '2025-10-27 22:37:34', '2025-10-27 22:37:34', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (38, 17, 'product', 1, 50.00, 2, NULL, 0.00, '2025-10-27 22:38:32', '2025-10-27 22:38:32', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (39, 18, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 13:20:07', '2025-10-28 13:20:07', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (40, 18, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-28 13:20:07', '2025-10-28 13:20:07', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (41, 18, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 13:20:07', '2025-10-28 13:20:07', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (42, 19, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 13:26:35', '2025-10-28 13:26:35', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (43, 19, 'product', 3, 20.00, 10, NULL, 0.00, '2025-10-28 13:26:35', '2025-10-28 13:26:35', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (44, 20, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-28 13:28:01', '2025-10-28 13:28:01', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (45, 21, 'product', 3, 20.00, 5, NULL, 0.00, '2025-10-28 13:29:21', '2025-10-28 13:29:21', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (46, 21, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 13:29:21', '2025-10-28 13:29:21', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (47, 22, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 13:35:39', '2025-10-28 13:35:39', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (48, 23, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 13:36:40', '2025-10-28 13:36:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (49, 23, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-28 13:36:40', '2025-10-28 13:36:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (50, 24, 'product', 3, 20.00, 2, NULL, 0.00, '2025-10-28 13:38:05', '2025-10-28 13:38:05', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (51, 25, 'product', 3, 20.00, 2, NULL, 0.00, '2025-10-28 13:45:54', '2025-10-28 13:45:54', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (52, 25, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 13:45:54', '2025-10-28 13:45:54', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (53, 26, 'product', 3, 20.00, 9, NULL, 0.00, '2025-10-28 13:47:57', '2025-10-28 13:47:57', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (54, 27, 'product', 3, 20.00, 3, NULL, 0.00, '2025-10-28 13:55:01', '2025-10-28 13:55:01', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (55, 28, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-28 14:07:51', '2025-10-28 14:07:51', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (56, 28, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 14:07:51', '2025-10-28 14:07:51', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (57, 29, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 14:29:35', '2025-10-28 14:29:35', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (58, 29, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 14:29:35', '2025-10-28 14:29:35', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (59, 30, 'product', 4, 42.00, 1, NULL, 0.00, '2025-10-28 15:14:36', '2025-10-28 15:14:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (60, 30, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-28 15:14:36', '2025-10-28 15:14:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (61, 30, 'product', 1, 50.00, 1, NULL, 0.00, '2025-10-28 15:14:36', '2025-10-28 15:14:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (62, 31, 'service', 4, 350.00, 1, NULL, 0.00, '2025-10-30 21:12:18', '2025-10-30 21:12:18', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (63, 32, 'service', 4, 350.00, 1, NULL, 0.00, '2025-10-30 21:14:38', '2025-10-30 21:14:38', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (64, 33, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-30 22:15:27', '2025-10-30 22:15:27', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (65, 33, 'service', 4, 350.00, 1, NULL, 0.00, '2025-10-30 22:15:27', '2025-10-30 22:15:27', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (66, 34, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 00:06:53', '2025-11-01 00:06:53', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (67, 34, 'product', 4, 42.00, 1, NULL, 0.00, '2025-11-01 00:06:53', '2025-11-01 00:06:53', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (68, 35, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 00:08:40', '2025-11-01 00:08:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (69, 35, 'product', 2, 15.00, 1, NULL, 0.00, '2025-11-01 00:08:40', '2025-11-01 00:08:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (70, 35, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 00:08:40', '2025-11-01 00:08:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (71, 36, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 00:09:29', '2025-11-01 00:09:29', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (72, 36, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 00:09:29', '2025-11-01 00:09:29', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (73, 37, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 00:30:29', '2025-11-01 00:30:29', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (74, 38, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 00:31:00', '2025-11-01 00:31:00', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (75, 38, 'product', 4, 42.00, 1, NULL, 0.00, '2025-11-01 00:31:00', '2025-11-01 00:31:00', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (76, 39, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 00:31:36', '2025-11-01 00:31:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (77, 39, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 00:31:36', '2025-11-01 00:31:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (78, 40, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 00:51:49', '2025-11-01 00:51:49', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (79, 40, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 00:51:49', '2025-11-01 00:51:49', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (80, 41, 'product', 4, 42.00, 1, NULL, 0.00, '2025-11-01 01:01:27', '2025-11-01 01:01:27', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (81, 41, 'product', 3, 20.00, 3, NULL, 0.00, '2025-11-01 01:01:27', '2025-11-01 01:01:27', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (82, 41, 'product', 2, 15.00, 3, NULL, 0.00, '2025-11-01 01:01:27', '2025-11-01 01:01:27', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (83, 42, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 01:12:08', '2025-11-01 01:12:08', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (84, 43, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 01:12:51', '2025-11-01 01:12:51', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (85, 44, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 01:19:28', '2025-11-01 01:19:28', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (86, 44, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 01:19:28', '2025-11-01 01:19:28', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (87, 45, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 01:19:51', '2025-11-01 01:19:51', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (88, 45, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 01:19:51', '2025-11-01 01:19:51', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (89, 46, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 01:24:47', '2025-11-01 01:24:47', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (90, 46, 'product', 2, 15.00, 10, NULL, 0.00, '2025-11-01 01:24:47', '2025-11-01 01:24:47', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (91, 47, 'product', 1, 50.00, 10, NULL, 0.00, '2025-11-01 01:26:38', '2025-11-01 01:26:38', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (92, 47, 'product', 4, 42.00, 10, NULL, 0.00, '2025-11-01 01:26:38', '2025-11-01 01:26:38', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (93, 48, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 10:33:03', '2025-11-01 10:33:03', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (94, 48, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 10:33:03', '2025-11-01 10:33:03', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (95, 49, 'product', 1, 50.00, 10, NULL, 0.00, '2025-11-01 10:33:40', '2025-11-01 10:33:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (96, 50, 'service', 4, 350.00, 2, NULL, 0.00, '2025-11-01 10:45:40', '2025-11-01 10:45:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (97, 50, 'service', 5, 100.00, 2, NULL, 0.00, '2025-11-01 10:45:40', '2025-11-01 10:45:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (98, 51, 'service', 4, 350.00, 10, NULL, 0.00, '2025-11-01 10:46:23', '2025-11-01 10:46:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (99, 51, 'service', 5, 100.00, 5, NULL, 0.00, '2025-11-01 10:46:23', '2025-11-01 10:46:23', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (100, 52, 'service', 5, 100.00, 11, NULL, 0.00, '2025-11-01 10:50:40', '2025-11-01 10:50:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (101, 53, 'service', 4, 350.00, 11, NULL, 0.00, '2025-11-01 10:51:12', '2025-11-01 10:51:12', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (102, 54, 'product', 4, 42.00, 10, NULL, 0.00, '2025-11-01 10:52:05', '2025-11-01 10:52:05', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (103, 55, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 10:53:36', '2025-11-01 10:53:36', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (104, 56, 'product', 2, 15.00, 10, NULL, 0.00, '2025-11-01 11:07:02', '2025-11-01 11:07:02', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (105, 56, 'product', 3, 20.00, 10, NULL, 0.00, '2025-11-01 11:07:02', '2025-11-01 11:07:02', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (106, 57, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 11:08:41', '2025-11-01 11:08:41', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (107, 58, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 11:09:09', '2025-11-01 11:09:09', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (108, 59, 'product', 2, 15.00, 1, NULL, 0.00, '2025-11-01 11:09:44', '2025-11-01 11:09:44', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (109, 60, 'product', 1, 50.00, 1, NULL, 0.00, '2025-11-01 11:12:42', '2025-11-01 11:12:42', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (110, 61, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 11:13:32', '2025-11-01 11:13:32', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (111, 62, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 11:14:19', '2025-11-01 11:14:19', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (112, 63, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 11:16:10', '2025-11-01 11:16:10', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (113, 64, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 11:16:31', '2025-11-01 11:16:31', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (114, 65, 'product', 3, 20.00, 1, NULL, 0.00, '2025-11-01 11:16:58', '2025-11-01 11:16:58', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (115, 66, 'product', 1, 50.00, 1, NULL, 0.00, '2025-11-01 11:22:11', '2025-11-01 11:22:11', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (116, 67, 'product', 2, 15.00, 1, NULL, 0.00, '2025-11-01 11:22:28', '2025-11-01 11:22:28', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (117, 68, 'product', 4, 42.00, 1, NULL, 0.00, '2025-11-01 11:22:52', '2025-11-01 11:22:52', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (118, 69, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 11:28:13', '2025-11-01 11:28:13', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (119, 70, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 11:28:46', '2025-11-01 11:28:46', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (120, 71, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 11:29:26', '2025-11-01 11:29:26', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (121, 72, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 11:33:45', '2025-11-01 11:33:45', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (122, 73, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 11:34:09', '2025-11-01 11:34:09', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (123, 74, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 11:34:38', '2025-11-01 11:34:38', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (124, 75, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 16:39:16', '2025-11-01 16:39:16', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (125, 76, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 16:40:22', '2025-11-01 16:40:22', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (126, 77, 'product', 1, 50.00, 1, NULL, 0.00, '2025-11-01 16:41:17', '2025-11-01 16:41:17', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (127, 77, 'product', 2, 15.00, 1, NULL, 0.00, '2025-11-01 16:41:17', '2025-11-01 16:41:17', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (128, 77, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 16:41:17', '2025-11-01 16:41:17', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (129, 78, 'service', 4, 350.00, 1, NULL, 0.00, '2025-11-01 16:45:40', '2025-11-01 16:45:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (130, 79, 'service', 5, 100.00, 1, NULL, 0.00, '2025-11-01 17:26:40', '2025-11-01 17:26:40', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (131, 79, 'service', 4, 350.00, 3, NULL, 0.00, '2025-11-01 17:26:40', '2025-11-01 17:26:40', NULL);

-- Estructura de la tabla `sales`
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `folio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `discount_coupon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('efectivo','tarjeta','transferencia','otro','mixto') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` enum('debito','credito') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_folio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `voucher_count` int NOT NULL DEFAULT '0',
  `voucher_folios` text COLLATE utf8mb4_unicode_ci,
  `card_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('completada','pendiente','cancelada','transferida') COLLATE utf8mb4_unicode_ci DEFAULT 'completada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by_id` bigint unsigned DEFAULT NULL,
  `deletion_reason` text COLLATE utf8mb4_unicode_ci,
  `cash_session_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_folio_unique` (`folio`),
  KEY `sales_deleted_by_type_deleted_by_id_index` (`deleted_by_type`,`deleted_by_id`),
  KEY `sales_payment_method_voucher_folio_index` (`payment_method`,`voucher_folio`),
  KEY `sales_cash_session_id_foreign` (`cash_session_id`),
  KEY `sales_client_id_foreign` (`client_id`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_cash_session_id_foreign` FOREIGN KEY (`cash_session_id`) REFERENCES `cash_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=4096 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `sales`
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (6, 'EBC-VNTA-001', NULL, 3, 65.00, 0.00, 65.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 65.00, 'transferida', '2025-10-27 00:56:32', '2025-10-27 01:17:35', NULL, NULL, NULL, NULL, 7);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (7, 'EBC-VNTA-002', NULL, 3, 112.00, 0.00, 112.00, NULL, 'tarjeta', NULL, 554651, 0.00, 1, '[\"554651\"]', 112.00, 0.00, 'transferida', '2025-10-27 01:15:47', '2025-10-27 01:17:35', NULL, NULL, NULL, NULL, 7);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (8, 'EBC-VNTA-003', NULL, 3, 127.00, 0.00, 127.00, NULL, 'mixto', NULL, 99551213, 0.00, 1, '[\"99551213\"]', 0.00, 127.00, 'transferida', '2025-10-27 01:16:23', '2025-10-27 01:17:35', NULL, NULL, NULL, NULL, 7);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (9, 'EBC-VNTA-004', NULL, 3, 375.00, 0.00, 375.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 375.00, 'transferida', '2025-10-27 18:11:37', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (10, 'EBC-VNTA-005', NULL, 3, 77.00, 0.00, 77.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 77.00, 'transferida', '2025-10-27 21:15:45', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (11, 'EBC-VNTA-006', 1, 3, 82.00, 0.82, 81.18, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 81.18, 'transferida', '2025-10-27 21:47:37', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (12, 'EBC-VNTA-007', 1, 3, 42.00, 0.42, 41.58, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 41.58, 'transferida', '2025-10-27 22:17:06', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (13, 'EBC-VNTA-008', 2, 3, 15.00, 0.15, 14.85, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 14.85, 'transferida', '2025-10-27 22:17:30', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (14, 'EBC-VNTA-009', 2, 3, 42.00, 0.42, 41.58, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 41.58, 'transferida', '2025-10-27 22:21:33', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (15, 'EBC-VNTA-010', 1, 3, 65.00, 0.65, 64.35, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 64.35, 'transferida', '2025-10-27 22:36:45', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (16, 'EBC-VNTA-011', 2, 3, 84.00, 0.84, 83.16, NULL, 'tarjeta', 'debito', 9522161, 0.00, 0, '[]', 83.16, 0.00, 'transferida', '2025-10-27 22:37:34', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (17, 'EBC-VNTA-012', NULL, 3, 100.00, 0.00, 100.00, NULL, 'mixto', 'credito', 9522161, 50.00, 0, '[]', 50.00, 50.00, 'transferida', '2025-10-27 22:38:32', '2025-10-28 13:18:29', NULL, NULL, NULL, NULL, 9);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (18, 'EBC-VNTA-013', 1, 3, 112.00, 1.12, 110.88, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 110.88, 'transferida', '2025-10-28 13:20:07', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (19, 'EBC-VNTA-014', 2, 3, 242.00, 2.42, 239.58, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 239.58, 'transferida', '2025-10-28 13:26:35', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (20, 'EBC-VNTA-015', NULL, 3, 20.00, 0.00, 20.00, NULL, 'tarjeta', 'credito', 1522563212, 0.00, 0, '[]', 20.00, 0.00, 'transferida', '2025-10-28 13:28:01', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (21, 'EBC-VNTA-016', 1, 3, 150.00, 1.50, 148.50, NULL, 'mixto', 'debito', 155462664, 100.00, 0, '[]', 100.00, 48.50, 'transferida', '2025-10-28 13:29:21', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (22, 'EBC-VNTA-017', 1, 3, 50.00, 0.50, 49.50, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 49.50, 'transferida', '2025-10-28 13:35:39', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (23, 'EBC-VNTA-018', 2, 3, 62.00, 0.62, 61.38, NULL, 'tarjeta', 'debito', 1522563211, 0.00, 0, '[]', 61.38, 0.00, 'transferida', '2025-10-28 13:36:40', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (24, 'EBC-VNTA-019', NULL, 3, 40.00, 0.00, 40.00, NULL, 'mixto', 'credito', 1522563210, 20.00, 0, '[]', 20.00, 20.00, 'transferida', '2025-10-28 13:38:05', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (25, 'EBC-VNTA-020', NULL, 3, 90.00, 0.00, 90.00, NULL, 'mixto', 'debito', 1522563209, 50.00, 0, '[]', 50.00, 40.00, 'transferida', '2025-10-28 13:45:54', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (26, 'EBC-VNTA-021', 1, 3, 180.00, 1.80, 178.20, NULL, 'mixto', 'debito', 99851315, 100.40, 0, '[]', 100.40, 77.80, 'transferida', '2025-10-28 13:47:57', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (27, 'EBC-VNTA-022', NULL, 3, 60.00, 0.00, 60.00, NULL, 'tarjeta', 'credito', 1522563208, 0.00, 0, '[]', 60.00, 0.00, 'transferida', '2025-10-28 13:55:01', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (28, 'EBC-VNTA-023', NULL, 3, 62.00, 0.00, 62.00, NULL, 'mixto', 'debito', 15225632125, 60.00, 0, '[]', 60.00, 2.00, 'transferida', '2025-10-28 14:07:51', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (29, 'EBC-VNTA-024', 2, 3, 92.00, 0.92, 91.08, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 91.08, 'transferida', '2025-10-28 14:29:35', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (30, 'EBC-VNTA-025', 1, 3, 112.00, 1.12, 110.88, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 110.88, 'transferida', '2025-10-28 15:14:36', '2025-10-28 17:30:50', NULL, NULL, NULL, NULL, 10);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (31, 'EBC-VNTA-026', NULL, 3, 350.00, 0.00, 350.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 350.00, 'completada', '2025-10-30 21:12:18', '2025-10-30 21:12:18', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (32, 'EBC-VNTA-027', NULL, 3, 350.00, 0.00, 350.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 350.00, 'transferida', '2025-10-30 21:14:38', '2025-10-30 21:38:57', NULL, NULL, NULL, NULL, 11);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (33, 'EBC-VNTA-028', NULL, 3, 370.00, 0.00, 370.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 370.00, 'transferida', '2025-10-30 22:15:27', '2025-10-31 23:37:14', NULL, NULL, NULL, NULL, 12);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (34, 'EBC-VNTA-029', 1, 3, 142.00, 1.42, 140.58, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 140.58, 'transferida', '2025-11-01 00:06:53', '2025-11-01 00:13:02', NULL, NULL, NULL, NULL, 13);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (35, 'EBC-VNTA-030', NULL, 3, 385.00, 0.00, 385.00, NULL, 'tarjeta', 'debito', 1522563207, 0.00, 0, '[]', 385.00, 0.00, 'transferida', '2025-11-01 00:08:40', '2025-11-01 00:13:02', NULL, NULL, NULL, NULL, 13);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (36, 'EBC-VNTA-031', 2, 3, 450.00, 4.50, 445.50, NULL, 'mixto', 'credito', 1522563206, 400.00, 0, '[]', 400.00, 45.50, 'transferida', '2025-11-01 00:09:28', '2025-11-01 00:13:02', NULL, NULL, NULL, NULL, 13);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (37, 'EBC-VNTA-032', NULL, 3, 100.00, 0.00, 100.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 100.00, 'transferida', '2025-11-01 00:30:29', '2025-11-01 00:33:09', NULL, NULL, NULL, NULL, 14);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (38, 'EBC-VNTA-033', NULL, 3, 392.00, 0.00, 392.00, NULL, 'tarjeta', 'debito', 152256321, 0.00, 1, '[\"152256321\"]', 392.00, 0.00, 'transferida', '2025-11-01 00:31:00', '2025-11-01 00:33:09', NULL, NULL, NULL, NULL, 14);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (39, 'EBC-VNTA-034', NULL, 3, 450.00, 0.00, 450.00, NULL, 'mixto', 'credito', 1522463212, 400.00, 1, '[\"1522463212\"]', 400.00, 50.00, 'transferida', '2025-11-01 00:31:36', '2025-11-01 00:33:09', NULL, NULL, NULL, NULL, 14);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (40, 'EBC-VNTA-035', 1, 3, 450.00, 4.50, 445.50, NULL, 'mixto', 'debito', 1522561212, 400.00, 1, '[\"1522561212\"]', 400.00, 45.50, 'transferida', '2025-11-01 00:51:49', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (41, 'EBC-VNTA-036', 1, 3, 147.00, 1.47, 145.53, NULL, 'mixto', 'debito', 1822563211, 100.00, 1, '[\"1822563211\"]', 100.00, 45.53, 'transferida', '2025-11-01 01:01:27', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (42, 'EBC-VNTA-037', NULL, 3, 100.00, 0.00, 100.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 100.00, 'transferida', '2025-11-01 01:12:08', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (43, 'EBC-VNTA-038', 1, 3, 350.00, 3.50, 346.50, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 346.50, 'transferida', '2025-11-01 01:12:51', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (44, 'EBC-VNTA-039', NULL, 3, 450.00, 0.00, 450.00, NULL, 'mixto', 'credito', 1512563211, 321.00, 1, '[\"1512563211\"]', 321.00, 129.00, 'transferida', '2025-11-01 01:19:28', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (45, 'EBC-VNTA-040', 1, 3, 450.00, 4.50, 445.50, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 445.50, 'transferida', '2025-11-01 01:19:51', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (46, 'EBC-VNTA-041', NULL, 3, 500.00, 0.00, 500.00, NULL, 'tarjeta', 'debito', 1522583208, 0.00, 1, '[\"1522583208\"]', 500.00, 0.00, 'transferida', '2025-11-01 01:24:47', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (47, 'EBC-VNTA-042', 1, 3, 920.00, 9.20, 910.80, NULL, 'tarjeta', 'credito', 1522463209, 0.00, 1, '[\"1522463209\"]', 910.80, 0.00, 'transferida', '2025-11-01 01:26:38', '2025-11-01 01:28:19', NULL, NULL, NULL, NULL, 15);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (48, 'EBC-VNTA-043', NULL, 3, 450.00, 0.00, 450.00, NULL, 'tarjeta', 'credito', 15225632119, 0.00, 1, '[\"15225632119\"]', 450.00, 0.00, 'transferida', '2025-11-01 10:33:03', '2025-11-01 10:34:57', NULL, NULL, NULL, NULL, 16);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (49, 'EBC-VNTA-044', 1, 3, 500.00, 5.00, 495.00, NULL, 'mixto', 'credito', 15225632124, 90.00, 1, '[\"15225632124\"]', 90.00, 405.00, 'transferida', '2025-11-01 10:33:40', '2025-11-01 10:34:57', NULL, NULL, NULL, NULL, 16);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (50, 'EBC-VNTA-045', NULL, 3, 900.00, 0.00, 900.00, NULL, 'mixto', 'debito', 15225632128, 700.00, 1, '[\"15225632128\"]', 700.00, 200.00, 'transferida', '2025-11-01 10:45:40', '2025-11-01 10:47:14', NULL, NULL, NULL, NULL, 17);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (51, 'EBC-VNTA-046', 1, 3, 4000.00, 40.00, 3960.00, NULL, 'mixto', 'credito', 15225632116, 3000.00, 1, '[\"15225632116\"]', 3000.00, 960.00, 'transferida', '2025-11-01 10:46:23', '2025-11-01 10:47:14', NULL, NULL, NULL, NULL, 17);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (52, 'EBC-VNTA-047', NULL, 3, 1100.00, 0.00, 1100.00, NULL, 'tarjeta', 'debito', 998513156, 0.00, 1, '[\"998513156\"]', 1100.00, 0.00, 'transferida', '2025-11-01 10:50:40', '2025-11-01 10:52:37', NULL, NULL, NULL, NULL, 18);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (53, 'EBC-VNTA-048', 1, 3, 3850.00, 38.50, 3811.50, NULL, 'mixto', 'debito', 1522563218, 3000.00, 1, '[\"1522563218\"]', 3000.00, 811.50, 'transferida', '2025-11-01 10:51:12', '2025-11-01 10:52:37', NULL, NULL, NULL, NULL, 18);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (54, 'EBC-VNTA-049', 1, 3, 420.00, 4.20, 415.80, NULL, 'mixto', 'debito', 95851315, 400.00, 1, '[\"95851315\"]', 400.00, 15.80, 'transferida', '2025-11-01 10:52:05', '2025-11-01 10:52:37', NULL, NULL, NULL, NULL, 18);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (55, 'EBC-VNTA-050', NULL, 3, 20.00, 0.00, 20.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 20.00, 'transferida', '2025-11-01 10:53:36', '2025-11-01 10:54:06', NULL, NULL, NULL, NULL, 19);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (56, 'EBC-VNTA-051', 1, 3, 350.00, 3.50, 346.50, NULL, 'mixto', 'credito', 5894656998854, 300.00, 1, '[\"5894656998854\"]', 300.00, 50.00, 'transferida', '2025-11-01 11:07:02', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (57, 'EBC-VNTA-052', NULL, 3, 20.00, 0.00, 20.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 50.00, 'transferida', '2025-11-01 11:08:41', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (58, 'EBC-VNTA-053', NULL, 3, 350.00, 0.00, 350.00, NULL, 'tarjeta', 'debito', 85546102621, 0.00, 1, '[\"85546102621\"]', 350.00, 0.00, 'transferida', '2025-11-01 11:09:09', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (59, 'EBC-VNTA-054', NULL, 3, 15.00, 0.00, 15.00, NULL, 'mixto', 'credito', 46655212, 10.00, 1, '[\"46655212\"]', 10.00, 5.00, 'transferida', '2025-11-01 11:09:44', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (60, 'EBC-VNTA-055', NULL, 3, 50.00, 0.00, 50.00, NULL, 'mixto', 'debito', 15225632122, 25.00, 1, '[\"15225632122\"]', 25.00, 30.00, 'transferida', '2025-11-01 11:12:42', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (61, 'EBC-VNTA-056', NULL, 3, 100.00, 0.00, 100.00, NULL, 'mixto', 'credito', 152256321152, 50.00, 1, '[\"152256321152\"]', 50.00, 50.00, 'transferida', '2025-11-01 11:13:32', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (62, 'EBC-VNTA-057', 1, 3, 350.00, 3.50, 346.50, NULL, 'mixto', 'debito', 28647931456, 300.00, 1, '[\"28647931456\"]', 300.00, 50.00, 'transferida', '2025-11-01 11:14:19', '2025-11-01 11:15:09', NULL, NULL, NULL, NULL, 20);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (63, 'EBC-VNTA-058', NULL, 3, 20.00, 0.00, 20.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 50.00, 'transferida', '2025-11-01 11:16:10', '2025-11-01 11:17:16', NULL, NULL, NULL, NULL, 21);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (64, 'EBC-VNTA-059', NULL, 3, 20.00, 0.00, 20.00, NULL, 'tarjeta', 'debito', 829371456, 0.00, 1, '[\"829371456\"]', 20.00, 0.00, 'transferida', '2025-11-01 11:16:31', '2025-11-01 11:17:16', NULL, NULL, NULL, NULL, 21);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (65, 'EBC-VNTA-060', NULL, 3, 20.00, 0.00, 20.00, NULL, 'mixto', 'debito', 152256321185, 10.00, 1, '[\"152256321185\"]', 10.00, 10.00, 'transferida', '2025-11-01 11:16:58', '2025-11-01 11:17:16', NULL, NULL, NULL, NULL, 21);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (66, 'EBC-VNTA-061', NULL, 3, 50.00, 0.00, 50.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 50.00, 'transferida', '2025-11-01 11:22:11', '2025-11-01 11:24:03', NULL, NULL, NULL, NULL, 22);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (67, 'EBC-VNTA-062', NULL, 3, 15.00, 0.00, 15.00, NULL, 'tarjeta', 'debito', 123456789, 0.00, 1, '[\"123456789\"]', 15.00, 0.00, 'transferida', '2025-11-01 11:22:28', '2025-11-01 11:24:03', NULL, NULL, NULL, NULL, 22);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (68, 'EBC-VNTA-063', NULL, 3, 42.00, 0.00, 42.00, NULL, 'mixto', 'credito', 789456123, 40.00, 1, '[\"789456123\"]', 40.00, 5.00, 'transferida', '2025-11-01 11:22:52', '2025-11-01 11:24:03', NULL, NULL, NULL, NULL, 22);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (69, 'EBC-VNTA-064', NULL, 3, 350.00, 0.00, 350.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 350.00, 'transferida', '2025-11-01 11:28:13', '2025-11-01 11:30:24', NULL, NULL, NULL, NULL, 23);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (70, 'EBC-VNTA-065', NULL, 3, 100.00, 0.00, 100.00, NULL, 'tarjeta', 'debito', 258147369, 0.00, 1, '[\"258147369\"]', 100.00, 0.00, 'transferida', '2025-11-01 11:28:46', '2025-11-01 11:30:24', NULL, NULL, NULL, NULL, 23);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (71, 'EBC-VNTA-066', 1, 3, 350.00, 3.50, 346.50, NULL, 'mixto', 'credito', 963741852, 300.00, 1, '[\"963741852\"]', 300.00, 46.50, 'transferida', '2025-11-01 11:29:26', '2025-11-01 11:30:24', NULL, NULL, NULL, NULL, 23);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (72, 'EBC-VNTA-067', NULL, 3, 100.00, 0.00, 100.00, NULL, 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 100.00, 'transferida', '2025-11-01 11:33:45', '2025-11-01 11:35:41', NULL, NULL, NULL, NULL, 24);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (73, 'EBC-VNTA-068', NULL, 3, 100.00, 0.00, 100.00, NULL, 'tarjeta', 'debito', 75961562189784, 0.00, 1, '[\"75961562189784\"]', 100.00, 0.00, 'transferida', '2025-11-01 11:34:09', '2025-11-01 11:35:41', NULL, NULL, NULL, NULL, 24);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (74, 'EBC-VNTA-069', NULL, 3, 100.00, 0.00, 100.00, NULL, 'mixto', 'credito', 51561189514, 50.00, 1, '[\"51561189514\"]', 50.00, 50.00, 'transferida', '2025-11-01 11:34:38', '2025-11-01 11:35:41', NULL, NULL, NULL, NULL, 24);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (75, 'EBC-VNTA-070', 1, 3, 350.00, 210.00, 140.00, 'PRUEBA50', 'efectivo', NULL, NULL, 0.00, 0, '[]', 0.00, 140.00, 'transferida', '2025-11-01 16:39:16', '2025-11-01 16:42:23', NULL, NULL, NULL, NULL, 25);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (76, 'EBC-VNTA-071', NULL, 3, 100.00, 90.00, 10.00, 'PRUEBA90', 'tarjeta', 'debito', 152256320951, 0.00, 1, '[\"152256320951\"]', 10.00, 0.00, 'transferida', '2025-11-01 16:40:22', '2025-11-01 16:42:23', NULL, NULL, NULL, NULL, 25);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (77, 'EBC-VNTA-072', 1, 3, 415.00, 249.00, 166.00, 'PRUEBA50', 'mixto', 'credito', 152256321065, 100.00, 1, '[\"152256321065\"]', 100.00, 66.00, 'transferida', '2025-11-01 16:41:17', '2025-11-01 16:42:23', NULL, NULL, NULL, NULL, 25);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (78, 'EBC-VNTA-073', 2, 3, 350.00, 122.50, 227.50, 'PRUEBA25', 'mixto', 'credito', 152256321252, 200.00, 1, '[\"152256321252\"]', 200.00, 27.50, 'transferida', '2025-11-01 16:45:40', '2025-11-01 16:46:27', NULL, NULL, NULL, NULL, 26);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `card_type`, `voucher_folio`, `voucher_amount`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (79, 'EBC-VNTA-074', 1, 3, 1150.00, 402.50, 747.50, 'PRUEBA25', 'mixto', 'debito', 1522563212852, 650.00, 1, '[\"1522563212852\"]', 650.00, 97.50, 'transferida', '2025-11-01 17:26:40', '2025-11-02 10:37:47', NULL, NULL, NULL, NULL, 27);

-- Estructura de la tabla `service_product`
DROP TABLE IF EXISTS `service_product`;
CREATE TABLE `service_product` (
  `service_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`service_id`,`product_id`),
  KEY `service_product_product_id_foreign` (`product_id`),
  CONSTRAINT `service_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_product_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `service_product`
INSERT INTO `service_product` (`service_id`, `product_id`) VALUES (4, 1);
INSERT INTO `service_product` (`service_id`, `product_id`) VALUES (5, 2);
INSERT INTO `service_product` (`service_id`, `product_id`) VALUES (5, 3);
INSERT INTO `service_product` (`service_id`, `product_id`) VALUES (4, 4);

-- Estructura de la tabla `services`
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(8,2) NOT NULL,
  `duration_minutes` int NOT NULL DEFAULT '30',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_name_unique` (`name`),
  UNIQUE KEY `services_service_id_unique` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `services`
INSERT INTO `services` (`id`, `service_id`, `name`, `description`, `image_path`, `is_active`, `price`, `duration_minutes`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 'EBC-SERV-001', 'Prueba de Servicio', 'Servicio Test', 'images/servicio_comodin.webp', 1, 350.00, 60, '2025-10-30 20:53:41', '2025-10-30 20:53:41', NULL);
INSERT INTO `services` (`id`, `service_id`, `name`, `description`, `image_path`, `is_active`, `price`, `duration_minutes`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 'EBC-SERV-002', 'Servicio Refrescante', 'Servicio Test', 'images/servicio_comodin.webp', 1, 100.00, 30, '2025-10-30 21:00:15', '2025-10-30 21:00:15', NULL);

-- Estructura de la tabla `sessions`
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=8192 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('4pUNPpQrpnkR9AuWJ9fGhgBbfH8CzMr20a7RHDtv', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaTFVYnFqcUJuRUpjSkhza3c5OWlHOEF2S1pKbllUTEs5MVA4dVdCTSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3Byb2ZpbGUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2RhdGFiYXNlL2JhY2t1cCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1762102925);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('8wqQdND7JGuSTFSp98FJnj01W4YZucs8GA53IgHD', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMDhYNjBDNTBRUDNFeTVMMXM0Wk9QY0kyMWdxMFZYTXFzTGxCcHRrNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1762041899);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('S2lX910jnUb6KSjU64XVsgPoqNQRV20xCCMeaECk', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVDFscXJod3ZrakJ5UzlDS0RpYVhHalRFRW5weE4xdnNFQ0IxdDhLSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLWNvbnRyb2wiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1762041896);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('tk569BjnrgLdUzmfIWIed7vW4pD6p24rm91YMCKd', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidTZSNURTWm54cnpRMGdOZnJEd3ppN2hSRlQ1MkxYTU9ZMWJLSlhrUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLXNlc3Npb25zLzI3Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1762041896);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('vAJkBbLwpBGsZ0Pc8IK1n7xhKiCsvm4GFuX7ryQf', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmN6UUNJWlh3SDlLRW5ER3JBUlc5MHBLbENnTlQ2ZHZ6WTVTRXI4VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1762101543);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('WKt0fPYPvTjh0EJIKGNFlDDanCQJJjUsAbZEo6Ir', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTU5jUnRKeEJwT0tKSDY2WGxPM2NQdFViMnpGU0tFZTBlTlBQQk5oZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXNoLWNvbnRyb2wiO319', 1762101477);

-- Estructura de la tabla `stock_movements`
DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('in','out','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_id_foreign` (`product_id`),
  KEY `stock_movements_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `stock_movements`
INSERT INTO `stock_movements` (`id`, `product_id`, `type`, `quantity`, `reason`, `user_id`, `reference`, `created_at`, `updated_at`) VALUES (1, 3, 'in', 100, 'Ajuste Test', 4, NULL, '2025-10-30 20:52:27', '2025-10-30 20:52:27');
INSERT INTO `stock_movements` (`id`, `product_id`, `type`, `quantity`, `reason`, `user_id`, `reference`, `created_at`, `updated_at`) VALUES (2, 1, 'in', 100, 'Ajuste Test', 4, NULL, '2025-10-30 20:52:38', '2025-10-30 20:52:38');
INSERT INTO `stock_movements` (`id`, `product_id`, `type`, `quantity`, `reason`, `user_id`, `reference`, `created_at`, `updated_at`) VALUES (3, 4, 'in', 100, 'Ajuste Test', 4, NULL, '2025-10-30 20:52:50', '2025-10-30 20:52:50');
INSERT INTO `stock_movements` (`id`, `product_id`, `type`, `quantity`, `reason`, `user_id`, `reference`, `created_at`, `updated_at`) VALUES (4, 2, 'in', 100, 'Ajuste Test', 4, NULL, '2025-10-30 20:53:02', '2025-10-30 20:53:02');

-- Estructura de la tabla `suppliers`
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `tax_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `suppliers`
INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `tax_id`, `notes`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 'Pepsico S.A de C.V.', 'Juan Perez', 9933778178, 'test@example.com', NULL, 'bkaspmdpasñ', 'fasdasdfasadasd', 1, NULL, '2025-10-26 15:27:03', '2025-10-26 15:27:03');
INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `tax_id`, `notes`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES (2, 'Sabritas S.A de C.V.', 'Alan Brito', 9932563285, 'thelionblack92@gmail.com', 'Por su casa', 'olskidmnf', 'Prueba', 1, NULL, '2025-10-26 15:47:36', '2025-10-26 15:47:36');
INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `tax_id`, `notes`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES (3, 'BELLEZA S.A de C.V.', 'Armando Torres', 9936458267, 'test@example.com', 'A lado de su vecino', 'lsofpfkfnmfka', 'Prueba', 1, NULL, '2025-10-26 15:48:32', '2025-10-26 15:48:32');

-- Estructura de la tabla `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','supervisor','empleado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'empleado',
  `permissions` json DEFAULT NULL,
  `commission_percentage` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=4096 ROW_FORMAT=DYNAMIC;

-- Datos de la tabla `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `role`, `permissions`, `commission_percentage`, `deleted_at`) VALUES (1, 'Administrador', 'admin@ebc.com', '2025-10-26 15:05:19', '$2y$12$tVdvd3v8GkQ0XiSwpL9lveshWciexkCtCn.5KaHYDbscKMELx64PK', NULL, NULL, '2025-10-26 15:05:19', '2025-10-26 15:45:26', 'admin', NULL, 0.0000, '2025-10-26 15:45:26');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `role`, `permissions`, `commission_percentage`, `deleted_at`) VALUES (2, 'Supervisor EBC', 'supervisor@ebc.com', '2025-10-26 15:05:19', '$2y$12$rDifIYGYQRhKg52rPaAbNOnwJSVaJ1zmXx84k7RDvrNCG3Pp3VYmG', NULL, '0YOtdlR54uVieLwzHdNza832zRztjFaE4steecvNhlnFhMJ76vzsdw6kBFw6', '2025-10-26 15:05:19', '2025-11-01 17:05:40', 'supervisor', '[\"products.view\", \"products.create\", \"products.edit\", \"products.delete\", \"categories.view\", \"categories.create\", \"categories.edit\", \"categories.delete\", \"suppliers.view\", \"suppliers.create\", \"suppliers.edit\", \"suppliers.delete\", \"pos.access\", \"sales_history.view\", \"sales_history.edit\", \"sales_history.cancel\", \"sales_history.delete\", \"cash_control.access\", \"stock_management.access\", \"user_management.view\", \"user_management.create\", \"user_management.edit\", \"clients.view\", \"clients.create\", \"clients.edit\", \"clients.delete\", \"services.view\", \"services.create\", \"services.edit\", \"services.delete\", \"coupons.view\", \"coupons.create\", \"coupons.edit\", \"coupons.delete\"]', 0.0000, NULL);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `role`, `permissions`, `commission_percentage`, `deleted_at`) VALUES (3, 'Empleado EBC', 'empleado@ebc.com', '2025-10-26 15:05:19', '$2y$12$VfPomXm2taK8r7d2InSGPeRHr6DVQdtJLIvAmO7cGi/RmBeDJ5LDG', NULL, 'yL57Hj9YGweq2F665C2oF5VsMDG9RsUzKOFLqeWXp4DsqrMUetFz2FuXchlY', '2025-10-26 15:05:19', '2025-11-01 17:39:11', 'empleado', '[\"products.view\", \"products.create\", \"categories.view\", \"categories.create\", \"suppliers.view\", \"suppliers.create\", \"pos.access\", \"cash_control.access\", \"user_management.view\", \"clients.view\", \"services.view\", \"coupons.view\"]', 0.0000, NULL);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `created_at`, `updated_at`, `role`, `permissions`, `commission_percentage`, `deleted_at`) VALUES (4, 'Eliel Velazquez', 'lsc.eliel.velazquez@gmail.com', NULL, '$2y$12$6WBDYrXoUQjRAqp.mN45XeVvib2GhMYOWCQUHQZz.0jFnwoPSRl2O', NULL, NULL, '2025-10-26 15:09:20', '2025-11-02 10:36:17', 'admin', '[\"products.view\", \"products.create\", \"products.edit\", \"products.delete\", \"categories.view\", \"categories.create\", \"categories.edit\", \"categories.delete\", \"suppliers.view\", \"suppliers.create\", \"suppliers.edit\", \"suppliers.delete\", \"pos.access\", \"sales_history.view\", \"sales_history.edit\", \"sales_history.cancel\", \"sales_history.delete\", \"cash_control.access\", \"stock_management.access\", \"user_management.view\", \"user_management.create\", \"user_management.edit\", \"user_management.delete\", \"database.access\", \"clients.view\", \"clients.create\", \"clients.edit\", \"clients.delete\", \"services.view\", \"services.create\", \"services.edit\", \"services.delete\", \"coupons.view\", \"coupons.create\", \"coupons.edit\", \"coupons.delete\"]', 0.0000, NULL);


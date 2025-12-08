-- Backup creado por Laravel Database Manager
-- Fecha: 2025-10-26 16:40:18

-- Estructura de la tabla `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de la tabla `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_counts_folio_unique` (`folio`),
  KEY `cash_counts_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `cash_counts_folio_index` (`folio`),
  CONSTRAINT `cash_counts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `cash_counts`
INSERT INTO `cash_counts` (`id`, `folio`, `user_id`, `start_date`, `end_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `created_at`, `updated_at`) VALUES (1, 'EBC-ARQ-2025-10-26-001', 4, '2025-10-26 00:00:00', '2025-10-26 15:57:07', 4, 1995.00, 35.00, 500.00, 0.00, 35.00, 20.00, -15.00, NULL, 'completed', '2025-10-26 15:57:07', '2025-10-26 15:57:07');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_cuts_folio_unique` (`folio`),
  KEY `cash_cuts_closed_by_foreign` (`closed_by`),
  KEY `cash_cuts_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `cash_cuts_folio_index` (`folio`),
  KEY `cash_cuts_status_index` (`status`),
  CONSTRAINT `cash_cuts_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_cuts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `cash_cuts`
INSERT INTO `cash_cuts` (`id`, `folio`, `user_id`, `cut_date`, `total_sales`, `total_amount`, `cash_amount`, `card_amount`, `transfer_amount`, `expected_cash`, `actual_cash`, `difference`, `notes`, `status`, `secret_code`, `closed_at`, `closed_by`, `created_at`, `updated_at`) VALUES (1, 'EBC-CRTE-2025-10-26-001', 4, '2025-10-26 15:58:08', 3, 905.00, 35.00, 500.00, 0.00, 35.00, 35.00, 0.00, NULL, 'closed', 'EBCFCADMIN', '2025-10-26 15:58:20', 4, '2025-10-26 15:58:08', '2025-10-26 15:58:20');

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
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `status` enum('active','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_sessions_user_id_foreign` (`user_id`),
  CONSTRAINT `cash_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `categories`
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `is_active`) VALUES (1, 'Bebibles', '2025-10-26 15:25:32', '2025-10-26 15:25:32', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `clients`
INSERT INTO `clients` (`id`, `name`, `first_name`, `paternal_lastname`, `maternal_lastname`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`, `eight_digit_barcode`, `deleted_at`) VALUES (1, 'Eunice', 'Eunice', 'Velazquez', 'Viramontes', 9935180334, 'thelionblack92@gmail.com', NULL, NULL, '2025-10-26 15:28:36', '2025-10-26 15:28:36', 72682482, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de la tabla `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30, '2025_10_26_162527_add_voucher_tracking_to_sales_table', 2);

-- Estructura de la tabla `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  UNIQUE KEY `products_sku_unique` (`sku`),
  UNIQUE KEY `products_product_id_unique` (`product_id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `products`
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (1, 'EBC-PRDTO-001', 'Colágeno (360gr)', 05157494, NULL, 50.00, 30.00, 4, NULL, '2025-10-26 15:29:46', '2025-10-26 15:57:29', 3, 3, 'piezas', NULL);
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (2, 'EBC-PRDTO-002', 'Sabritas Original (42 gr)', 7500478043927, NULL, 15.00, 10.00, 6, 'products/rl7pBGJd4ws4Jmv5L50PbbtDVzYxwhMJX37ypbTp.webp', '2025-10-26 15:49:18', '2025-10-26 15:57:29', 2, 2, 'piezas', NULL);
INSERT INTO `products` (`id`, `product_id`, `name`, `sku`, `description`, `sell_price`, `cost_price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`, `supplier_id`, `presentation`, `deleted_at`) VALUES (3, 'EBC-PRDTO-003', 'Coca Cola (600 ml)', 75007614, NULL, 20.00, 12.00, 47, 'products/qV4Qz0SLwshtzjsJ6mG5Hz3gOzZQkPgrJp0fK7zy.webp', '2025-10-26 15:49:57', '2025-10-26 15:57:29', 1, 1, 'piezas', NULL);

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
  KEY `sale_details_sale_id_foreign` (`sale_id`),
  KEY `sale_details_stylist_id_foreign` (`stylist_id`),
  KEY `sale_details_item_type_item_id_index` (`item_type`,`item_id`),
  CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_details_stylist_id_foreign` FOREIGN KEY (`stylist_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `sale_details`
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 1, 'product', 2, 15.00, 1, NULL, 0.00, '2025-10-26 15:51:49', '2025-10-26 15:51:49', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 1, 'product', 3, 20.00, 1, NULL, 0.00, '2025-10-26 15:51:49', '2025-10-26 15:51:49', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 2, 'product', 1, 50.00, 10, NULL, 0.00, '2025-10-26 15:52:21', '2025-10-26 15:52:21', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 3, 'product', 1, 50.00, 6, NULL, 0.00, '2025-10-26 15:53:03', '2025-10-26 15:53:03', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 3, 'product', 2, 15.00, 2, NULL, 0.00, '2025-10-26 15:53:03', '2025-10-26 15:53:03', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 3, 'product', 3, 20.00, 2, NULL, 0.00, '2025-10-26 15:53:03', '2025-10-26 15:53:03', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, 4, 'product', 1, 50.00, 4, NULL, 0.00, '2025-10-26 15:53:53', '2025-10-26 15:53:53', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, 4, 'product', 2, 15.00, 6, NULL, 0.00, '2025-10-26 15:53:53', '2025-10-26 15:53:53', NULL);
INSERT INTO `sale_details` (`id`, `sale_id`, `item_type`, `item_id`, `price`, `quantity`, `stylist_id`, `commission_paid`, `created_at`, `updated_at`, `deleted_at`) VALUES (9, 4, 'product', 3, 20.00, 40, NULL, 0.00, '2025-10-26 15:53:53', '2025-10-26 15:53:53', NULL);

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
  `voucher_folio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_count` int NOT NULL DEFAULT '0',
  `voucher_folios` text COLLATE utf8mb4_unicode_ci,
  `card_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('completada','pendiente','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by_id` bigint unsigned DEFAULT NULL,
  `deletion_reason` text COLLATE utf8mb4_unicode_ci,
  `cash_session_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_folio_unique` (`folio`),
  KEY `sales_client_id_foreign` (`client_id`),
  KEY `sales_user_id_foreign` (`user_id`),
  KEY `sales_payment_method_voucher_folio_index` (`payment_method`,`voucher_folio`),
  KEY `sales_deleted_by_type_deleted_by_id_index` (`deleted_by_type`,`deleted_by_id`),
  KEY `sales_cash_session_id_foreign` (`cash_session_id`),
  CONSTRAINT `sales_cash_session_id_foreign` FOREIGN KEY (`cash_session_id`) REFERENCES `cash_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `sales`
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `voucher_folio`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (1, 'EBC-VNTA-001', NULL, 4, 35.00, 0.00, 35.00, NULL, 'efectivo', NULL, 0, NULL, 0.00, 35.00, 'completada', '2025-10-26 15:51:49', '2025-10-26 15:51:49', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `voucher_folio`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (2, 'EBC-VNTA-002', NULL, 4, 500.00, 0.00, 500.00, NULL, 'tarjeta', 15224, 0, NULL, 500.00, 0.00, 'completada', '2025-10-26 15:52:21', '2025-10-26 15:52:21', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `voucher_folio`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (3, 'EBC-VNTA-003', NULL, 4, 370.00, 0.00, 370.00, NULL, 'mixto', 15224, 0, NULL, 320.00, 50.00, 'completada', '2025-10-26 15:53:03', '2025-10-26 15:53:03', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` (`id`, `folio`, `client_id`, `user_id`, `subtotal`, `discount_amount`, `total_amount`, `discount_coupon`, `payment_method`, `voucher_folio`, `voucher_count`, `voucher_folios`, `card_amount`, `cash_amount`, `status`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_type`, `deleted_by_id`, `deletion_reason`, `cash_session_id`) VALUES (4, 'EBC-VNTA-004', 1, 4, 1090.00, 0.00, 1090.00, NULL, 'mixto', 85546165, 0, NULL, 862.00, 228.00, 'cancelada', '2025-10-26 15:53:53', '2025-10-26 16:02:21', NULL, NULL, NULL, NULL, NULL);

-- Estructura de la tabla `services`
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `duration_minutes` int NOT NULL DEFAULT '30',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('sMqQrMEwKK9ZKn9uvEheRKF5RbjqMXHnFlDFqdQu', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWZuU2dpRFBCS1l1WDNOVXZPQlVFSG9uSVNBOHVFWnJQWFphcENISiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXRhYmFzZS9iYWNrdXAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1761518391);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('vowYyLPeoRprcZhKV23s0wNZEUVlUJuB9sbnJ39O', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDlJeWt3T2dzUXJHUnRsMm5oQ2cycVZVNkV1UXFFOTAyYkhRTkhINyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761518199);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','supervisor','empleado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'empleado',
  `commission_percentage` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de la tabla `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `commission_percentage`, `deleted_at`) VALUES (1, 'Administrador', 'admin@ebc.com', '2025-10-26 15:05:19', '$2y$12$tVdvd3v8GkQ0XiSwpL9lveshWciexkCtCn.5KaHYDbscKMELx64PK', NULL, '2025-10-26 15:05:19', '2025-10-26 15:45:26', 'admin', 0.0000, '2025-10-26 15:45:26');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `commission_percentage`, `deleted_at`) VALUES (2, 'Supervisor EBC', 'supervisor@ebc.com', '2025-10-26 15:05:19', '$2y$12$EBUdkHuNE3Ooa6f0X8a3ReQshptrTUI.CiVfYTBRR9CURAfDj35Vm', NULL, '2025-10-26 15:05:19', '2025-10-26 15:05:19', 'supervisor', 5.0000, NULL);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `commission_percentage`, `deleted_at`) VALUES (3, 'Empleado EBC', 'empleado@ebc.com', '2025-10-26 15:05:19', '$2y$12$U3jdvQ3kA6SMOINMNX7g2u9BwF0WHnz60nWahUoEI8eugwEy/pRw6', NULL, '2025-10-26 15:05:19', '2025-10-26 15:05:19', 'empleado', 9.9999, NULL);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `commission_percentage`, `deleted_at`) VALUES (4, 'Eliel Velazquez', 'lsc.eliel.velazquez@gmail.com', NULL, '$2y$12$6WBDYrXoUQjRAqp.mN45XeVvib2GhMYOWCQUHQZz.0jFnwoPSRl2O', NULL, '2025-10-26 15:09:20', '2025-10-26 15:09:20', 'admin', 0.0000, NULL);


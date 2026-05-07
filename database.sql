CREATE DATABASE IF NOT EXISTS egg_store;
USE egg_store;

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(30) DEFAULT NULL,
    `status` varchar(255) DEFAULT NULL,
    `status_message` varchar(255) DEFAULT NULL,
    `active` tinyint(1) NOT NULL DEFAULT 0,
    `last_active` datetime DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `deleted_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_identities` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `type` varchar(255) NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    `secret` varchar(255) NOT NULL,
    `secret2` varchar(255) DEFAULT NULL,
    `expires` datetime DEFAULT NULL,
    `extra` text,
    `force_reset` tinyint(1) NOT NULL DEFAULT 0,
    `last_used_at` datetime DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `type_secret` (`type`,`secret`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_logins` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `ip_address` varchar(255) NOT NULL,
    `user_agent` varchar(255) DEFAULT NULL,
    `id_type` varchar(255) NOT NULL,
    `identifier` varchar(255) NOT NULL,
    `user_id` int(11) unsigned DEFAULT NULL,
    `date` datetime NOT NULL,
    `success` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `id_type_identifier` (`id_type`,`identifier`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_token_logins` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `ip_address` varchar(255) NOT NULL,
    `user_agent` varchar(255) DEFAULT NULL,
    `id_type` varchar(255) NOT NULL,
    `identifier` varchar(255) NOT NULL,
    `user_id` int(11) unsigned DEFAULT NULL,
    `date` datetime NOT NULL,
    `success` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `id_type_identifier` (`id_type`,`identifier`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_remember_tokens` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `selector` varchar(255) NOT NULL,
    `hashedValidator` varchar(255) NOT NULL,
    `user_id` int(11) unsigned NOT NULL,
    `expires` datetime NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `selector` (`selector`),
    KEY `auth_remember_tokens_user_id_foreign` (`user_id`),
    CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_groups_users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `group` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `auth_groups_users_user_id_foreign` (`user_id`),
    CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_permissions_users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `permission` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `auth_permissions_users_user_id_foreign` (`user_id`),
    CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `settings` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `class` varchar(255) NOT NULL,
    `key` varchar(255) NOT NULL,
    `value` text DEFAULT NULL,
    `type` varchar(31) NOT NULL DEFAULT 'string',
    `context` varchar(255) DEFAULT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Egg Store Administrative Workflow Tables

-- 1. Egg Types (Small, Medium, Large, Organic, etc.)
CREATE TABLE IF NOT EXISTS `egg_types` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text,
    `low_stock_threshold` int(11) NOT NULL DEFAULT 100,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Stock Batches (Stock Intake)
CREATE TABLE IF NOT EXISTS `stock_batches` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `batch_id` varchar(50) NOT NULL, -- Supplier Batch ID
    `egg_type_id` int(11) unsigned NOT NULL,
    `quantity_added` int(11) NOT NULL,
    `quantity_remaining` int(11) NOT NULL,
    `laid_date` date NOT NULL,
    `expiry_date` date NOT NULL,
    `supplier_name` varchar(255),
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `batch_id` (`batch_id`),
    KEY `egg_type_id` (`egg_type_id`),
    CONSTRAINT `stock_batches_egg_type_id_foreign` FOREIGN KEY (`egg_type_id`) REFERENCES `egg_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Orders (Order Fulfillment)
CREATE TABLE IF NOT EXISTS `orders` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `total_amount` decimal(10,2) NOT NULL,
    `status` enum('Pending', 'Approved', 'Out for Delivery', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Order Items
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `order_id` int(11) unsigned NOT NULL,
    `egg_type_id` int(11) unsigned NOT NULL,
    `quantity` int(11) NOT NULL,
    `price_at_order` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `order_id` (`order_id`),
    KEY `egg_type_id` (`egg_type_id`),
    CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `order_items_egg_type_id_foreign` FOREIGN KEY (`egg_type_id`) REFERENCES `egg_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5. Losses (Reconciliation: Breakage or Expiration)
CREATE TABLE IF NOT EXISTS `inventory_losses` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `stock_batch_id` int(11) unsigned NOT NULL,
    `quantity_lost` int(11) NOT NULL,
    `reason` enum('Breakage', 'Expiration', 'Other') NOT NULL,
    `notes` text,
    `created_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `stock_batch_id` (`stock_batch_id`),
    CONSTRAINT `inventory_losses_stock_batch_id_foreign` FOREIGN KEY (`stock_batch_id`) REFERENCES `stock_batches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Seed initial egg types
INSERT INTO `egg_types` (`name`, `description`, `low_stock_threshold`, `created_at`, `updated_at`) VALUES
('Small', 'Small size eggs, approx 45g-53g', 100, NOW(), NOW()),
('Medium', 'Medium size eggs, approx 53g-63g', 150, NOW(), NOW()),
('Large', 'Large size eggs, approx 63g-73g', 200, NOW(), NOW()),
('Organic', 'Free-range organic eggs', 50, NOW(), NOW());


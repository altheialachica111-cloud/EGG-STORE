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

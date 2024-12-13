-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 13 déc. 2024 à 17:15
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dirila_gj`
--

-- --------------------------------------------------------

--
-- Structure de la table `GJ_cache`
--

CREATE TABLE `GJ_cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_cache_locks`
--

CREATE TABLE `GJ_cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_collection_games`
--

CREATE TABLE `GJ_collection_games` (
  `game_id` int(11) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` float DEFAULT NULL,
  `comment` varchar(300) DEFAULT NULL,
  `progress_id` int(11) NOT NULL DEFAULT 4,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `GJ_collection_games`
--
DELIMITER $$
CREATE TRIGGER `TGR_delete_game` AFTER DELETE ON `GJ_collection_games` FOR EACH ROW BEGIN
	CALL update_game_owned_by(old.game_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TGR_insert_game` AFTER INSERT ON `GJ_collection_games` FOR EACH ROW BEGIN
	CALL update_game_owned_by(new.game_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TGR_update_game` AFTER UPDATE ON `GJ_collection_games` FOR EACH ROW BEGIN
	CALL update_rating(new.game_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_collection_supports`
--

CREATE TABLE `GJ_collection_supports` (
  `support_id` int(11) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `GJ_collection_supports`
--
DELIMITER $$
CREATE TRIGGER `TGR_delete_support` AFTER DELETE ON `GJ_collection_supports` FOR EACH ROW BEGIN
	CALL update_support_owned_by(old.support_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TGR_insert_support` AFTER INSERT ON `GJ_collection_supports` FOR EACH ROW BEGIN
	CALL update_support_owned_by(new.support_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_failed_jobs`
--

CREATE TABLE `GJ_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_games`
--

CREATE TABLE `GJ_games` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(70) NOT NULL,
  `game_desc` varchar(500) NOT NULL,
  `game_year` year(4) NOT NULL,
  `game_cover` varchar(300) NOT NULL,
  `owned_by` int(11) NOT NULL DEFAULT 0,
  `rating` float DEFAULT NULL,
  `support_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_game_genres`
--

CREATE TABLE `GJ_game_genres` (
  `game_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_genres`
--

CREATE TABLE `GJ_genres` (
  `genre_id` int(11) NOT NULL,
  `genre_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_jobs`
--

CREATE TABLE `GJ_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_job_batches`
--

CREATE TABLE `GJ_job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_migrations`
--

CREATE TABLE `GJ_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_password_reset_tokens`
--

CREATE TABLE `GJ_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_progressions`
--

CREATE TABLE `GJ_progressions` (
  `progress_id` int(11) NOT NULL,
  `progress_label` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_requests`
--

CREATE TABLE `GJ_requests` (
  `request_id` int(11) NOT NULL,
  `request_motif` varchar(300) DEFAULT NULL,
  `request_nom` varchar(70) NOT NULL,
  `request_desc` varchar(500) NOT NULL,
  `request_year` year(4) NOT NULL,
  `request_cover` varchar(300) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_id` int(11) NOT NULL,
  `valide_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_roles`
--

CREATE TABLE `GJ_roles` (
  `role_code` char(1) NOT NULL,
  `role_label` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_sessions`
--

CREATE TABLE `GJ_sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_status`
--

CREATE TABLE `GJ_status` (
  `status_id` int(11) NOT NULL,
  `status_label` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_supports`
--

CREATE TABLE `GJ_supports` (
  `support_id` int(11) NOT NULL,
  `support_name` varchar(70) NOT NULL,
  `support_desc` varchar(300) DEFAULT NULL,
  `support_year` year(4) NOT NULL,
  `support_pic` varchar(200) DEFAULT NULL,
  `support_logo` varchar(200) DEFAULT NULL,
  `owned_by` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_users`
--

CREATE TABLE `GJ_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `visibilite` tinyint(1) NOT NULL DEFAULT 1,
  `can_contribute` tinyint(1) NOT NULL DEFAULT 1,
  `code` char(1) NOT NULL DEFAULT 'U',
  `comment` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `GJ_cache`
--
ALTER TABLE `GJ_cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `GJ_cache_locks`
--
ALTER TABLE `GJ_cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `GJ_collection_games`
--
ALTER TABLE `GJ_collection_games`
  ADD PRIMARY KEY (`game_id`,`id`),
  ADD KEY `GJ_collection_GJ_users_FK` (`id`),
  ADD KEY `GJ_collection_GJ_progression_FK` (`progress_id`);

--
-- Index pour la table `GJ_collection_supports`
--
ALTER TABLE `GJ_collection_supports`
  ADD PRIMARY KEY (`support_id`,`id`),
  ADD KEY `Collection_Supports_GJ_users_FK` (`id`) USING BTREE;

--
-- Index pour la table `GJ_failed_jobs`
--
ALTER TABLE `GJ_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gj_failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `GJ_games`
--
ALTER TABLE `GJ_games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `GJ_games_GJ_supports_FK` (`support_id`) USING BTREE;

--
-- Index pour la table `GJ_game_genres`
--
ALTER TABLE `GJ_game_genres`
  ADD PRIMARY KEY (`game_id`,`genre_id`),
  ADD KEY `GJ_game_genres_GJ_genres_FK` (`genre_id`) USING BTREE;

--
-- Index pour la table `GJ_genres`
--
ALTER TABLE `GJ_genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Index pour la table `GJ_jobs`
--
ALTER TABLE `GJ_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gj_jobs_queue_index` (`queue`);

--
-- Index pour la table `GJ_job_batches`
--
ALTER TABLE `GJ_job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `GJ_migrations`
--
ALTER TABLE `GJ_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `GJ_password_reset_tokens`
--
ALTER TABLE `GJ_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `GJ_progressions`
--
ALTER TABLE `GJ_progressions`
  ADD PRIMARY KEY (`progress_id`);

--
-- Index pour la table `GJ_requests`
--
ALTER TABLE `GJ_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `GJ_requests_GJ_users_FK` (`id`) USING BTREE,
  ADD KEY `GJ_requests_GJ_status_FK` (`status_id`) USING BTREE,
  ADD KEY `GJ_requests_GJ_users_valide_FK` (`valide_id`) USING BTREE;

--
-- Index pour la table `GJ_roles`
--
ALTER TABLE `GJ_roles`
  ADD PRIMARY KEY (`role_code`);

--
-- Index pour la table `GJ_sessions`
--
ALTER TABLE `GJ_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gj_sessions_user_id_index` (`user_id`),
  ADD KEY `gj_sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `GJ_status`
--
ALTER TABLE `GJ_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Index pour la table `GJ_supports`
--
ALTER TABLE `GJ_supports`
  ADD PRIMARY KEY (`support_id`);

--
-- Index pour la table `GJ_users`
--
ALTER TABLE `GJ_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `GJ_users_GJ_roles_FK` (`code`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `GJ_failed_jobs`
--
ALTER TABLE `GJ_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_games`
--
ALTER TABLE `GJ_games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_genres`
--
ALTER TABLE `GJ_genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_jobs`
--
ALTER TABLE `GJ_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_migrations`
--
ALTER TABLE `GJ_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_progressions`
--
ALTER TABLE `GJ_progressions`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_requests`
--
ALTER TABLE `GJ_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_status`
--
ALTER TABLE `GJ_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_supports`
--
ALTER TABLE `GJ_supports`
  MODIFY `support_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_users`
--
ALTER TABLE `GJ_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `GJ_collection_games`
--
ALTER TABLE `GJ_collection_games`
  ADD CONSTRAINT `GJ_collection_GJ_jeux_FK` FOREIGN KEY (`game_id`) REFERENCES `GJ_games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GJ_collection_GJ_progression_FK` FOREIGN KEY (`progress_id`) REFERENCES `GJ_progressions` (`progress_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GJ_collection_GJ_users_FK` FOREIGN KEY (`id`) REFERENCES `GJ_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GJ_collection_supports`
--
ALTER TABLE `GJ_collection_supports`
  ADD CONSTRAINT `POSSEDE_SUPPORTS_GJ_supports_FK` FOREIGN KEY (`support_id`) REFERENCES `GJ_supports` (`support_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `POSSEDE_SUPPORTS_GJ_users_FK` FOREIGN KEY (`id`) REFERENCES `GJ_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GJ_games`
--
ALTER TABLE `GJ_games`
  ADD CONSTRAINT `GJ_jeux_GJ_supports_FK` FOREIGN KEY (`support_id`) REFERENCES `GJ_supports` (`support_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GJ_game_genres`
--
ALTER TABLE `GJ_game_genres`
  ADD CONSTRAINT `APPARTIENT_GJ_genres_FK` FOREIGN KEY (`genre_id`) REFERENCES `GJ_genres` (`genre_id`),
  ADD CONSTRAINT `APPARTIENT_GJ_jeux_FK` FOREIGN KEY (`game_id`) REFERENCES `GJ_games` (`game_id`);

--
-- Contraintes pour la table `GJ_requests`
--
ALTER TABLE `GJ_requests`
  ADD CONSTRAINT `GJ_requetes_GJ_statut_FK` FOREIGN KEY (`status_id`) REFERENCES `GJ_status` (`status_id`),
  ADD CONSTRAINT `GJ_requetes_GJ_users_FK` FOREIGN KEY (`id`) REFERENCES `GJ_users` (`id`),
  ADD CONSTRAINT `GJ_requetes_GJ_users_valide_FK` FOREIGN KEY (`valide_id`) REFERENCES `GJ_users` (`id`);

--
-- Contraintes pour la table `GJ_users`
--
ALTER TABLE `GJ_users`
  ADD CONSTRAINT `GJ_users_GJ_roles_FK` FOREIGN KEY (`code`) REFERENCES `GJ_roles` (`role_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 31 jan. 2025 à 14:36
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

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`dirila`@`%` PROCEDURE `update_game_owned_by` (IN `id` INT)   BEGIN

UPDATE GJ_games SET owned_by = (SELECT COUNT(game_id)
                                FROM GJ_collection_games
                                WHERE game_id = id)
WHERE game_id = id;

END$$

CREATE DEFINER=`dirila`@`%` PROCEDURE `update_rating` (`id` INT)   BEGIN
	UPDATE GJ_games SET rating = (
        (SELECT SUM(note) FROM GJ_collection_games
         WHERE game_id = id)
        / (SELECT COUNT(game_id) FROM GJ_collection_games WHERE game_id = id))
    WHERE game_id = id;
END$$

CREATE DEFINER=`dirila`@`%` PROCEDURE `update_support_owned_by` (IN `id` INT)   BEGIN

UPDATE GJ_supports SET owned_by = (SELECT COUNT(support_id)
                                FROM GJ_collection_supports
                                WHERE support_id = id)
WHERE support_id = id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `GJ_cache`
--

CREATE TABLE `GJ_cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `GJ_cache`
--

INSERT INTO `GJ_cache` (`key`, `value`, `expiration`) VALUES
('bastien.lefevre@example.com|127.0.0.1', 'i:2;', 1733466717),
('bastien.lefevre@example.com|127.0.0.1:timer', 'i:1733466716;', 1733466717);

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
  `added_at` timestamp NULL DEFAULT current_timestamp(),
  `owned` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `GJ_collection_games`
--

INSERT INTO `GJ_collection_games` (`game_id`, `id`, `note`, `comment`, `progress_id`, `added_at`, `owned`) VALUES
(1, 3, 8, NULL, 4, '2024-11-26 17:23:17', 1),
(2, 5, 9.5, NULL, 4, '2024-11-26 17:23:17', 1),
(3, 7, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(4, 2, 6, NULL, 4, '2024-11-26 17:23:17', 1),
(5, 6, 7.5, NULL, 4, '2024-11-26 17:23:17', 1),
(10, 1, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(14, 15, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(14, 22, NULL, NULL, 4, '2024-12-16 14:43:57', 1),
(15, 9, 8.5, NULL, 4, '2024-11-26 17:23:17', 1),
(20, 12, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(25, 14, 7, NULL, 4, '2024-11-26 17:23:17', 1),
(30, 9, 8, NULL, 4, '2024-12-04 15:32:49', 1),
(30, 18, NULL, NULL, 4, '2024-12-04 16:07:41', 1),
(55, 20, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(56, 29, NULL, NULL, 4, '2024-12-16 15:34:39', 1),
(60, 4, 7, NULL, 4, '2024-11-26 17:23:17', 1),
(61, 21, NULL, NULL, 4, '2024-11-26 17:23:17', 1),
(77, 4, 5, NULL, 4, '2024-12-06 10:45:18', 1);

--
-- Déclencheurs `GJ_collection_games`
--
DELIMITER $$
CREATE TRIGGER `TGR_delete_game` AFTER DELETE ON `GJ_collection_games` FOR EACH ROW BEGIN
UPDATE GJ_games SET owned_by = owned_by - 1
WHERE game_id = old.game_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TGR_insert_game` AFTER INSERT ON `GJ_collection_games` FOR EACH ROW BEGIN
UPDATE GJ_games SET owned_by = owned_by  + 1
WHERE game_id = new.game_id;
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
-- Déchargement des données de la table `GJ_collection_supports`
--

INSERT INTO `GJ_collection_supports` (`support_id`, `id`, `comment`, `added_at`) VALUES
(15, 1, NULL, '2024-11-26 17:22:49'),
(15, 7, NULL, '2024-11-26 17:22:49'),
(16, 1, NULL, '2024-11-26 17:22:49'),
(16, 8, NULL, '2024-11-26 17:22:49'),
(17, 2, NULL, '2024-11-26 17:22:49'),
(17, 7, NULL, '2024-11-26 17:22:49'),
(17, 10, NULL, '2024-11-26 17:22:49'),
(18, 2, NULL, '2024-11-26 17:22:49'),
(18, 4, NULL, '2024-11-26 17:22:49'),
(18, 10, NULL, '2024-11-26 17:22:49'),
(19, 1, NULL, '2024-11-26 17:22:49'),
(19, 4, NULL, '2024-11-26 17:22:49'),
(19, 9, NULL, '2024-11-26 17:22:49'),
(20, 2, NULL, '2024-11-26 17:22:49'),
(20, 8, NULL, '2024-11-26 17:22:49'),
(20, 9, NULL, '2024-11-26 17:22:49'),
(21, 5, NULL, '2024-11-26 17:22:49'),
(21, 7, NULL, '2024-11-26 17:22:49'),
(22, 3, NULL, '2024-11-26 17:22:49'),
(22, 5, NULL, '2024-11-26 17:22:49'),
(22, 8, NULL, '2024-11-26 17:22:49'),
(23, 3, NULL, '2024-11-26 17:22:49'),
(23, 5, NULL, '2024-11-26 17:22:49'),
(23, 6, NULL, '2024-11-26 17:22:49'),
(24, 1, NULL, '2024-11-26 17:22:49'),
(24, 5, NULL, '2024-11-26 17:22:49'),
(24, 6, NULL, '2024-11-26 17:22:49'),
(25, 2, NULL, '2024-11-26 17:22:49'),
(25, 4, NULL, '2024-11-26 17:22:49'),
(25, 10, NULL, '2024-11-26 17:22:49'),
(26, 6, NULL, '2024-11-26 17:22:49'),
(28, 3, NULL, '2024-11-26 17:22:49'),
(28, 9, NULL, '2024-11-26 17:22:49');

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

--
-- Déchargement des données de la table `GJ_games`
--

INSERT INTO `GJ_games` (`game_id`, `game_name`, `game_desc`, `game_year`, `game_cover`, `owned_by`, `rating`, `support_id`) VALUES
(1, 'The Last of Us Part II', 'Jeu d\'action-aventure avec une forte composante émotionnelle, suit l\'histoire d\'Ellie dans un monde post-apocalyptique.', '2020', '/covers/thelastofuspartii.png', 0, NULL, 15),
(2, 'Halo Infinite', 'Jeu de tir à la première personne avec le légendaire Master Chief, se déroulant dans un futur lointain et un monde de science-fiction.', '2021', '/covers/haloinfinite.png', 0, NULL, 16),
(3, 'Super Mario Odyssey', 'Jeu de plateforme où Mario voyage à travers différents mondes pour sauver la princesse Peach, avec une dynamique de gameplay innovante.', '2017', '/covers/supermarioodyssey.png', 0, NULL, 17),
(4, 'Half-Life 2', 'Jeu de tir à la première personne révolutionnaire avec une narration immersive et un gameplay de physique réaliste.', '2004', '/covers/halflife2.png', 0, NULL, 18),
(5, 'Uncharted 4: A Thief\'s End', 'Jeu d\'aventure avec Nathan Drake, un chasseur de trésors qui se retrouve dans une aventure pleine de mystères et de trahisons.', '2016', '/covers/uncharted4.png', 1, NULL, 19),
(6, 'Forza Horizon 4', 'Jeu de course avec un monde ouvert dynamique et des courses sur des routes d\'Angleterre, combinant simulation et arcade.', '2018', '/covers/forzahorizon4.png', 0, 5, 20),
(7, 'The Legend of Zelda: Ocarina of Time', 'Jeu d\'aventure et d\'action dans lequel Link doit sauver le royaume d\'Hyrule en maîtrisant l\'art de la musique et du combat.', '1998', '/covers/ocarinaoftime.png', 0, NULL, 21),
(8, 'Gran Turismo 5', 'Jeu de simulation de course automobile avec des voitures réalistes et des circuits célèbres.', '2010', '/covers/granturismo5.png', 0, NULL, 22),
(9, 'Gears of War 3', 'Jeu de tir à la troisième personne, le dernier volet de la trilogie où les soldats de l\'humanité affrontent des hordes de créatures monstrueuses.', '2011', '/covers/gears3.png', 0, NULL, 23),
(10, 'Super Mario Bros.', 'Le jeu de plateforme classique de Nintendo, où Mario et Luigi doivent sauver la princesse Peach du méchant Bowser.', '1985', '/covers/supermariobros.png', 0, NULL, 24),
(11, 'Sonic the Hedgehog', 'Le jeu de plateforme emblématique de Sega, avec Sonic le hérisson qui court à toute vitesse pour sauver le monde de Dr. Robotnik.', '1991', '/covers/sonicthehedgehog.png', 0, NULL, 25),
(12, 'Super Mario World', 'Un jeu de plateforme où Mario explore des mondes fantastiques pour sauver la princesse Toadstool et ses amis.', '1990', '/covers/supermarioworld.png', 0, NULL, 26),
(13, 'Pokémon Red and Blue', 'Jeu de rôle où le joueur capture des créatures appelées Pokémon et les entraîne pour devenir le meilleur dresseur.', '1996', '/covers/pokemonredblue.png', 0, NULL, 27),
(14, 'Alex Kidd in Miracle World', 'Un jeu de plateforme où Alex Kidd, un héros de Sega, part sauver le royaume en affrontant des ennemis et résolvant des énigmes.', '1986', '/covers/alexkidd.png', 2, NULL, 28),
(15, 'Cyberpunk 2077', 'Jeu de rôle et d\'action en monde ouvert dans un futur dystopique où le joueur incarne un mercenaire dans la ville de Night City.', '2020', '/covers/cyberpunk2077.png', 1, 7, 15),
(16, 'Hitman 3', 'Jeu d\'action et de furtivité où le joueur incarne un tueur à gages dans diverses missions autour du monde.', '2021', '/covers/hitman3.png', 0, NULL, 16),
(17, 'Mario Kart 8 Deluxe', 'Jeu de course amusant avec Mario et ses amis où vous devez utiliser des objets pour dépasser vos adversaires dans des circuits colorés.', '2017', '/covers/mariokart8deluxe.png', 0, NULL, 17),
(18, 'The Witcher 3: Wild Hunt', 'Jeu de rôle où vous incarnez Geralt de Riv, un chasseur de monstres, dans un vaste monde ouvert plein de quêtes et d\'aventures.', '2015', '/covers/thewitcher3.png', 0, NULL, 18),
(19, 'Horizon Zero Dawn', 'Jeu d\'action-aventure en monde ouvert où vous incarnez Aloy, une chasseuse dans un monde post-apocalyptique peuplé de créatures mécaniques.', '2017', '/covers/horizonzerodawn.png', 0, NULL, 19),
(20, 'Red Dead Redemption', 'Jeu d\'action-aventure en monde ouvert où vous incarnez John Marston, un ancien hors-la-loi dans le Far West.', '2010', '/covers/reddeadredemption.png', 0, NULL, 20),
(21, 'Tomb Raider (2013)', 'Jeu d\'aventure et de survie où Lara Croft part à la recherche d\'une île mystérieuse, tout en faisant face à des dangers terrifiants.', '2013', '/covers/tombraider2013.png', 0, NULL, 15),
(22, 'Minecraft Dungeons', 'Jeu d\'action-RPG dans un monde inspiré de Minecraft où les joueurs explorent des donjons générés de manière procédurale.', '2020', '/covers/minecraftdungeons.png', 0, NULL, 16),
(23, 'Luigi\'s Mansion 3', 'Jeu d\'aventure où Luigi, le frère de Mario, doit sauver ses amis d\'un hôtel hanté en résolvant des énigmes et capturant des fantômes.', '2019', '/covers/luigismansion3.png', 0, NULL, 17),
(24, 'Assassin\'s Creed Odyssey', 'Jeu de rôle en monde ouvert où le joueur explore la Grèce antique pendant la guerre du Péloponnèse tout en écrivant sa propre histoire.', '2018', '/covers/assassinscreedodyssey.png', 0, NULL, 19),
(25, 'Street Fighter IV', 'Jeu de combat où des personnages emblématiques s\'affrontent dans des duels intenses, chacun avec ses techniques et combos uniques.', '2009', '/covers/streetfighteriv.png', 1, NULL, 16),
(26, 'Dead by Daylight', 'Jeu d\'horreur multijoueur asymétrique où un joueur incarne un tueur, et les autres jouent des survivants cherchant à échapper à la mort.', '2016', '/covers/deadbydaylight.png', 0, NULL, 18),
(27, 'Fallen Order', 'Jeu d\'action-aventure dans l\'univers de Star Wars où vous incarnez un Jedi luttant pour survivre après l\'Ordre 66.', '2019', '/covers/starwarsfallenorder.png', 0, NULL, 19),
(28, 'Far Cry 5', 'Jeu de tir à la première personne en monde ouvert où vous devez renverser un culte apocalyptique dans le Montana, USA.', '2018', '/covers/farcry5.png', 0, NULL, 16),
(29, 'Kingdom Hearts III', 'Jeu de rôle et d\'action où Sora, accompagné de ses compagnons, voyage à travers divers mondes Disney pour combattre les ténèbres.', '2019', '/covers/kingdomheartsiii.png', 0, NULL, 19),
(30, 'Call of Duty: Modern Warfare (2019)', 'Jeu de tir à la première personne avec une campagne narrative immersive et des modes multijoueurs très populaires.', '2019', '/covers/codmodernwarfare2019.png', 3, 4, 18),
(31, 'The Elder Scrolls V: Skyrim', 'Jeu de rôle en monde ouvert où le joueur incarne un héros dans un univers fantastique, rempli de dragons et de magie.', '2011', '/covers/skyrim.png', 0, NULL, 19),
(32, 'Unravel Two', 'Jeu de plateforme et de réflexion où deux petites créatures en fil de laine se lient d\'amitié pour résoudre des énigmes et explorer un monde magique.', '2018', '/covers/unraveltwo.png', 0, NULL, 15),
(33, 'Dying Light', 'Jeu de survie et de parkour dans un monde apocalyptique infesté de zombies, où le joueur doit utiliser ses compétences pour survivre et explorer.', '2015', '/covers/dyinglight.png', 0, NULL, 19),
(49, 'Space Invaders', 'Jeu de tir où le joueur doit défendre la Terre contre des vagues d\'envahisseurs extraterrestres.', '1978', '/covers/space_invaders.png', 0, NULL, 29),
(50, 'Pokémon Or et Argent', 'Deuxième génération de la franchise Pokémon avec des nouvelles créatures et fonctionnalités.', '1999', '/covers/pokemon_or_argent.png', 0, NULL, 30),
(51, 'Final Fantasy X', 'RPG épique suivant les aventures de Tidus dans le monde de Spira.', '2001', '/covers/final_fantasy_x.png', 0, NULL, 31),
(52, 'Metal Gear Solid: Peace Walker', 'Jeu d\'infiltration où le joueur contrôle Big Boss en Amérique latine.', '2010', '/covers/metal_gear_solid_peace_walker.png', 0, NULL, 32),
(53, 'Persona 4 Golden', 'Version améliorée du RPG acclamé par la critique, avec des personnages et fonctionnalités supplémentaires.', '2012', '/covers/persona_4_golden.png', 0, NULL, 33),
(54, 'Super Smash Bros. Melee', 'Jeu de combat réunissant de nombreux personnages emblématiques de Nintendo.', '2001', '/covers/super_smash_bros_melee.png', 0, NULL, 34),
(55, 'Halo: Combat Evolved', 'Jeu de tir révolutionnaire mettant en scène le Spartan John-117, alias Master Chief.', '2001', '/covers/halo_combat_evolved.png', 0, NULL, 35),
(56, 'New Super Mario Bros.', 'Jeu de plateforme en 2D mettant en scène Mario dans des niveaux colorés et variés.', '2006', '/covers/new_super_mario_bros.png', 1, NULL, 36),
(57, 'California Games', 'Collection de mini-jeux inspirés par les sports californiens comme le skateboard et le surf.', '1989', '/covers/california_games.png', 0, NULL, 37),
(58, 'The Last Ninja', 'Jeu d\'aventure et de combat où le joueur incarne un ninja vengeant la mort de son clan.', '1987', '/covers/the_last_ninja.png', 0, NULL, 38),
(59, 'King of Fighters \'94', 'Jeu de combat de SNK avec des équipes de trois combattants de différentes franchises.', '1994', '/covers/king_of_fighters_94.png', 0, NULL, 39),
(60, 'Nights into Dreams...', 'Jeu de plateforme en 3D où les joueurs contrôlent Nights, un personnage mystérieux dans un monde de rêves.', '1996', '/covers/nights_into_dreams.png', 0, NULL, 40),
(61, 'Sonic Adventure', 'Jeu de plateforme 3D suivant les aventures de Sonic et ses amis pour sauver le monde.', '1999', '/covers/sonic_adventure.png', 0, NULL, 41),
(62, 'Wii Sports', 'Collection de jeux de sport utilisant les capteurs de mouvement de la Wii.', '2006', '/covers/wii_sports.png', 0, NULL, 42),
(63, 'Super Mario 3D World', 'Jeu de plateforme en 3D où Mario et ses amis explorent différents mondes colorés.', '2013', '/covers/super_mario_3d_world.png', 0, NULL, 43),
(64, 'Gran Turismo 7', 'Jeu de simulation de course avec des graphismes réalistes et une variété de voitures et de circuits.', '2022', '/covers/granturismo7.png', 0, NULL, 15),
(65, 'Forza Motorsport 8', 'Jeu de simulation de course offrant une expérience de course ultra-réaliste.', '2022', '/covers/forzamotorsport8.png', 0, NULL, 16),
(66, 'The Legend of Zelda: Tears of the Kingdom', 'Suite d\'Ocarina of Time où Link part à l\'aventure dans un royaume encore plus vaste.', '2023', '/covers/zeldatearsofthekingdom.png', 0, NULL, 17),
(67, 'Half-Life Alyx', 'Jeu de réalité virtuelle dans l\'univers de Half-Life, où vous incarnez Alyx Vance pour sauver le monde.', '2020', '/covers/halflifealyx.png', 0, NULL, 18),
(68, 'The Last of Us Part I Remake', 'Remake du jeu original The Last of Us, avec des graphismes améliorés et une narration encore plus immersive.', '2022', '/covers/thelastofusremake.png', 0, NULL, 19),
(69, 'Red Dead Redemption 2', 'Jeu d\'action-aventure en monde ouvert où vous incarnez Arthur Morgan, un hors-la-loi dans l\'Ouest américain.', '2018', '/covers/reddeadredemption2.png', 0, NULL, 20),
(70, 'Metroid Dread', 'Jeu d\'action-aventure où Samus Aran explore une planète mystérieuse pour découvrir des secrets mortels.', '2021', '/covers/metroiddread.png', 0, NULL, 21),
(71, 'Gran Turismo Sport', 'Jeu de simulation de course axé sur le multijoueur en ligne et les compétitions mondiales.', '2017', '/covers/granturismosport.png', 0, NULL, 22),
(72, 'Sea of Thieves', 'Jeu d\'aventure en monde ouvert où les joueurs incarnent des pirates à la recherche de trésors et d\'aventures.', '2018', '/covers/seaofthieves.png', 0, NULL, 23),
(73, 'Super Mario World 2: Yoshi\'s Island', 'Jeu de plateforme où Yoshi doit sauver bébé Mario dans un monde coloré rempli de défis.', '1995', '/covers/yoshisisland.png', 0, NULL, 24),
(74, 'Sonic the Hedgehog 2', 'Le célèbre hérisson bleu, Sonic, se lance dans une nouvelle aventure avec son ami Tails pour sauver le monde.', '1992', '/covers/sonicthehedgehog2.png', 0, NULL, 25),
(75, 'Super Mario Kart', 'Le premier jeu de la série Mario Kart, où Mario et ses amis se livrent à des courses de karting sur des circuits colorés.', '1992', '/covers/supermariokart.png', 0, NULL, 26),
(76, 'Pokémon Gold et Silver', 'Les premiers jeux Pokémon avec une aventure inédite dans la région de Johto.', '1999', '/covers/pokemon_gold_silver.png', 0, NULL, 27),
(77, 'Altered Beast', 'Un jeu d\'action où vous incarnez un héros ressuscité pour sauver la fille de Zeus.', '1988', '/covers/alteredbeast.png', 1, 7.5, 28),
(78, 'Pitfall!', 'Jeu de plateforme où le joueur doit éviter des pièges et des animaux dangereux dans la jungle.', '1982', '/covers/pitfall.png', 0, NULL, 29),
(79, 'Pokémon Gold et Silver', 'Deuxième génération de Pokémon avec des améliorations sur le gameplay et une nouvelle région à explorer.', '1999', '/covers/pokemongoldandsilver.png', 0, NULL, 30),
(80, 'Final Fantasy VII', 'RPG épique dans lequel le joueur incarne Cloud Strife et ses compagnons pour sauver le monde.', '1997', '/covers/finalfantasyvii.png', 0, NULL, 31),
(81, 'God of War: Ghost of Sparta', 'Jeu d\'action-aventure avec Kratos, combattant des créatures mythologiques dans un monde inspiré de la Grèce antique.', '2010', '/covers/godofwarghostofsparta.png', 0, NULL, 32),
(82, 'Uncharted: Golden Abyss', 'Jeu d\'aventure avec Nathan Drake sur PS Vita, où il explore une jungle à la recherche d\'un artefact légendaire.', '2011', '/covers/unchartedgoldenabyss.png', 0, NULL, 33),
(83, 'The Legend of Zelda: Wind Waker', 'Jeu d\'aventure dans lequel Link explore un vaste océan à la recherche de sa sœur dans un monde coloré.', '2002', '/covers/windwaker.png', 0, NULL, 34),
(84, 'Halo 2', 'Suite de Halo, où Master Chief continue son combat pour sauver l\'humanité contre les Covenant.', '2004', '/covers/halo2.png', 0, NULL, 35),
(85, 'Mario Kart DS', 'Jeu de course en 3D avec Mario et ses amis sur la première console portable Nintendo DS.', '2005', '/covers/mariokartds.png', 0, NULL, 36),
(86, 'Lemmings', 'Un jeu de réflexion où vous devez guider un groupe de Lemmings à travers des obstacles pour les sauver.', '1990', '/covers/lemmings.png', 0, NULL, 37),
(87, 'Commodore 64 Game Pack', 'Collection de jeux pour le Commodore 64, l\'un des premiers ordinateurs personnels populaires.', '1985', '/covers/commodore64gamepack.png', 0, NULL, 38),
(88, 'Samurai Shodown', 'Jeu de combat de SNK où des samouraïs et des personnages historiques s\'affrontent dans des duels de sabres.', '1993', '/covers/samuraishodown.png', 0, NULL, 39),
(89, 'Virtua Fighter 2', 'Jeu de combat en 3D où les joueurs s\'affrontent dans des matchs rapides avec des personnages différents.', '1994', '/covers/virtufighter2.png', 0, NULL, 40),
(90, 'Shenmue', 'Jeu d\'aventure en monde ouvert avec Ryo Hazuki qui cherche à venger la mort de son père en explorant un Japon réaliste.', '1999', '/covers/shenmue.png', 0, NULL, 41),
(91, 'Super Smash Bros. Brawl', 'Jeu de combat avec des personnages Nintendo dans des arènes 3D avec des éléments de plateforme.', '2008', '/covers/super_smash_bros_brawl.png', 0, NULL, 42),
(92, 'Super Mario Maker 2', 'Jeu de plateforme où les joueurs peuvent créer leurs propres niveaux Mario et les partager avec la communauté.', '2019', '/covers/supermariomaker2.png', 0, NULL, 43);

-- --------------------------------------------------------

--
-- Structure de la table `GJ_game_genres`
--

CREATE TABLE `GJ_game_genres` (
  `game_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `GJ_game_genres`
--

INSERT INTO `GJ_game_genres` (`game_id`, `genre_id`) VALUES
(1, 2),
(2, 6),
(3, 1),
(4, 6),
(5, 2),
(5, 3),
(6, 5),
(7, 3),
(8, 5),
(9, 7),
(10, 1),
(11, 1),
(12, 1),
(13, 4),
(14, 1),
(15, 3),
(16, 3),
(16, 14),
(17, 5),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 4),
(22, 15),
(23, 3),
(24, 3),
(25, 12),
(26, 11),
(26, 16),
(27, 3),
(28, 3),
(29, 4),
(30, 6),
(31, 3),
(32, 1),
(33, 11),
(33, 16),
(49, 17),
(50, 4),
(51, 4),
(52, 3),
(52, 14),
(53, 4),
(54, 12),
(55, 6),
(56, 1),
(57, 18),
(58, 3),
(59, 12),
(60, 3),
(61, 1),
(63, 1),
(64, 5),
(65, 5),
(69, 3),
(70, 1),
(71, 5),
(72, 3),
(73, 1),
(74, 1),
(75, 5),
(76, 4),
(77, 13),
(78, 1),
(79, 4),
(80, 4),
(81, 3),
(82, 3),
(83, 3),
(84, 6),
(85, 5),
(86, 10),
(88, 12),
(89, 12),
(90, 2),
(90, 3);

-- --------------------------------------------------------

--
-- Structure de la table `GJ_genres`
--

CREATE TABLE `GJ_genres` (
  `genre_id` int(11) NOT NULL,
  `genre_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `GJ_genres`
--

INSERT INTO `GJ_genres` (`genre_id`, `genre_label`) VALUES
(1, 'Plateforme'),
(2, 'Action'),
(3, 'Aventure'),
(4, 'RPG (Role-Playing Game)'),
(5, 'Course'),
(6, 'FPS (First Person Shooter)'),
(7, 'TPS (Third Person Shooter)'),
(8, 'Simulation'),
(9, 'Stratégie'),
(10, 'Puzzle'),
(11, 'Horreur'),
(12, 'Combat'),
(13, 'Beat \'em up'),
(14, 'Infiltration'),
(15, 'Hack and Slash'),
(16, 'Survie'),
(17, 'Shoot\'Em\'Up'),
(18, 'Sport');

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

--
-- Déchargement des données de la table `GJ_migrations`
--

INSERT INTO `GJ_migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

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

--
-- Déchargement des données de la table `GJ_progressions`
--

INSERT INTO `GJ_progressions` (`progress_id`, `progress_label`) VALUES
(1, 'Commencé'),
(2, 'Terminé'),
(3, 'Terminé à 100%'),
(4, 'Pas Commencé');

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

--
-- Déchargement des données de la table `GJ_roles`
--

INSERT INTO `GJ_roles` (`role_code`, `role_label`) VALUES
('A', 'Administrateur'),
('U', 'Utilisateur'),
('V', 'Validateur');

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

--
-- Déchargement des données de la table `GJ_sessions`
--

INSERT INTO `GJ_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('27mQHeeKUp5Bv5rsll5uOMcsYvzUi3iYJuZvqZ0N', 29, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnFDVENDeG9MOG9vbzJKWWdyellqTnBZSUl1bkJyTFNFTWVUOE0yZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZXRhaWxfamV1LzU2Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjk7fQ==', 1734367909),
('991k0FEStKu2ob68q7U0MB78rw35xTj7RrKdwCvg', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:128.0) Gecko/20100101 Firefox/128.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3ZJR2VvZzI4VDNuU2RlNWtERDhMdlV1R01jM3hhR2ZkMDY1R1RrUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1734456510);

-- --------------------------------------------------------

--
-- Structure de la table `GJ_status`
--

CREATE TABLE `GJ_status` (
  `status_id` int(11) NOT NULL,
  `status_label` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `GJ_status`
--

INSERT INTO `GJ_status` (`status_id`, `status_label`) VALUES
(1, 'Validée'),
(2, 'Refusée'),
(3, 'En Attente');

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

--
-- Déchargement des données de la table `GJ_supports`
--

INSERT INTO `GJ_supports` (`support_id`, `support_name`, `support_desc`, `support_year`, `support_pic`, `support_logo`, `owned_by`) VALUES
(15, 'PlayStation 5', 'Console de jeu de nouvelle génération de Sony', '2020', NULL, NULL, 0),
(16, 'Xbox Series X', 'Console de jeu de nouvelle génération de Microsoft', '2020', NULL, NULL, 0),
(17, 'Nintendo Switch', 'Console hybride de Nintendo, à la fois portable et de salon', '2017', NULL, NULL, 0),
(18, 'Steam', 'Plateforme de distribution de jeux vidéo sur PC', '2003', NULL, NULL, 0),
(19, 'PlayStation 4', 'Console de jeu de Sony, successeur de la PS3', '2013', NULL, NULL, 3),
(20, 'Xbox One', 'Console de jeu de Microsoft, successeur de la Xbox 360', '2013', NULL, NULL, 0),
(21, 'Nintendo 3DS', 'Console portable de Nintendo avec écran 3D sans lunettes', '2011', NULL, NULL, 2),
(22, 'PlayStation 3', 'Console de jeu de Sony, ancienne génération avant la PS4', '2006', NULL, NULL, 0),
(23, 'Xbox 360', 'Console de jeu de Microsoft, prédécesseur de la Xbox One', '2005', NULL, NULL, 3),
(24, 'Nintendo Entertainment System (NES)', 'Console de jeu de Nintendo, icône des années 80, avec des classiques comme Super Mario Bros.', '1985', NULL, NULL, 3),
(25, 'Sega Genesis', 'Console de jeu de Sega, connue sous le nom de Mega Drive en dehors des États-Unis, avec des jeux comme Sonic the Hedgehog.', '1988', NULL, NULL, 0),
(26, 'Super Nintendo Entertainment System (SNES)', 'Console de jeu de Nintendo, emblématique des années 90 avec des jeux comme Super Mario World et The Legend of Zelda: A Link to the Past.', '1990', NULL, NULL, 1),
(27, 'Game Boy', 'Console portable de Nintendo, pionnière dans le domaine des consoles portables avec des jeux comme Tetris et Pokémon.', '1989', NULL, NULL, 0),
(28, 'Sega Master System', 'Première console de Sega, sortie avant la Genesis, connue pour ses jeux comme Alex Kidd et Phantasy Star.', '1985', NULL, NULL, 0),
(29, 'Atari 2600', 'Console de jeu d\'Atari qui a popularisé le jeu vidéo à domicile dans les années 70 avec des jeux comme Space Invaders.', '1977', NULL, NULL, 0),
(30, 'Game Boy Color', 'Console portable de Nintendo qui apporte la couleur à la gamme Game Boy.', '1998', NULL, NULL, 0),
(31, 'PlayStation 2', 'Console de Sony, l\'une des consoles les plus vendues de tous les temps, avec un vaste catalogue de jeux.', '2000', NULL, NULL, 0),
(32, 'PSP (PlayStation Portable)', 'Console portable de Sony, offrant une expérience de jeu portable de haute qualité.', '2004', NULL, NULL, 0),
(33, 'PS Vita', 'Console portable de Sony avec écran tactile et connexion réseau, successeur de la PSP.', '2011', NULL, NULL, 0),
(34, 'Nintendo GameCube', 'Console de salon de Nintendo avec des jeux cultes comme Super Smash Bros. Melee.', '2001', NULL, NULL, 0),
(35, 'Xbox', 'Première console de jeu de Microsoft, introduisant des jeux comme Halo.', '2001', NULL, NULL, 0),
(36, 'Nintendo DS', 'Console portable de Nintendo avec deux écrans, dont un tactile, qui a révolutionné le jeu portable.', '2004', NULL, NULL, 0),
(37, 'Atari Lynx', 'Console portable d\'Atari, première console portable couleur avec des fonctionnalités avancées pour son époque.', '1989', NULL, NULL, 0),
(38, 'Commodore 64', 'Ordinateur personnel qui a marqué l\'histoire du jeu vidéo avec un large catalogue de jeux.', '1982', NULL, NULL, 0),
(39, 'Neo Geo', 'Console de SNK offrant des jeux d\'arcade de haute qualité, mais avec un coût élevé pour les particuliers.', '1990', NULL, NULL, 0),
(40, 'Sega Saturn', 'Console de Sega avec des jeux 2D et 3D avancés, notamment populaire au Japon.', '1994', NULL, NULL, 0),
(41, 'Dreamcast', 'Console de Sega offrant une connexion Internet et des jeux innovants, mais qui a marqué la fin de Sega en tant que constructeur de consoles.', '1998', NULL, NULL, 0),
(42, 'Wii', 'Console de Nintendo mettant l\'accent sur le jeu en famille avec des contrôleurs de mouvement innovants.', '2006', NULL, NULL, 0),
(43, 'Wii U', 'Console de Nintendo avec un écran tactile intégré dans le contrôleur, ouvrant la voie à la Switch.', '2012', NULL, NULL, 0),
(44, 'Amiga 500', 'Ordinateur personnel avec des capacités graphiques et sonores avancées pour son époque, très populaire dans les années 80.', '1987', NULL, NULL, 0);

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
-- Déchargement des données de la table `GJ_users`
--

INSERT INTO `GJ_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `telephone`, `visibilite`, `can_contribute`, `code`, `comment`, `created_at`, `updated_at`) VALUES
(1, 'Hélène Simon', 'helene.simon@example.com', NULL, '$2y$10$hxMkUy9HlXk1u3Fk4vch7QuZpZCZ2TmsH0L6Xm3V.P8Sc65dMnHVK', NULL, '0734567890', 1, 0, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(2, 'Igor Leclerc', 'igor.leclerc@example.com', NULL, '$2y$10$kFBVah3QnpVh5lyVZYx8C7ewjdz13ExIN1CjI6coJjmGfISvF.d8a', NULL, '0654321098', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(3, 'Jules Martin', 'jules.martin@example.com', NULL, '$2y$10$yzC2cIHrD2o8VuFZ6Wb1E6qFftFAdDLjpZjySHR0oi9lOm8N6V1hO', NULL, '0601234567', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(4, 'Karine Bertrand', 'karine.bertrand@example.com', NULL, '$2y$10$Gevw.L7XBaFSGe5cTSaT1OqM8DFF56ndQX1Qx6MZznq2oY0PfhwIm', NULL, '0671122334', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(5, 'Louis Robert', 'louis.robert@example.com', NULL, '$2y$10$KPzC7Hmu9pEdVrnAcYQy9XvDeVq7lKvUuZG0w5eek6VhPST7VZ5ZW', NULL, '0723456789', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(6, 'Monique Valéry', 'monique.valery@example.com', NULL, '$2y$10$tzRcq7VjaF3g1gkIu9Sy7A9O6yH6PaA3F5ti.bhKTdyRi41c9E7Q.', NULL, '0687654321', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(7, 'Nicolas Lemoine', 'nicolas.lemoine@example.com', NULL, '$2y$10$LfI7ZsOY0hzsf9Oq1Di9yZwevRsSCfgUYoP9dm1bIthgJw79q3IHu', NULL, '0612345678', 1, 1, 'U', NULL, '2024-11-13 18:07:25', '2024-12-13 12:25:26'),
(8, 'Olivier Dubois', 'olivier.dubois@example.com', NULL, '$2y$10$szqkn6fEZwUzxCw0jWEwTO2f7bNwTZJ3Qs.z0buFzXECrtmpxjTeO', NULL, '0654321789', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(9, 'Pauline Lefevre', 'pauline.lefevre@example.com', NULL, '$2y$10$sh7faT2Xf3wqPoZjX5tCHuXmkmVZjbzZ2IkZc7I9GDo5So1B8k0z.', NULL, '0698765432', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(10, 'Quentin Bernard', 'quentin.bernard@example.com', NULL, '$2y$10$GZpy9uAKT1diHLyvh1i6Kfvlq9eAynWAwRg3YEq9mC74GvAm7I9xG', NULL, '0612349876', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(11, 'Roxane Dufresne', 'roxane.dufresne@example.com', NULL, '$2y$10$jlZZ6C0f.DdEznOoDhFcVi/0d6OPO8KKfd6DNT0oOpNk8MvwVtIjA', NULL, '0622334455', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(12, 'Sébastien Lemoine', 'sebastien.lemoine@example.com', NULL, '$2y$10$zTXH9en5M8VeDWeJmV7aROzE5FVn7z5G18NmXc8h0xWoi3lhpf1tG', NULL, '0734123456', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(13, 'Tatiana Leroux', 'tatiana.leroux@example.com', NULL, '$2y$10$e7N8XddK0QIbvHWjAp76l0eqlFy6lzGBVNKPtNJ9Jl3cE5KZs6cxa', NULL, '0687530912', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(14, 'Ugo Martin', 'ugo.martin@example.com', NULL, '$2y$10$wjUOMr2lfODlmS8g7ccjsFj5NKtdHoUoe8RUOUf2fbeRgd6yKhPSy', NULL, '0709876543', 1, 1, 'U', NULL, '2024-11-13 18:08:35', '2024-12-13 12:25:26'),
(15, 'Alice Dupont', 'alice.dupont@example.com', NULL, '$2y$10$DXoANpmgVkLpqyQ0o/ZgfKpc5IGvKHT6lE2ZqDe3L5baHzpjeIWb6', NULL, '0611122334', 1, 1, 'V', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(16, 'Bastien Lefevre', 'bastien.lefevre@example.com', NULL, '$2y$10$LzBs8Dw5kkmn.NJOrvH0Y1y9dG0uaGA0Pgt6lHeDwiHe.s6icKnDW', NULL, '0622334455', 0, 1, 'U', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(17, 'Caroline Ménard', 'caroline.menard@example.com', NULL, '$2y$10$H9IFzfbpKQ1hbiqtpX9Xb6KQzO9dCslGJxe1AVguIFbkvUy7cs0Ce', NULL, '0655443322', 1, 0, 'U', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(18, 'David Garcia', 'david.garcia@example.com', NULL, '$2y$10$4VpFftZB8NzkrQ8qqoWhp6VgZdYwvTbfPzHzVZ2p1bXtwS7.VV4Ou', NULL, '0698761234', 0, 1, 'V', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(20, 'François Girard', 'francois.girard@example.com', NULL, '$2y$10$6vAIA5YzhU1jEjGRMiFzFxxpOx3rnHkAt9tYn9oXh1YnzGysd3uQy', NULL, '0632567890', 1, 0, 'U', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(21, 'Géraldine Lemoine', 'geraldine.lemoine@example.com', NULL, '$2y$10$5q8yEJ9kT5lYe2rtn9bggvKxdhtg2vT4nT1kDg31DgtV3bI6Ztv4m', NULL, '0673459876', 1, 1, 'V', NULL, '2024-11-13 18:10:46', '2024-12-13 12:25:26'),
(22, 'dirila', 'axel.m.diril@gmail.com', NULL, '$2y$12$J7Ecm1oSmiNiiXUNbkUQHe9S0Uap.fW0mXIhRZh2w4B5GoGYquOPm', 'oeskpbei2eulhBE2qs69pYtv6RqzmNLynrRojQjtYG5mCEvFMTwwZKtXY7Vb', NULL, 1, 1, 'A', NULL, '2024-11-20 18:59:51', '2024-12-16 14:50:22'),
(28, 'admin', 'admin.gestionjeux@gmail.com', NULL, '$2y$12$bXugxmZ0QuemAE7Q3x5em.9dTX8MkunVzhjLbpHmNJcSoOqKmATwS', NULL, NULL, 1, 1, 'U', 'Mot de passe : M2p_admin', '2024-12-13 15:04:33', '2024-12-13 16:05:46'),
(29, 'dirila', 'axel.diril@orange.fr', NULL, '$2y$12$0724KgSfsF3YGLkOip3W2eNH7y87/WcLuTvt1oN8Tv1dP93W/oZoG', NULL, NULL, 0, 1, 'U', NULL, '2024-12-16 13:50:57', '2024-12-16 15:33:42');

-- --------------------------------------------------------

--
-- Structure de la table `GJ_wishlists`
--

CREATE TABLE `GJ_wishlists` (
  `game_id` int(11) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
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
-- Index pour la table `GJ_wishlists`
--
ALTER TABLE `GJ_wishlists`
  ADD KEY `GJ_wishlist_id_FK` (`id`),
  ADD KEY `GJ_wishlist_game_id_FK` (`game_id`);

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
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `GJ_genres`
--
ALTER TABLE `GJ_genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `GJ_jobs`
--
ALTER TABLE `GJ_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_migrations`
--
ALTER TABLE `GJ_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `GJ_progressions`
--
ALTER TABLE `GJ_progressions`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `GJ_requests`
--
ALTER TABLE `GJ_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `GJ_status`
--
ALTER TABLE `GJ_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `GJ_supports`
--
ALTER TABLE `GJ_supports`
  MODIFY `support_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `GJ_users`
--
ALTER TABLE `GJ_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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

--
-- Contraintes pour la table `GJ_wishlists`
--
ALTER TABLE `GJ_wishlists`
  ADD CONSTRAINT `GJ_wishlist` FOREIGN KEY (`id`) REFERENCES `GJ_users` (`id`),
  ADD CONSTRAINT `GJ_wishlist_game_id_FK` FOREIGN KEY (`game_id`) REFERENCES `GJ_games` (`game_id`),
  ADD CONSTRAINT `GJ_wishlist_id_FK` FOREIGN KEY (`id`) REFERENCES `GJ_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

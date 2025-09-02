-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 09:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pingpong_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `established` year(4) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `members` int(11) DEFAULT 0,
  `active_members` int(11) DEFAULT 0,
  `coaches` int(11) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews` int(11) DEFAULT 0,
  `verified` tinyint(1) DEFAULT 0,
  `team_ranking` int(11) DEFAULT 0,
  `recent_matches` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `short_name`, `city`, `region`, `province`, `address`, `established`, `logo`, `description`, `members`, `active_members`, `coaches`, `rating`, `reviews`, `verified`, `team_ranking`, `recent_matches`, `created_at`, `updated_at`) VALUES
(1, 'Stoni Table Tennis Club', 'STONI', 'Jakarta Selatan', NULL, 'DKI Jakarta', 'Jl. Gatot Subroto No. 12, Jakarta', '1985', 'https://via.placeholder.com/150/FF5733/FFFFFF?text=STONI', NULL, 0, 0, 0, 4.80, 0, 1, 0, 0, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(2, 'Surya Naga Table Tennis', 'SNaga', 'Surabaya', NULL, 'Jawa Timur', 'Jl. Pahlawan No. 101, Surabaya', '1992', 'https://via.placeholder.com/150/3375FF/FFFFFF?text=SNaga', NULL, 0, 0, 0, 4.90, 0, 1, 0, 0, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(3, 'Harapan Bangsa TTC', 'HB-TTC', 'Bandung', NULL, 'Jawa Barat', 'Jl. Asia Afrika No. 55, Bandung', '2005', 'https://via.placeholder.com/150/33FF57/FFFFFF?text=HB-TTC', NULL, 0, 0, 0, 4.50, 0, 1, 0, 0, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(4, 'Komunitas Ping Pong Cilandak', 'KPC', 'Jakarta Selatan', NULL, 'DKI Jakarta', 'GOR Cilandak, Jakarta', '2018', 'https://via.placeholder.com/150/F4D03F/FFFFFF?text=KPC', NULL, 0, 0, 0, 4.20, 0, 0, 0, 0, '2025-09-02 07:34:45', '2025-09-02 07:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `club_achievements`
--

CREATE TABLE `club_achievements` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `achievement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club_achievements`
--

INSERT INTO `club_achievements` (`id`, `club_id`, `achievement`) VALUES
(1, 1, 'Best Club in Jakarta 2023'),
(2, 2, 'National League Champion 2024');

-- --------------------------------------------------------

--
-- Table structure for table `club_contact`
--

CREATE TABLE `club_contact` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club_contact`
--

INSERT INTO `club_contact` (`id`, `club_id`, `phone`, `email`, `website`) VALUES
(1, 1, '021-555-1001', 'contact@stonittc.com', NULL),
(2, 2, '031-555-2002', 'info@suryanaga.com', NULL),
(3, 3, '022-555-3003', 'admin@hbtcc.org', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `club_facilities`
--

CREATE TABLE `club_facilities` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `facility` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club_facilities`
--

INSERT INTO `club_facilities` (`id`, `club_id`, `facility`) VALUES
(1, 1, '10 Professional Tables'),
(2, 1, 'Air Conditioning'),
(3, 1, 'Locker Room'),
(4, 2, '12 Professional Tables'),
(5, 2, 'Table Tennis Robot'),
(6, 3, '8 Tables');

-- --------------------------------------------------------

--
-- Table structure for table `club_membership`
--

CREATE TABLE `club_membership` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `type` enum('monthly','yearly','student','youth') NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club_membership`
--

INSERT INTO `club_membership` (`id`, `club_id`, `type`, `price`) VALUES
(1, 1, 'monthly', 500000),
(2, 1, 'yearly', 5500000),
(3, 2, 'monthly', 450000),
(4, 3, 'student', 250000);

-- --------------------------------------------------------

--
-- Table structure for table `club_photos`
--

CREATE TABLE `club_photos` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `photo_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club_photos`
--

INSERT INTO `club_photos` (`id`, `club_id`, `photo_url`) VALUES
(1, 1, 'https://via.placeholder.com/500/FF5733/FFFFFF?text=Venue1'),
(2, 1, 'https://via.placeholder.com/500/FF5733/FFFFFF?text=Venue2'),
(3, 2, 'https://via.placeholder.com/500/3375FF/FFFFFF?text=Venue3');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `participant1_id` int(11) NOT NULL,
  `participant2_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `participant1_id`, `participant2_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(2, 5, 8, '2025-09-02 07:34:46', '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `type` enum('match_report','event','achievement','club_match_announce','club_recruitment','tournament_announce','training_tip') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `score` varchar(10) DEFAULT NULL,
  `opponent` varchar(255) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_datetime` datetime DEFAULT NULL,
  `max_players` int(11) DEFAULT NULL,
  `current_players` int(11) DEFAULT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `old_rating` int(11) DEFAULT NULL,
  `new_rating` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `deadline` date DEFAULT NULL,
  `prize` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `type`, `user_id`, `club_id`, `content`, `image`, `likes`, `comments`, `score`, `opponent`, `venue`, `location`, `event_datetime`, `max_players`, `current_players`, `badge`, `old_rating`, `new_rating`, `match_id`, `tournament_id`, `verified`, `deadline`, `prize`, `category`, `created_at`) VALUES
(1, 'match_report', 1, 1, 'Great win today against a tough opponent! Score 3-1. Elo increased +15.', NULL, 55, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-09-02 07:34:46'),
(2, 'achievement', 3, 3, 'So happy to win the West Java Championship! Thanks for the support!', NULL, 120, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-09-02 07:34:46'),
(3, 'club_recruitment', NULL, 1, 'Stoni TTC is opening recruitment for new junior players. Join us!', NULL, 88, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-09-02 07:34:46'),
(4, 'tournament_announce', NULL, NULL, 'Registration for Indonesia Open 2025 is now open! Sign up now!', NULL, 250, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, '2025-09-02 07:34:46'),
(5, 'club_match_announce', NULL, 1, 'Don\'t miss the big match: STONI vs KPC next week!', NULL, 75, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `inter_club_matches`
--

CREATE TABLE `inter_club_matches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `home_club_id` int(11) DEFAULT NULL,
  `away_club_id` int(11) DEFAULT NULL,
  `match_datetime` datetime DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `format` varchar(100) DEFAULT NULL,
  `status` enum('scheduled','registration_open','completed') DEFAULT 'scheduled',
  `description` text DEFAULT NULL,
  `home_score` int(11) DEFAULT 0,
  `away_score` int(11) DEFAULT 0,
  `prize` int(11) DEFAULT 0,
  `max_clubs` int(11) DEFAULT NULL,
  `entry_fee` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inter_club_matches`
--

INSERT INTO `inter_club_matches` (`id`, `name`, `home_club_id`, `away_club_id`, `match_datetime`, `venue`, `format`, `status`, `description`, `home_score`, `away_score`, `prize`, `max_clubs`, `entry_fee`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta Champions League: STONI vs KPC', 1, 4, '2025-09-15 19:00:00', 'Stoni Table Tennis Club', NULL, 'scheduled', NULL, 0, 0, 0, NULL, 0, '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(2, 'East Java Derby: Surya Naga vs Malang Pro', 2, NULL, '2025-10-05 15:00:00', 'GOR Sudirman, Surabaya', NULL, 'registration_open', NULL, 0, 0, 0, NULL, 0, '2025-09-02 07:34:46', '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `marketplace`
--

CREATE TABLE `marketplace` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `item_condition` enum('New','Good','Like New') DEFAULT 'Good',
  `location` varchar(255) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `status` enum('Available','Sold') DEFAULT 'Available',
  `category` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `posted_date` date DEFAULT NULL,
  `description_notes` text DEFAULT NULL,
  `meeting_point` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketplace`
--

INSERT INTO `marketplace` (`id`, `name`, `price`, `item_condition`, `location`, `photo`, `seller_id`, `status`, `category`, `brand`, `posted_date`, `description_notes`, `meeting_point`, `reason`, `created_at`, `updated_at`) VALUES
(1, 'Used Butterfly Viscaria Blade (FL)', 1500000, 'Good', 'Jakarta Selatan', NULL, 1, 'Available', 'Blade', 'Butterfly', NULL, NULL, NULL, NULL, '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(2, 'New DHS Hurricane 3 Rubber (Black)', 250000, 'New', 'Surabaya', NULL, 2, 'Available', 'Rubber', 'DHS', NULL, NULL, NULL, NULL, '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(3, 'Like New Stiga Cybershape Blade', 2200000, 'Like New', 'Bandung', NULL, 3, 'Sold', 'Blade', 'Stiga', NULL, NULL, NULL, NULL, '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(4, 'Secondhand Tibhar Evolution MX-P', 300000, 'Good', 'Jakarta Barat', NULL, 8, 'Available', 'Rubber', 'Tibhar', NULL, NULL, NULL, NULL, '2025-09-02 07:34:46', '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `marketplace_images`
--

CREATE TABLE `marketplace_images` (
  `id` int(11) NOT NULL,
  `marketplace_id` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketplace_images`
--

INSERT INTO `marketplace_images` (`id`, `marketplace_id`, `image_url`) VALUES
(1, 1, 'https://via.placeholder.com/500/0000FF/FFFFFF?text=Viscaria1'),
(2, 1, 'https://via.placeholder.com/500/0000FF/FFFFFF?text=Viscaria2'),
(3, 2, 'https://via.placeholder.com/500/FF0000/FFFFFF?text=H3');

-- --------------------------------------------------------

--
-- Table structure for table `match_participants`
--

CREATE TABLE `match_participants` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `participant_name` varchar(255) NOT NULL,
  `team` enum('home','away') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `match_participants`
--

INSERT INTO `match_participants` (`id`, `match_id`, `participant_name`, `team`) VALUES
(1, 1, 'Budi Santoso', 'home'),
(2, 1, 'Hendra Wijaya', 'away');

-- --------------------------------------------------------

--
-- Table structure for table `match_registered_clubs`
--

CREATE TABLE `match_registered_clubs` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `match_registered_clubs`
--

INSERT INTO `match_registered_clubs` (`id`, `match_id`, `club_id`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 1, 'Hi Citra, interested in a sparring match this weekend?', 1, '2025-09-02 07:34:46'),
(2, 1, 3, 'Hi Budi! Sure, I\'d love to. Saturday afternoon?', 1, '2025-09-02 07:34:46'),
(3, 1, 1, 'Perfect. My place at 2 PM?', 0, '2025-09-02 07:34:46'),
(4, 2, 5, 'Hey, your defensive style is really good. Any tips?', 1, '2025-09-02 07:34:46'),
(5, 2, 8, 'Thanks Eko! It\'s all about footwork and anticipation. We can practice together sometime.', 0, '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `recipient_user_id` int(11) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `type` enum('match_request','tournament','achievement','message') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `related_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient_user_id`, `from_user_id`, `type`, `message`, `is_read`, `related_id`, `created_at`) VALUES
(1, 3, 1, 'message', 'Budi Santoso sent you a message.', 0, 1, '2025-09-02 07:34:46'),
(2, 1, 3, 'message', 'Citra Lestari replied to your message.', 0, 1, '2025-09-02 07:34:46'),
(3, 1, NULL, 'tournament', 'Registration for Indonesia Open 2025 is closing soon!', 0, 1, '2025-09-02 07:34:46'),
(4, 8, 5, 'message', 'Eko Prasetyo sent you a message.', 0, 2, '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `fee` int(11) DEFAULT 0,
  `participants` int(11) DEFAULT 0,
  `max_participants` int(11) DEFAULT NULL,
  `status` enum('Open','Full','Closed','Ongoing','Completed') DEFAULT 'Open',
  `prize` int(11) DEFAULT 0,
  `organizer` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('individual','club') DEFAULT 'individual',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `name`, `date`, `location`, `category`, `fee`, `participants`, `max_participants`, `status`, `prize`, `organizer`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Indonesia Open 2025', '2025-11-10 09:00:00', 'Istora Senayan, Jakarta', 'Open National', 0, 0, 128, 'Open', 100000000, NULL, NULL, 'individual', '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(2, 'Bandung Invitational', '2025-10-25 09:00:00', 'GOR Pajajaran, Bandung', 'U-21', 0, 0, 64, 'Open', 15000000, NULL, NULL, 'individual', '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(3, 'Surabaya Corporate League', '2025-09-20 10:00:00', 'GOR Sudirman, Surabaya', 'Corporate Teams', 0, 0, 32, 'Full', 25000000, NULL, NULL, 'individual', '2025-09-02 07:34:45', '2025-09-02 07:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_rules`
--

CREATE TABLE `tournament_rules` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `rule` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournament_rules`
--

INSERT INTO `tournament_rules` (`id`, `tournament_id`, `rule`) VALUES
(1, 1, 'ITTF standard rules apply.'),
(2, 1, 'Best of 5 games for all rounds.'),
(3, 1, 'Best of 7 games for final.');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_schedule`
--

CREATE TABLE `tournament_schedule` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `round` varchar(100) NOT NULL,
  `schedule_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournament_schedule`
--

INSERT INTO `tournament_schedule` (`id`, `tournament_id`, `round`, `schedule_time`) VALUES
(1, 1, 'Round of 128', '2025-11-10 09:00:00'),
(2, 1, 'Round of 64', '2025-11-10 14:00:00'),
(3, 2, 'Qualification', '2025-10-25 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT 0,
  `elo` int(11) DEFAULT 0,
  `skill` enum('Division 1','Division 2','Division 3','Division 4','Division 5','Division 6','Division 7','Division 8','Division 9','Division 10') DEFAULT NULL,
  `style` enum('Offensive','Defensive','All-round') DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `club_role` enum('player','coach','admin') DEFAULT 'player',
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews` int(11) DEFAULT 0,
  `last_active` timestamp NULL DEFAULT NULL,
  `distance` decimal(5,2) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `photo`, `location`, `online`, `elo`, `skill`, `style`, `club_id`, `club_role`, `rating`, `reviews`, `last_active`, `distance`, `availability`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 28, NULL, 'Jakarta Selatan', 0, 2150, 'Division 1', 'Offensive', 1, 'player', 0.00, 0, '2025-09-02 07:10:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(2, 'Agus Setiawan', 35, NULL, 'Surabaya', 0, 2200, 'Division 1', 'All-round', 2, 'coach', 0.00, 0, '2025-09-02 06:30:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(3, 'Citra Lestari', 22, NULL, 'Bandung', 0, 1950, 'Division 2', 'Defensive', 3, 'player', 0.00, 0, '2025-09-02 07:05:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(4, 'Dewi Anggraini', 45, NULL, 'Jakarta Selatan', 0, 1800, 'Division 3', 'All-round', 1, 'admin', 0.00, 0, '2025-09-02 04:00:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(5, 'Eko Prasetyo', 19, NULL, 'Jakarta Timur', 0, 1650, 'Division 4', 'Offensive', NULL, 'player', 0.00, 0, '2025-09-01 13:00:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(6, 'Fitriani', 25, NULL, 'Surabaya', 0, 1750, 'Division 3', 'Offensive', 2, 'player', 0.00, 0, '2025-09-02 05:45:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(7, 'Gunawan', 31, NULL, 'Bandung', 0, 1500, 'Division 5', 'All-round', 3, 'player', 0.00, 0, '2025-08-31 11:00:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45'),
(8, 'Hendra Wijaya', 29, NULL, 'Jakarta Barat', 0, 1350, 'Division 6', 'Defensive', 4, 'player', 0.00, 0, '2025-09-02 02:15:00', NULL, NULL, '2025-09-02 07:34:45', '2025-09-02 07:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE `user_achievements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `date_achieved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_achievements`
--

INSERT INTO `user_achievements` (`id`, `user_id`, `name`, `icon`, `date_achieved`) VALUES
(1, 1, '1st Place Jakarta Open 2024', NULL, '2024-08-17'),
(2, 2, 'National Coach of The Year 2023', NULL, '2023-12-20'),
(3, 3, 'West Java Championship Winner 2024', NULL, '2024-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `user_equipment`
--

CREATE TABLE `user_equipment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blade` varchar(255) DEFAULT NULL,
  `rubber_fh` varchar(255) DEFAULT NULL,
  `rubber_bh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_equipment`
--

INSERT INTO `user_equipment` (`id`, `user_id`, `blade`, `rubber_fh`, `rubber_bh`) VALUES
(1, 1, 'Butterfly Viscaria', 'DHS Hurricane 3', 'Butterfly Tenergy 05'),
(2, 2, 'Stiga Carbonado 290', 'Stiga DNA Platinum XH', 'Stiga DNA Platinum XH'),
(3, 3, 'Yasaka Ma Lin Carbon', 'Yasaka Rakza 7', 'Yasaka Rakza 7 Soft'),
(4, 5, 'DHS Fang Bo Carbon', 'DHS GoldArc 8', 'DHS GoldArc 5'),
(5, 6, 'Butterfly Timo Boll ALC', 'Butterfly Tenergy 19', 'Butterfly Dignics 09c');

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `play_time` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`play_time`)),
  `skill_range` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skill_range`)),
  `max_distance` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_preferences`
--

INSERT INTO `user_preferences` (`id`, `user_id`, `play_time`, `skill_range`, `max_distance`) VALUES
(1, 1, '[\"weekday_evening\", \"weekend_afternoon\"]', '{\"min\": 2000, \"max\": 2300}', 15),
(2, 3, '[\"weekend_morning\"]', '{\"min\": 1800, \"max\": 2100}', 20),
(3, 5, '[\"any\"]', '{\"min\": 1500, \"max\": 1800}', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `matches` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `tournaments` int(11) DEFAULT 0,
  `current_rank` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0,
  `monthly_matches` int(11) DEFAULT 0,
  `avg_score` decimal(3,2) DEFAULT 0.00,
  `club_matches` int(11) DEFAULT 0,
  `club_wins` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_stats`
--

INSERT INTO `user_stats` (`id`, `user_id`, `matches`, `wins`, `tournaments`, `current_rank`, `points`, `monthly_matches`, `avg_score`, `club_matches`, `club_wins`) VALUES
(1, 1, 150, 125, 15, 10, 0, 0, 0.00, 0, 0),
(2, 2, 250, 210, 25, 5, 0, 0, 0.00, 0, 0),
(3, 3, 90, 70, 8, 25, 0, 0, 0.00, 0, 0),
(4, 4, 80, 50, 5, 80, 0, 0, 0.00, 0, 0),
(5, 5, 45, 25, 2, 150, 0, 0, 0.00, 0, 0),
(6, 6, 110, 85, 9, 40, 0, 0, 0.00, 0, 0),
(7, 7, 60, 30, 3, 210, 0, 0, 0.00, 0, 0),
(8, 8, 75, 40, 4, 180, 0, 0, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `distance` decimal(5,2) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews` int(11) DEFAULT 0,
  `tables` int(11) DEFAULT 0,
  `type` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT 0,
  `price_unit` varchar(20) DEFAULT 'per hour',
  `photo` varchar(500) DEFAULT NULL,
  `open_hours` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `distance`, `rating`, `reviews`, `tables`, `type`, `price`, `price_unit`, `photo`, `open_hours`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'GOR Cilandak', 5.20, 4.10, 0, 6, NULL, 50000, 'per hour', NULL, NULL, NULL, 'Jl. Cilandak KKO, Jakarta Selatan', '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(2, 'BSD Ping Pong Center', 15.80, 4.70, 0, 12, NULL, 75000, 'per hour', NULL, NULL, NULL, 'Jl. Grand Boulevard, BSD City, Tangerang', '2025-09-02 07:34:46', '2025-09-02 07:34:46'),
(3, 'Rawamangun Sports Hall', 12.10, 4.30, 0, 8, NULL, 60000, 'per hour', NULL, NULL, NULL, 'Jl. Pemuda No. 1, Jakarta Timur', '2025-09-02 07:34:46', '2025-09-02 07:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `venue_facilities`
--

CREATE TABLE `venue_facilities` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `facility` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_clubs_city` (`city`),
  ADD KEY `idx_clubs_province` (`province`),
  ADD KEY `idx_clubs_verified` (`verified`),
  ADD KEY `idx_clubs_team_ranking` (`team_ranking`);

--
-- Indexes for table `club_achievements`
--
ALTER TABLE `club_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_club_achievements_club` (`club_id`);

--
-- Indexes for table `club_contact`
--
ALTER TABLE `club_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_club_contact_club` (`club_id`);

--
-- Indexes for table `club_facilities`
--
ALTER TABLE `club_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_club_facilities_club` (`club_id`);

--
-- Indexes for table `club_membership`
--
ALTER TABLE `club_membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_club_membership_club` (`club_id`);

--
-- Indexes for table `club_photos`
--
ALTER TABLE `club_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_club_photos_club` (`club_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_conversation` (`participant1_id`,`participant2_id`),
  ADD KEY `fk_conv_p2` (`participant2_id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feed_match` (`match_id`),
  ADD KEY `fk_feed_tournament` (`tournament_id`),
  ADD KEY `idx_feed_type` (`type`),
  ADD KEY `idx_feed_user_id` (`user_id`),
  ADD KEY `idx_feed_club_id` (`club_id`),
  ADD KEY `idx_feed_created_at` (`created_at`);

--
-- Indexes for table `inter_club_matches`
--
ALTER TABLE `inter_club_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inter_club_matches_date` (`match_datetime`),
  ADD KEY `idx_inter_club_matches_status` (`status`),
  ADD KEY `idx_inter_club_matches_home_club` (`home_club_id`),
  ADD KEY `idx_inter_club_matches_away_club` (`away_club_id`);

--
-- Indexes for table `marketplace`
--
ALTER TABLE `marketplace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_marketplace_seller_id` (`seller_id`),
  ADD KEY `idx_marketplace_status` (`status`),
  ADD KEY `idx_marketplace_category` (`category`),
  ADD KEY `idx_marketplace_price` (`price`);

--
-- Indexes for table `marketplace_images`
--
ALTER TABLE `marketplace_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_marketplace_images_item` (`marketplace_id`);

--
-- Indexes for table `match_participants`
--
ALTER TABLE `match_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_match_participants_match` (`match_id`);

--
-- Indexes for table `match_registered_clubs`
--
ALTER TABLE `match_registered_clubs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_match_club` (`match_id`,`club_id`),
  ADD KEY `fk_mrc_club` (`club_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_sender` (`sender_id`),
  ADD KEY `idx_messages_conversation_id` (`conversation_id`),
  ADD KEY `idx_messages_created_at` (`created_at`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notif_from` (`from_user_id`),
  ADD KEY `idx_notifications_recipient` (`recipient_user_id`),
  ADD KEY `idx_notifications_is_read` (`is_read`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tournaments_date` (`date`),
  ADD KEY `idx_tournaments_status` (`status`),
  ADD KEY `idx_tournaments_type` (`type`);

--
-- Indexes for table `tournament_rules`
--
ALTER TABLE `tournament_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tournament_rules_tournament` (`tournament_id`);

--
-- Indexes for table `tournament_schedule`
--
ALTER TABLE `tournament_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tournament_schedule_tournament` (`tournament_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_users_club_id` (`club_id`),
  ADD KEY `idx_users_location` (`location`),
  ADD KEY `idx_users_elo` (`elo`),
  ADD KEY `idx_users_online` (`online`);

--
-- Indexes for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_achievements_user` (`user_id`);

--
-- Indexes for table `user_equipment`
--
ALTER TABLE `user_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_equipment_user` (`user_id`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_preferences_user` (`user_id`);

--
-- Indexes for table `user_stats`
--
ALTER TABLE `user_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_stats_user` (`user_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_venues_distance` (`distance`),
  ADD KEY `idx_venues_rating` (`rating`);

--
-- Indexes for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venue_facilities_venue` (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `club_achievements`
--
ALTER TABLE `club_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `club_contact`
--
ALTER TABLE `club_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `club_facilities`
--
ALTER TABLE `club_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `club_membership`
--
ALTER TABLE `club_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `club_photos`
--
ALTER TABLE `club_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inter_club_matches`
--
ALTER TABLE `inter_club_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marketplace`
--
ALTER TABLE `marketplace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `marketplace_images`
--
ALTER TABLE `marketplace_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `match_participants`
--
ALTER TABLE `match_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `match_registered_clubs`
--
ALTER TABLE `match_registered_clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tournament_rules`
--
ALTER TABLE `tournament_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tournament_schedule`
--
ALTER TABLE `tournament_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_equipment`
--
ALTER TABLE `user_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club_achievements`
--
ALTER TABLE `club_achievements`
  ADD CONSTRAINT `fk_club_achievements_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `club_contact`
--
ALTER TABLE `club_contact`
  ADD CONSTRAINT `fk_club_contact_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `club_facilities`
--
ALTER TABLE `club_facilities`
  ADD CONSTRAINT `fk_club_facilities_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `club_membership`
--
ALTER TABLE `club_membership`
  ADD CONSTRAINT `fk_club_membership_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `club_photos`
--
ALTER TABLE `club_photos`
  ADD CONSTRAINT `fk_club_photos_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `fk_conv_p1` FOREIGN KEY (`participant1_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_conv_p2` FOREIGN KEY (`participant2_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `fk_feed_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feed_match` FOREIGN KEY (`match_id`) REFERENCES `inter_club_matches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feed_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feed_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inter_club_matches`
--
ALTER TABLE `inter_club_matches`
  ADD CONSTRAINT `fk_icm_away_club` FOREIGN KEY (`away_club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_icm_home_club` FOREIGN KEY (`home_club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `marketplace`
--
ALTER TABLE `marketplace`
  ADD CONSTRAINT `fk_marketplace_seller` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marketplace_images`
--
ALTER TABLE `marketplace_images`
  ADD CONSTRAINT `fk_marketplace_images_item` FOREIGN KEY (`marketplace_id`) REFERENCES `marketplace` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `match_participants`
--
ALTER TABLE `match_participants`
  ADD CONSTRAINT `fk_match_participants_match` FOREIGN KEY (`match_id`) REFERENCES `inter_club_matches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `match_registered_clubs`
--
ALTER TABLE `match_registered_clubs`
  ADD CONSTRAINT `fk_mrc_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mrc_match` FOREIGN KEY (`match_id`) REFERENCES `inter_club_matches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_from` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notif_recipient` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tournament_rules`
--
ALTER TABLE `tournament_rules`
  ADD CONSTRAINT `fk_tournament_rules_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tournament_schedule`
--
ALTER TABLE `tournament_schedule`
  ADD CONSTRAINT `fk_tournament_schedule_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `fk_user_achievements_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_equipment`
--
ALTER TABLE `user_equipment`
  ADD CONSTRAINT `fk_user_equipment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `fk_user_preferences_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_stats`
--
ALTER TABLE `user_stats`
  ADD CONSTRAINT `fk_user_stats_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  ADD CONSTRAINT `fk_venue_facilities_venue` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

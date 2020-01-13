-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2019 at 06:12 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelvue_spa`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `reciver` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reciver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(28, '2014_10_12_000000_create_users_table', 1),
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(31, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(32, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(33, '2016_06_01_000004_create_oauth_clients_table', 1),
(34, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(35, '2019_07_18_132337_create_posts_table', 1),
(36, '2019_07_19_103836_create_comments_table', 1),
(37, '2019_07_19_161014_create_reacts_table', 1),
(38, '2019_07_20_104825_create_follows_table', 1),
(39, '2019_07_29_161340_create_usersmeta_table', 1),
(40, '2019_07_29_161719_create_userimages_table', 1),
(41, '2019_07_31_140244_create_conversations_table', 1),
(42, '2019_07_31_140445_create_chats_table', 1),
(43, '2019_08_12_134240_create_activities_table', 1),
(44, '2019_08_31_183651_create_notifications_table', 2),
(45, '2019_09_19_093933_create_feedback_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_to_notify` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('1dc1a857d079b020d095c05dbe6076556a7aa90d31936c7d724b0c0c22b8a4e624572c9ac0905ef6', 3, 2, NULL, '[]', 0, '2019-08-28 13:37:11', '2019-08-28 13:37:11', '2020-08-28 19:07:11'),
('388137ff52e86004f0e4d87d5169ae81e60fbae2ecab4a1a18c569665b2a739aef242fdced598643', 2, 2, NULL, '[]', 0, '2019-09-01 11:12:08', '2019-09-01 11:12:08', '2020-09-01 16:42:08'),
('51bd46376093e312291b19ef3bed55e8bde296d5b135c13adb985d7b8fbf4547d324cee4e8b5f716', 8, 2, NULL, '[]', 0, '2019-09-13 10:37:27', '2019-09-13 10:37:27', '2020-09-13 16:07:27'),
('5ec3b0c2dea19e645dd72a2d49986ac659e5b960fc8890ec492d310a099fe52266e29bf83109582b', 1, 2, NULL, '[]', 0, '2019-09-19 10:12:43', '2019-09-19 10:12:43', '2020-09-19 15:42:43'),
('9e1cf8194a11d1ed48cbc895c7ce58930a5cf6b26a0e4962941bd3917b7f98f2e2f59b3814a9da59', 2, 2, NULL, '[]', 0, '2019-08-31 13:52:51', '2019-08-31 13:52:51', '2020-08-31 19:22:51'),
('cba3b2c5d2154b75976fb6cfa1aa11a8912d7b0bb021d2ac53b2cd7dccfe8c9f174271d97e22be5d', 2, 2, NULL, '[]', 0, '2019-09-17 07:06:53', '2019-09-17 07:06:53', '2020-09-17 12:36:53'),
('cc747ad20306dc4c5f7f0428b2697795d09b610657e7f9f4f347b0a3318918294eaa1a47cd93538a', 2, 2, NULL, '[]', 0, '2019-09-04 12:17:20', '2019-09-04 12:17:20', '2020-09-04 17:47:20'),
('d0e5c4f2d36faa58160b0b082ce1dd61a7ff66648cfee928e2d6be358efc288f55928db5ced75fd2', 7, 2, NULL, '[]', 0, '2019-08-28 14:05:02', '2019-08-28 14:05:02', '2020-08-28 19:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'RkZKu0mTqqMjl7ZSF5pgQCzIWMYuLEpNsOGZx906', 'http://localhost', 1, 0, 0, '2019-08-27 12:22:29', '2019-08-27 12:22:29'),
(2, NULL, 'Laravel Password Grant Client', 'p7buyTJzoidNiwXSkCpumnvhAg4T5Uhkfl47mhm6', 'http://localhost', 0, 1, 0, '2019-08-27 12:22:29', '2019-08-27 12:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-27 12:22:29', '2019-08-27 12:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('046cd8287cb7db011e0def658c6d45170a29b15def8eb6755f45284bea3fe0e601fa9be2954484c2', 'b3fafe22a26dd225d72c90b9b49cab5eb17b711d3ed84935824f32aa5e7c9c28f1453816e62daaf7', 0, '2020-08-28 19:15:33'),
('1203f406a6b58b412f9201b432f5b05ee18c141669e7143e8a9b5dc4ba0c264a1bcf7d3f3d15dcf9', 'cba3b2c5d2154b75976fb6cfa1aa11a8912d7b0bb021d2ac53b2cd7dccfe8c9f174271d97e22be5d', 0, '2020-09-17 12:36:53'),
('180146c19c2169a8710dfac1974de41122c95817acf449502195f279c11bcb033d9dbb6096ddd8be', 'c564dd3757868e41fd175c684723d560762b4b142e76fb3a4e1af0255572808edf15420ed75d0d2b', 0, '2020-09-02 18:21:57'),
('3b46619fe180fdc06aee0a97caf4948c83efcd0a407227305ec61fb439c08aca766e18d97f32ac10', '9e1cf8194a11d1ed48cbc895c7ce58930a5cf6b26a0e4962941bd3917b7f98f2e2f59b3814a9da59', 0, '2020-08-31 19:22:51'),
('435c6b1952a7ca876a5c381a3664d4a5763eb20f1e11ced5daadfc1985af27b4df78b18365f8f2f9', 'b29d78ad52bd3e9818fb9cfe757e9840fbbf974295457835e0bed8cbe1af44233fc5ba12c1a131f2', 0, '2020-08-27 18:50:51'),
('581d420063da95929a409fb8cd9e1bf2288de96419a7123c25d7d68f0b9b6e24d0484c93c8d07668', '5fb4d0228fdb149d2f952171e235a8b8cb9a425acecda063668485bda24c1377f39a470d196c2db2', 0, '2020-09-02 13:37:48'),
('6267a43c0418781d7e3cd1fc34f6db4a83fd8d6a7a0476971c5874eede6dbcee4bbdfea9006ea62f', '08b0f212fa55eb13a896a9732ac0a7cf40d62249537e727873cb73c5df9551282a17ef03a383e5eb', 0, '2020-08-27 18:53:49'),
('6f7be38673ea86fb298b88e3ac145ac6d4bd52d064aed56b79cbffa6babc5dccdc1b0b142ae95c94', '687875bb2d1ef75aeb4816486ba73cf16f81ecc1655a822a598d6baacc84ef40625b5f743b6f6ab1', 0, '2020-08-28 19:28:03'),
('711e6f1cda032a5dba76e0aa053634214989fb721579bd14e4f57eff79fc58ecf714e3e23888bd5d', 'cc576c09b003531826524f4b610d7cffe40450c02e5ec1187e8a70b7291ad2e0c6093b499ebd8be7', 0, '2020-08-28 17:44:39'),
('7bfdea8d66d7260018c7edb1f9f18af6de82383f0b138e6287ee3e690b11f659b05987c5e003e6ee', 'ddb16e00b95d74cc10f291eb97997e54b1ed44d6ddbdb6653e048a2791c792c22b48a2d3f5f5382f', 0, '2020-09-02 19:42:05'),
('860eef99043f2f4cbf6b54e80800547e090c6338865fd4d73a6e4e4e42dc71b301e8a17551f8f663', '5ec3b0c2dea19e645dd72a2d49986ac659e5b960fc8890ec492d310a099fe52266e29bf83109582b', 0, '2020-09-19 15:42:43'),
('8af719dc977b2ca8df1da61f43345688548164f637392655ccb064f217ac55ef95473269e18d9b97', '0ef3d4b0f3bdccc7709cd75a1bc34dacd81d74d01e5942b48c75b0f7bdd2f4a6a2f5c2b3a64374b3', 0, '2020-09-17 12:16:50'),
('9298bb40cfddc3f99e33f5dacbd6ccb0344bcf905ab1e4a5bd76b3eca9839392f96fd087e6860ba2', '50ca58940ef4f770132b47c866ca2ce034111d64372517c2dcb69d7895bdc43de32842ea3371f122', 0, '2020-09-03 19:16:07'),
('9569ea7687b84c2e99c5e2e48bf1a3cecf68cc22aca01eeb36dd056b43e1d0757137d9e3b586546d', 'cc747ad20306dc4c5f7f0428b2697795d09b610657e7f9f4f347b0a3318918294eaa1a47cd93538a', 0, '2020-09-04 17:47:20'),
('abe393d44e613727aa56eb4e978e8089b8b2d71cbe500ffbd175eea9c11ebb30acda3bf566a8b244', '388137ff52e86004f0e4d87d5169ae81e60fbae2ecab4a1a18c569665b2a739aef242fdced598643', 0, '2020-09-01 16:42:08'),
('b31a1e183cf8fca00d53d8bf5ef834cf8af916e4ce9a0ff06307e613b5039ff963285e5ad1df20d2', '209d6f075a83a06e5b17b2f933ad5893a2221e8dd236c50b76a19a1a31d5ac64c2d0c25d642981ef', 0, '2020-09-19 12:30:21'),
('b5c286482c1b0a6ebe0637da4ffe2312523295721ed6dbc5ffa0bd5a9e0ded24cc6732c3feca9e70', 'b6395e904bbcb94e59f99a553b92453f52f51447a11e74ec11687679a044355f8fa05d50c48496de', 0, '2020-09-19 12:35:51'),
('b8c44c2e989d7f9c3dae967e6087667409788800e9594a2fafe78032574f871348d1ee12ef02c177', 'd0e5c4f2d36faa58160b0b082ce1dd61a7ff66648cfee928e2d6be358efc288f55928db5ced75fd2', 0, '2020-08-28 19:35:02'),
('c2c0b287ed2d3ff7e8db0ed1a841a5bbeb487288d9a22b35b5ab5221a35a79248c4c072876e26dbd', '36d38640ac5ccb09bfbb96c18542eace6fec541fcd89cad57fe67ff852134897a94f71583ab9b0d4', 0, '2020-08-28 19:04:33'),
('c58d0c581742ae3440871605099bafa9437f1cd03bc771ed0667d88755dfd52923cfd76bd1baa306', '612a1c84c23e64fb63e8e188c3acf7a4a9fe1872f056a885f6403f4b6569d74100bd98e30102f922', 0, '2020-08-28 19:30:04'),
('cd55ee1ce2dfd408c4e72fde340e2782c6faff97b60797fde5853a91d21154ecbac6875dd35b1a1c', 'a806d45ef5ac5c2fede2310cadbdb44d5ddad2e41cfa7d923417e0b5c22f1848ee7ea0c29757d44e', 0, '2020-09-02 18:16:53'),
('d3c6d4e4878cd6bf9124243cfccfb0cba3bf0282cceef639f6b0aadde44b7400c77466ccd95e28ee', '51bd46376093e312291b19ef3bed55e8bde296d5b135c13adb985d7b8fbf4547d324cee4e8b5f716', 0, '2020-09-13 16:07:27'),
('da08b7f527aced4e969945035a98a834b9299231ea6d103d4a6404678a9672edd60bc3e010098363', '6fd168c5dfd71185326ccf197c8e9b13c2e8f162d5c52ba5d1a993c5afd757c7510623c0f3466531', 0, '2020-09-19 12:32:00'),
('e3bbafe48efa02c9f18fa1aaba820ba915f3a0ca1c28f7759ddeeb39f63bc3a5b67d55b7d31811a4', '1dc1a857d079b020d095c05dbe6076556a7aa90d31936c7d724b0c0c22b8a4e624572c9ac0905ef6', 0, '2020-08-28 19:07:11'),
('e5dd2422daa4b41dfd7dbdc49ecae9659a897610dc668871c0ebecc874d9105497d43a72722f6216', 'a5ed2a1afd7cddd36fa04bf3e35cdaaa88a2be25ce03018b00ae8d3dec011998c2f5044bf1784195', 0, '2020-09-02 13:37:48'),
('fdaa2df0da8b4cbd9aabc0736e0e3ef0ccf8d3974b4c0f7c95efdc9a21bb6a0a7772a8b425cef5a1', '2e1255d4b216d6b2959cca6605a7c8d961eda60a4c7e471069ea8608e0ad9615e889230fafbcca47', 0, '2020-08-27 17:54:59'),
('ff1ea56052480843fe6d6aa1c8050abd0dd6557c6d444dce72394a110a524df138b6247e219e3131', '6a75bd7f9b1a1eeab1b8671eaba3d1c15c83c367c0dd48d3ade36d08e1ad6763f5299065f4c1848b', 0, '2020-08-28 18:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `images`, `user_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Hi!', '1', 1, 1, '2019-09-19 10:09:30', '2019-09-19 10:20:08'),
(2, 'Hello World!', '1', 1, 0, '2019-09-19 10:20:25', '2019-09-19 10:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `reacts`
--

CREATE TABLE `reacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `react` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userimages`
--

CREATE TABLE `userimages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userimages`
--

INSERT INTO `userimages` (`id`, `user_id`, `post_id`, `name`, `type`, `current`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '1568908225_Capture.PNG', 'post', '0', '2019-09-19 10:20:25', '2019-09-19 10:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userinfo` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `userinfo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yash', 'Gupta', 'YashGupta2208', '{\"avatar\":\"primary\",\"background\":\"primary\"}', 'Hello@yashgupta.work', NULL, '$2y$10$Xd5LcwrwkgAkm7KzAg/lMe6YaE7Q63XXNwCaBX5qw9JwqBFcVtvDK', NULL, '2019-09-19 07:05:50', '2019-09-19 07:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `usersmeta`
--

CREATE TABLE `usersmeta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `birthdate` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `social` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usersmeta`
--

INSERT INTO `usersmeta` (`id`, `user_id`, `title`, `description`, `birthdate`, `country`, `state`, `city`, `pincode`, `ip_address`, `settings`, `social`, `created_at`, `updated_at`) VALUES
(1, 1, 'TheSquad.Space User', NULL, NULL, 'India', 'Madhya Pradesh', 'Indore', NULL, NULL, NULL, '{\"facebook\":\"\",\"twitter\":\"\",\"instagram\":\"\"}', '2019-09-19 07:05:50', '2019-09-19 07:06:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reacts`
--
ALTER TABLE `reacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userimages`
--
ALTER TABLE `userimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `usersmeta`
--
ALTER TABLE `usersmeta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reacts`
--
ALTER TABLE `reacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userimages`
--
ALTER TABLE `userimages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usersmeta`
--
ALTER TABLE `usersmeta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

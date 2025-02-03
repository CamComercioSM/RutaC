-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-02-2022 a las 10:06:21
-- Versión del servidor: 5.6.51
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rutac_system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `action_events`
--

CREATE TABLE `action_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_type` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_id` bigint(20) UNSIGNED NOT NULL,
  `target_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'running',
  `exception` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original` mediumtext COLLATE utf8mb4_unicode_ci,
  `changes` mediumtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `action_events`
--

INSERT INTO `action_events` (`id`, `batch_id`, `user_id`, `name`, `actionable_type`, `actionable_id`, `target_type`, `target_id`, `model_type`, `model_id`, `fields`, `status`, `exception`, `created_at`, `updated_at`, `original`, `changes`) VALUES
(1, '9556e632-43c6-4397-9f5c-c7329ab702f5', 1, 'Create', 'App\\Models\\User', 2, 'App\\Models\\User', 2, 'App\\Models\\User', 2, '', 'finished', '', '2022-01-12 21:23:37', '2022-01-12 21:23:37', NULL, '{\"name\":\"Ana\",\"lastname\":\"Rodriguez\",\"position\":\"Jefe de fortalecimiento empresarial\",\"email\":\"jefe.fortalecimiento@ccsm.org.co\",\"updated_at\":\"2022-01-12T16:23:37.000000Z\",\"created_at\":\"2022-01-12T16:23:37.000000Z\",\"id\":2}'),
(2, '95628d70-57e6-48b2-b640-2391d1741cb7', 1, 'Create', 'Spatie\\Permission\\Models\\Permission', 1, 'Spatie\\Permission\\Models\\Permission', 1, 'Spatie\\Permission\\Models\\Permission', 1, '', 'finished', '', '2022-01-18 16:25:22', '2022-01-18 16:25:22', NULL, '{\"guard_name\":\"web\",\"name\":\"web\",\"updated_at\":\"2022-01-18T11:25:22.000000Z\",\"created_at\":\"2022-01-18T11:25:22.000000Z\",\"id\":1}'),
(3, '95628d7d-2515-440b-b55a-09551b8b8e59', 1, 'Create', 'Spatie\\Permission\\Models\\Role', 1, 'Spatie\\Permission\\Models\\Role', 1, 'Spatie\\Permission\\Models\\Role', 1, '', 'finished', '', '2022-01-18 16:25:31', '2022-01-18 16:25:31', NULL, '{\"guard_name\":\"web\",\"name\":\"Administrador\",\"updated_at\":\"2022-01-18T11:25:31.000000Z\",\"created_at\":\"2022-01-18T11:25:31.000000Z\",\"id\":1}'),
(4, '95628e54-820b-4b40-b72e-438f6d5a781c', 1, 'Update', 'App\\Models\\User', 2, 'App\\Models\\User', 2, 'App\\Models\\User', 2, '', 'finished', '', '2022-01-18 16:27:52', '2022-01-18 16:27:52', '[]', '[]'),
(5, '95629895-d0f7-4a45-ac3c-86cc8fd86157', 1, 'Create', 'App\\Models\\Company', 1, 'App\\Models\\Company', 1, 'App\\Models\\Company', 1, '', 'finished', '', '2022-01-18 16:56:32', '2022-01-18 16:56:32', NULL, '{\"business_name\":\"Cerobox\",\"nit\":\"900712827\",\"name_legal_representative\":\"Diego Guzman\",\"registration_number\":\"52-14555-2\",\"registration_date\":\"2022-01-18T00:00:00.000000Z\",\"registration_email\":\"contabilidad@cerobox.com\",\"type_person\":\"1\",\"sector\":\"0\",\"size\":\"1\",\"comercial_activity\":\"Desarrollo de software\",\"affiliated\":false,\"department_id\":null,\"municipality_id\":null,\"address\":\"Calle 30 #83-25 Apto 1703\",\"geographic_location\":null,\"telephone\":\"+573173590945\",\"mobile\":null,\"website\":null,\"social_networks\":{\"FACEBOOK\":\"\",\"INSTAGRAM\":\"\",\"LINKEDIN\":\"\",\"TWITTER\":\"\",\"YOUTUBE\":\"\"},\"contact_person\":\"Diego Guzman\",\"contact_position\":\"Gerente\",\"contact_email\":null,\"contact_phone\":null,\"updated_at\":\"2022-01-18T11:56:32.000000Z\",\"created_at\":\"2022-01-18T11:56:32.000000Z\",\"id\":1}'),
(6, '95629c7f-a19e-48a5-8bb7-0b4286d9ab13', 1, 'Create', 'App\\Models\\Program', 3, 'App\\Models\\Program', 3, 'App\\Models\\Program', 3, '', 'finished', '', '2022-01-18 17:07:29', '2022-01-18 17:07:29', NULL, '{\"name\":\"Programa de prueba\",\"description\":\"Esto es una descripcion de prueba\",\"logo\":null,\"benefits\":null,\"requirements\":null,\"duration\":null,\"aimed_at\":null,\"objective\":null,\"determinants\":null,\"Image_procedure\":null,\"required_tools\":null,\"is_virtual\":\"0\",\"person_charge\":\"Nombre de persona\",\"contact_email\":null,\"telephone\":null,\"pqrs_url\":null,\"website\":null,\"stage_id\":\"1\",\"updated_at\":\"2022-01-18T12:07:29.000000Z\",\"created_at\":\"2022-01-18T12:07:29.000000Z\",\"id\":3}'),
(7, '95629e22-8c6f-4ae6-a7d1-2d37d09fd099', 1, 'Create', 'App\\Models\\Capsule', 1, 'App\\Models\\Capsule', 1, 'App\\Models\\Capsule', 1, '', 'finished', '', '2022-01-18 17:12:03', '2022-01-18 17:12:03', NULL, '{\"name\":\"Capsula de prueba\",\"description\":\"Esto es una descripcion de prueba\",\"url_video\":null,\"updated_at\":\"2022-01-18T12:12:03.000000Z\",\"created_at\":\"2022-01-18T12:12:03.000000Z\",\"id\":1}'),
(8, '9562a36a-4f8c-412a-b7ac-a2c03f475d96', 1, 'Create', 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, '', 'finished', '', '2022-01-18 17:26:49', '2022-01-18 17:26:49', NULL, '{\"name\":\"Pregunta Si o No\",\"type\":\"0\",\"updated_at\":\"2022-01-18T12:26:49.000000Z\",\"created_at\":\"2022-01-18T12:26:49.000000Z\",\"id\":1}'),
(9, '9562a37c-0f6d-4c44-8a4d-2cc48d9945e1', 1, 'Create', 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, '', 'finished', '', '2022-01-18 17:27:01', '2022-01-18 17:27:01', NULL, '{\"name\":\"Pregunta numerica\",\"type\":\"2\",\"updated_at\":\"2022-01-18T12:27:01.000000Z\",\"created_at\":\"2022-01-18T12:27:01.000000Z\",\"id\":2}'),
(10, '9562a389-e29b-4916-9a49-4e458d093f41', 1, 'Create', 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, '', 'finished', '', '2022-01-18 17:27:10', '2022-01-18 17:27:10', NULL, '{\"name\":\"Pregunta de archivo\",\"type\":\"3\",\"updated_at\":\"2022-01-18T12:27:10.000000Z\",\"created_at\":\"2022-01-18T12:27:10.000000Z\",\"id\":3}'),
(11, '9562a5b0-f558-4562-9f15-1125da019347', 1, 'Create', 'App\\Models\\Variable', 4, 'App\\Models\\Variable', 4, 'App\\Models\\Variable', 4, '', 'finished', '', '2022-01-18 17:33:11', '2022-01-18 17:33:11', NULL, '{\"name\":\"Variable opcion multiple\",\"type\":\"1\",\"values\":[\"Menor a un millon\",\"Entre un millon y dos\",\"Mayor a dos millones\"],\"updated_at\":\"2022-01-18T12:33:11.000000Z\",\"created_at\":\"2022-01-18T12:33:11.000000Z\",\"id\":4}'),
(12, '9562a775-0de7-4f6b-8dcc-4aba9add319a', 1, 'Update', 'App\\Models\\Program', 3, 'App\\Models\\Program', 3, 'App\\Models\\Program', 3, '', 'finished', '', '2022-01-18 17:38:08', '2022-01-18 17:38:08', '{\"duration\":null,\"contact_email\":null}', '{\"duration\":\"6 meses\",\"contact_email\":\"contacto@programa.com\"}'),
(13, '9562a8bf-06c2-44eb-b0ed-2a9e4ab0fca8', 1, 'Update', 'App\\Models\\Capsule', 1, 'App\\Models\\Capsule', 1, 'App\\Models\\Capsule', 1, '', 'finished', '', '2022-01-18 17:41:44', '2022-01-18 17:41:44', '{\"url_video\":null}', '{\"url_video\":\"https:\\/\\/www.youtube.com\\/watch?v=Dx5qFachd3A\"}'),
(14, '9562dd6f-387c-422f-91c3-7d8e62346cfd', 1, 'Update', 'App\\Models\\User', 2, 'App\\Models\\User', 2, 'App\\Models\\User', 2, '', 'finished', '', '2022-01-18 20:09:03', '2022-01-18 20:09:03', '{\"identification\":null,\"password\":\"$2y$10$7hswHvX7ptrIFZtGrNmUH.JUcPX0bH.sidEoPntoVLGyHUacBbrNy\"}', '{\"identification\":\"1082972134\",\"password\":\"$2y$10$p1Uz20SaTqk\\/FqAiypGI7uzDXCBABpdah4nQ1BSIlrxk2LTRKjKxO\"}'),
(15, '9562df8c-ede2-448b-9a16-5494484c81b9', 1, 'Update', 'App\\Models\\User', 2, 'App\\Models\\User', 2, 'App\\Models\\User', 2, '', 'finished', '', '2022-01-18 20:14:58', '2022-01-18 20:14:58', '[]', '[]'),
(16, '9562df97-dc02-4edf-a8c2-c559ea0b94db', 1, 'Update', 'App\\Models\\User', 2, 'App\\Models\\User', 2, 'App\\Models\\User', 2, '', 'finished', '', '2022-01-18 20:15:06', '2022-01-18 20:15:06', '[]', '[]'),
(17, '9562e2f9-8288-4da7-97d2-21eeb312012c', 1, 'Create', 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, '', 'finished', '', '2022-01-18 20:24:33', '2022-01-18 20:24:33', NULL, '{\"name\":\"Cuantos empleados tienes?\",\"type\":\"2\",\"updated_at\":\"2022-01-18T15:24:33.000000Z\",\"created_at\":\"2022-01-18T15:24:33.000000Z\",\"id\":5}'),
(18, '958cca41-54ed-4443-af69-6fd4924be048', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 5, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:20:12', '2022-02-08 16:20:12', NULL, '{\"company_id\":\"1\",\"variable_id\":\"5\",\"value\":\"10\"}'),
(19, '958cd45c-51b6-437b-8dca-cd55f62c2575', 1, 'Create', 'App\\Models\\Program', 1, 'App\\Models\\Program', 1, 'App\\Models\\Program', 1, '', 'finished', '', '2022-02-08 16:48:27', '2022-02-08 16:48:27', NULL, '{\"name\":\"Fundemicromag\",\"description\":\"Programa de prueba para validaciones de sistema de ruta c\",\"benefits\":null,\"requirements\":null,\"duration\":null,\"aimed_at\":null,\"objective\":null,\"determinants\":null,\"required_tools\":null,\"is_virtual\":\"0\",\"person_charge\":\"Nombre persona\",\"contact_email\":\"email persona\",\"telephone\":null,\"pqrs_url\":null,\"website\":null,\"stage_id\":\"1\",\"updated_at\":\"2022-02-08T11:48:27.000000Z\",\"created_at\":\"2022-02-08T11:48:27.000000Z\",\"id\":1}'),
(20, '958cd49b-160d-459a-a106-a14363db55c7', 1, 'Update', 'App\\Models\\Program', 1, 'App\\Models\\Program', 1, 'App\\Models\\Program', 1, '', 'finished', '', '2022-02-08 16:49:08', '2022-02-08 16:49:08', '{\"name\":\"Fundemicromag\"}', '{\"name\":\"FundeMicroMag\"}'),
(21, '958cd4aa-b0ba-4a2c-9283-f6aff337d89b', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Program', 1, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:49:19', '2022-02-08 16:49:19', NULL, '{\"company_id\":\"1\",\"program_id\":\"1\"}'),
(22, '958cd4ba-b1af-4a79-8fc9-bc363e8f3b5a', 1, 'Detach', 'App\\Models\\Company', 1, 'App\\Models\\Program', 1, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:49:29', '2022-02-08 16:49:29', NULL, NULL),
(23, '958cd4d5-3b01-486a-a61c-b4995f1bcc47', 1, 'Detach', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 5, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:49:47', '2022-02-08 16:49:47', NULL, NULL),
(24, '958cd4de-f47d-49d2-b8c5-f065132a67dd', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 5, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:49:53', '2022-02-08 16:49:53', NULL, '{\"company_id\":\"1\",\"variable_id\":\"5\",\"created_at\":{\"date\":\"2022-02-08 11:49:53.400711\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"updated_at\":{\"date\":\"2022-02-08 11:49:53.400714\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"value\":\"10\"}'),
(25, '958cd4e9-13d7-4d25-943f-53542df38091', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Program', 1, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 16:50:00', '2022-02-08 16:50:00', NULL, '{\"company_id\":\"1\",\"program_id\":\"1\"}'),
(26, '958cd7a7-b35c-4ca9-84d6-2739b18d7d57', 1, 'Create', 'App\\Models\\Stage', 1, 'App\\Models\\Stage', 1, 'App\\Models\\Stage', 1, '', 'finished', '', '2022-02-08 16:57:40', '2022-02-08 16:57:40', NULL, '{\"name\":\"Descubrimiento\",\"description\":null,\"updated_at\":\"2022-02-08T11:57:40.000000Z\",\"created_at\":\"2022-02-08T11:57:40.000000Z\",\"id\":1}'),
(27, '958cd7ba-4f70-4c6f-bb8e-6e96a9cd076b', 1, 'Create', 'App\\Models\\Stage', 2, 'App\\Models\\Stage', 2, 'App\\Models\\Stage', 2, '', 'finished', '', '2022-02-08 16:57:52', '2022-02-08 16:57:52', NULL, '{\"name\":\"Nacimiento\",\"description\":null,\"updated_at\":\"2022-02-08T11:57:52.000000Z\",\"created_at\":\"2022-02-08T11:57:52.000000Z\",\"id\":2}'),
(28, '958cd7c4-4b48-4d66-9598-ab159d34c411', 1, 'Create', 'App\\Models\\Stage', 3, 'App\\Models\\Stage', 3, 'App\\Models\\Stage', 3, '', 'finished', '', '2022-02-08 16:57:59', '2022-02-08 16:57:59', NULL, '{\"name\":\"Despegue\",\"description\":null,\"updated_at\":\"2022-02-08T11:57:59.000000Z\",\"created_at\":\"2022-02-08T11:57:59.000000Z\",\"id\":3}'),
(29, '958cd7d3-5b90-4320-a456-e34d889357fb', 1, 'Create', 'App\\Models\\Stage', 4, 'App\\Models\\Stage', 4, 'App\\Models\\Stage', 4, '', 'finished', '', '2022-02-08 16:58:09', '2022-02-08 16:58:09', NULL, '{\"name\":\"Crecimiento\",\"description\":null,\"updated_at\":\"2022-02-08T11:58:09.000000Z\",\"created_at\":\"2022-02-08T11:58:09.000000Z\",\"id\":4}'),
(30, '958cd7e1-b6ba-489f-8aeb-84d3d58638da', 1, 'Create', 'App\\Models\\Stage', 5, 'App\\Models\\Stage', 5, 'App\\Models\\Stage', 5, '', 'finished', '', '2022-02-08 16:58:18', '2022-02-08 16:58:18', NULL, '{\"name\":\"Madurez\",\"description\":null,\"updated_at\":\"2022-02-08T11:58:18.000000Z\",\"created_at\":\"2022-02-08T11:58:18.000000Z\",\"id\":5}'),
(31, '958cdc3f-bbfc-48da-8e49-6a894b034d3c', 1, 'Update', 'App\\Models\\Stage', 1, 'App\\Models\\Stage', 1, 'App\\Models\\Stage', 1, '', 'finished', '', '2022-02-08 17:10:31', '2022-02-08 17:10:31', '{\"name\":\"Descubrimiento\"}', '{\"name\":\"01 - Descubrimiento\"}'),
(32, '958cdf6a-ee69-4478-bb30-f16df8b803b6', 1, 'Create', 'Spatie\\Permission\\Models\\Role', 2, 'Spatie\\Permission\\Models\\Role', 2, 'Spatie\\Permission\\Models\\Role', 2, '', 'finished', '', '2022-02-08 17:19:22', '2022-02-08 17:19:22', NULL, '{\"guard_name\":\"web\",\"name\":\"Coordinador de programa\",\"updated_at\":\"2022-02-08T12:19:22.000000Z\",\"created_at\":\"2022-02-08T12:19:22.000000Z\",\"id\":2}'),
(33, '958cdf79-2d07-4fd6-ad6e-d81726af8d9a', 1, 'Create', 'Spatie\\Permission\\Models\\Role', 3, 'Spatie\\Permission\\Models\\Role', 3, 'Spatie\\Permission\\Models\\Role', 3, '', 'finished', '', '2022-02-08 17:19:32', '2022-02-08 17:19:32', NULL, '{\"guard_name\":\"web\",\"name\":\"Asesores\",\"updated_at\":\"2022-02-08T12:19:32.000000Z\",\"created_at\":\"2022-02-08T12:19:32.000000Z\",\"id\":3}'),
(34, '958ce0f2-b0b2-48a4-a983-b4f7d3b3ecd4', 1, 'Update', 'App\\Models\\User', 1, 'App\\Models\\User', 1, 'App\\Models\\User', 1, '', 'finished', '', '2022-02-08 17:23:39', '2022-02-08 17:23:39', '[]', '[]'),
(35, '958ce12e-72ba-427b-9663-d377a6d78c01', 1, 'Create', 'App\\Models\\User', 3, 'App\\Models\\User', 3, 'App\\Models\\User', 3, '', 'finished', '', '2022-02-08 17:24:18', '2022-02-08 17:24:18', NULL, '{\"name\":\"Coordinador\",\"lastname\":\"Ruta C\",\"identification\":\"123456789\",\"position\":\"Coordinador\",\"email\":\"coordinador@rutac.com\",\"updated_at\":\"2022-02-08T12:24:18.000000Z\",\"created_at\":\"2022-02-08T12:24:18.000000Z\",\"id\":3}'),
(36, '958ce159-2650-49c0-820e-4ee584adf203', 1, 'Create', 'App\\Models\\User', 4, 'App\\Models\\User', 4, 'App\\Models\\User', 4, '', 'finished', '', '2022-02-08 17:24:46', '2022-02-08 17:24:46', NULL, '{\"name\":\"Asesor\",\"lastname\":\"Ruta C\",\"identification\":\"123456789\",\"position\":\"Asesor\",\"email\":\"asesor@rutac.com\",\"updated_at\":\"2022-02-08T12:24:46.000000Z\",\"created_at\":\"2022-02-08T12:24:46.000000Z\",\"id\":4}'),
(37, '958cf966-65cc-4908-bd75-5b118982a231', 1, 'Update', 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, '', 'finished', '', '2022-02-08 18:32:01', '2022-02-08 18:32:01', '{\"focus\":\"4\"}', '{\"focus\":\"2\"}'),
(38, '958cf9f6-b923-4b3f-a907-a44dbdd50e06', 1, 'Update', 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, '', 'finished', '', '2022-02-08 18:33:36', '2022-02-08 18:33:36', '{\"percentage\":0}', '{\"percentage\":\"99\"}'),
(39, '958d13e6-2767-4c7b-8733-969411fe708a', 1, 'Update Attached', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 5, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 19:46:07', '2022-02-08 19:46:07', '{\"value\":\"10\"}', '{\"value\":\"5\"}'),
(40, '958d13fa-ee90-47b6-9271-02d954f417f2', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 1, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 19:46:21', '2022-02-08 19:46:21', NULL, '{\"company_id\":\"1\",\"variable_id\":\"1\",\"created_at\":{\"date\":\"2022-02-08 14:46:21.371149\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"updated_at\":{\"date\":\"2022-02-08 14:46:21.371150\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"value\":\"Si\"}'),
(41, '958d140e-ee8f-41a4-ba3b-91de1c188714', 1, 'Attach', 'App\\Models\\Company', 1, 'App\\Models\\Variable', 2, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-08 19:46:34', '2022-02-08 19:46:34', NULL, '{\"company_id\":\"1\",\"variable_id\":\"2\",\"created_at\":{\"date\":\"2022-02-08 14:46:34.488853\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"updated_at\":{\"date\":\"2022-02-08 14:46:34.488855\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"value\":\"56\"}'),
(42, '959ade7c-4ea4-4936-8143-41d3ee774510', 1, 'Update', 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, 'App\\Models\\Variable', 5, '', 'finished', '', '2022-02-15 16:18:21', '2022-02-15 16:18:21', '[]', '[]'),
(43, '959ae348-0afc-4ca2-bd47-0876e1c2f04f', 1, 'Create', 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, '', 'finished', '', '2022-02-15 16:31:46', '2022-02-15 16:31:46', NULL, '{\"name\":\"\\u00bfConsidera que el nivel de satisfacci\\u00f3n de sus clientes es?\",\"dimension\":\"4\",\"percentage\":\"50\",\"type\":\"0\",\"values\":{\"0\":\"No lo mido\",\"33\":\"Bajo\",\"60\":\"Medio\",\"100\":\"Alto\"},\"updated_at\":\"2022-02-15T11:31:46.000000Z\",\"created_at\":\"2022-02-15T11:31:46.000000Z\",\"id\":1}'),
(44, '959ae5f5-c179-42f1-8c7f-3644c8b0fd7c', 1, 'Update', 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, 'App\\Models\\Variable', 1, '', 'finished', '', '2022-02-15 16:39:15', '2022-02-15 16:39:15', '[]', '[]'),
(45, '959ae648-3572-4d69-9e05-bd2fede2a062', 1, 'Create', 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, '', 'finished', '', '2022-02-15 16:40:09', '2022-02-15 16:40:09', NULL, '{\"name\":\"\\u00bfQu\\u00e9 afirmaci\\u00f3n describe mejor su proceso de producci\\u00f3n ?\",\"dimension\":\"4\",\"percentage\":\"30\",\"type\":\"0\",\"values\":{\"0\":\"No se tiene proceso.\",\"33\":\"Hemos dise\\u00f1ado un proceso que no ha sido validado con conocimientos t\\u00e9cnicos pero que se encuentra implementado\",\"60\":\"Tenemos un proceso sofisticado pero no contamos con las herramientas y capital humano suficientes para optimizarlo.\",\"100\":\"Tenemos la capacidad de optimizar nuestro modelo de producci\\u00f3n seg\\u00fan las necesidades del mercado.\"},\"updated_at\":\"2022-02-15T11:40:09.000000Z\",\"created_at\":\"2022-02-15T11:40:09.000000Z\",\"id\":2}'),
(46, '959ae685-2f1c-4629-9ea7-29fcf44fbd32', 1, 'Create', 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, '', 'finished', '', '2022-02-15 16:40:49', '2022-02-15 16:40:49', NULL, '{\"name\":\"\\u00bfCuenta con un presupuesto destinado a la investigaci\\u00f3n y desarrollo de los procesos y tecnolog\\u00edas de la empresa?\",\"dimension\":\"4\",\"percentage\":\"20\",\"type\":\"0\",\"values\":{\"0\":\"No tengo un presupuesto asignado a estas actividades\",\"33\":\"Tengo un rubro poco representativo.\",\"60\":\"Realizo inversiones de acuerdo a necesidades puntuales identificadas\",\"100\":\"Tengo una planeaci\\u00f3n presupuestal adecuada a los objetivos de mi empresa.\"},\"updated_at\":\"2022-02-15T11:40:49.000000Z\",\"created_at\":\"2022-02-15T11:40:49.000000Z\",\"id\":3}'),
(47, '959af2bb-f64f-42cd-97de-ebf79eab92a6', 1, 'Create', 'App\\Models\\Variable', 4, 'App\\Models\\Variable', 4, 'App\\Models\\Variable', 4, '', 'finished', '', '2022-02-15 17:14:59', '2022-02-15 17:14:59', NULL, '{\"name\":\"\\u00bfCantidad de empleados?\",\"type\":\"1\",\"updated_at\":\"2022-02-15T12:14:59.000000Z\",\"created_at\":\"2022-02-15T12:14:59.000000Z\",\"id\":4}'),
(49, '959b0177-2701-4c0f-a4ee-cfabc4942010', 1, 'Update', 'App\\Models\\Company', 1, 'App\\Models\\Company', 1, 'App\\Models\\Company', 1, '', 'finished', '', '2022-02-15 17:56:10', '2022-02-15 17:56:10', '{\"affiliated\":\"0\",\"department_id\":null,\"municipality_id\":null}', '{\"affiliated\":false,\"department_id\":\"5\",\"municipality_id\":\"614\"}'),
(50, '959b2870-1b43-4d0e-9357-2fc256d25600', 1, 'Update', 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, 'App\\Models\\Variable', 3, '', 'finished', '', '2022-02-15 19:45:09', '2022-02-15 19:45:09', '{\"enable_register\":\"0\"}', '{\"enable_register\":true}'),
(51, '959b287b-1685-4978-ad9d-8aec1e04cd35', 1, 'Update', 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, 'App\\Models\\Variable', 2, '', 'finished', '', '2022-02-15 19:45:16', '2022-02-15 19:45:16', '{\"enable_register\":\"0\"}', '{\"enable_register\":true}'),
(52, '959b29dc-f30c-42b8-8ed8-a762a4d4fc75', 1, 'Attach', 'App\\Models\\Variable', 3, 'App\\Models\\Company', 1, 'Illuminate\\Database\\Eloquent\\Relations\\Pivot', NULL, '', 'finished', '', '2022-02-15 19:49:08', '2022-02-15 19:49:08', NULL, '{\"variable_id\":\"3\",\"company_id\":\"1\",\"created_at\":{\"date\":\"2022-02-15 14:49:08.122037\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"updated_at\":{\"date\":\"2022-02-15 14:49:08.122038\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"response\":\"0\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `variable_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `answers`
--

INSERT INTO `answers` (`id`, `company_id`, `variable_id`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, '0', '2022-02-15 19:49:08', '2022-02-15 19:49:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capsules`
--

CREATE TABLE `capsules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `url_video` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `capsules`
--

INSERT INTO `capsules` (`id`, `name`, `description`, `url_video`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Capsula de prueba', 'Esto es una descripcion de prueba', 'https://www.youtube.com/watch?v=Dx5qFachd3A', '2022-01-18 17:12:03', '2022-01-18 17:41:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) NOT NULL COMMENT 'identificador',
  `business_name` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Razon social ',
  `nit` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Nit',
  `registration_number` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Numero de matricula ',
  `registration_date` date NOT NULL COMMENT 'Fecha de matricula',
  `registration_email` varchar(48) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Email registrado en camara de comercio',
  `size` smallint(6) NOT NULL COMMENT 'tamaño (micro - pequeña - mediana - gran empresa)',
  `type_person` tinyint(4) NOT NULL COMMENT 'Tipo de persona ( 0=>natural o 1=>juridica)',
  `sector` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Sector',
  `comercial_activity` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Actividad comercial',
  `name_legal_representative` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Nombre representante legal',
  `affiliated` char(1) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT '0' COMMENT 'Indica si esta afiliada a la camara de comercio',
  `department_id` char(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `municipality_id` char(3) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_spanish2_ci,
  `geographic_location` varchar(200) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'ubicacion geografica',
  `telephone` varchar(15) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Telefono',
  `mobile` varchar(15) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'Celular',
  `website` text COLLATE utf8mb4_spanish2_ci COMMENT 'Sitio web',
  `social_networks` text COLLATE utf8mb4_spanish2_ci COMMENT 'Redes sociales',
  `contact_person` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'persona de contacto',
  `contact_position` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'cargo contacto',
  `contact_email` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'email de contacto ',
  `contact_phone` varchar(15) COLLATE utf8mb4_spanish2_ci DEFAULT NULL COMMENT 'celular de contacto',
  `stage_id` int(11) DEFAULT NULL COMMENT 'indica la etapa en la que se encuentra la empresa',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='almacena la informacion de una empresa';

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `business_name`, `nit`, `registration_number`, `registration_date`, `registration_email`, `size`, `type_person`, `sector`, `comercial_activity`, `name_legal_representative`, `affiliated`, `department_id`, `municipality_id`, `address`, `geographic_location`, `telephone`, `mobile`, `website`, `social_networks`, `contact_person`, `contact_position`, `contact_email`, `contact_phone`, `stage_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cerobox', '900712827', '52-14555-2', '2022-01-18', 'contabilidad@cerobox.com', 1, 1, '0', 'Desarrollo de software', 'Diego Guzman', '0', '5', '614', 'Calle 30 #83-25 Apto 1703', NULL, '+573173590945', NULL, NULL, '{\"FACEBOOK\":\"\",\"INSTAGRAM\":\"\",\"LINKEDIN\":\"\",\"TWITTER\":\"\",\"YOUTUBE\":\"\"}', 'Diego Guzman', 'Gerente', NULL, NULL, NULL, '2022-01-18 16:56:32', '2022-02-15 17:56:10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companie_users`
--

CREATE TABLE `companie_users` (
  `company_id` bigint(20) NOT NULL COMMENT 'empresa',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='asignacion de usuarios a empresas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Bogotá D.C.'),
(2, 'Cundinamarca'),
(3, 'Boyacá'),
(4, 'Tolima'),
(5, 'Antioquia'),
(6, 'Atlántico'),
(7, 'Bolívar'),
(8, 'Quindío'),
(9, 'Caldas'),
(10, 'Caquetá'),
(11, 'Casanare'),
(12, 'Cauca'),
(13, 'Cesar'),
(14, 'Amazonas'),
(15, 'Córdoba'),
(16, 'Huila'),
(17, 'La Guajira'),
(18, 'Magdalena'),
(19, 'Meta'),
(20, 'Nariño'),
(21, 'Norte de Santander'),
(22, 'Santander'),
(23, 'Putumayo'),
(24, 'Risaralda'),
(25, 'Sucre'),
(26, 'Valle'),
(27, 'Vichada'),
(28, 'Arauca'),
(29, 'Chocó'),
(30, 'Guainía'),
(31, 'Guaviare'),
(32, 'Archipiélago de San Andrés, Providencia y Santa Catalina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_01_01_000000_create_action_events_table', 1),
(4, '2019_05_10_000000_add_fields_to_action_events_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_01_18_111424_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipalities`
--

CREATE TABLE `municipalities` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'identificador del municipio',
  `department_id` int(10) UNSIGNED NOT NULL COMMENT 'identificador de la region',
  `name` varchar(50) NOT NULL COMMENT 'nombre del municipio',
  `type_id` int(10) UNSIGNED NOT NULL COMMENT 'identificador del tipo de municipio',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='almacena los municipios de un departamaneto';

--
-- Volcado de datos para la tabla `municipalities`
--

INSERT INTO `municipalities` (`id`, `department_id`, `name`, `type_id`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 1, 'Bogotá', 1, NULL, '2017-03-24 21:18:05', '2017-03-24 21:16:38'),
(2, 2, 'Zipaquirá', 2, NULL, '2017-04-18 21:16:29', '2017-03-24 21:44:14'),
(3, 2, 'Choachí', 5, NULL, '2017-04-18 21:16:09', '2017-03-28 02:03:51'),
(4, 5, 'Abejorral', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(5, 5, 'Apartado', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(6, 5, 'Arboletes', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(7, 5, 'Barbosa', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(8, 5, 'Bello', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(9, 5, 'Caldas', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(10, 5, 'Carepa', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(11, 5, 'Caucasia', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(12, 5, 'Concordia', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(13, 5, 'Copacabana', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(14, 5, 'Currulao', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(15, 5, 'Don matias', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(16, 5, 'Doradal', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(17, 5, 'El carmen de viboral', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(18, 5, 'El santuario', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(19, 5, 'Envigado', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(20, 5, 'Fredonia', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(21, 5, 'Girardota', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(22, 5, 'Guarne', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(23, 5, 'Guatape ', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(24, 5, 'Itagui', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(25, 5, 'Jerico', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(26, 5, 'La ceja', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(27, 5, 'La estrella', 2, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(28, 5, 'La pintada', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(29, 5, 'La union', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(30, 5, 'Marinilla', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(31, 5, 'Peñol', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(32, 5, 'Puerto triunfo', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(33, 5, 'Retiro', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(34, 5, 'Rionegro', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(35, 5, 'Sabaneta', 2, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(36, 5, 'San antonio de prado', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(37, 5, 'San carlos', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(38, 5, 'San cristobal', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(39, 5, 'Santa barbara', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(40, 5, 'Santafe de antioquia', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(41, 5, 'Segovia', 4, NULL, '2017-04-18 21:40:50', '2017-04-18 21:40:50'),
(42, 5, 'Puerto berrio', 4, NULL, '2017-04-18 21:59:23', '2017-04-18 21:59:23'),
(43, 6, 'Baranoa', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(44, 6, 'Campeche', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(45, 6, 'Campo de la cruz', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(46, 6, 'Galapa', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(47, 6, 'Juan de acosta', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(48, 6, 'Jauan mina', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(49, 6, 'Luruaco', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(50, 6, 'Malambo', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(51, 6, 'Manati', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(52, 6, 'Palmar de varela', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(53, 6, 'Piojo', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(54, 6, 'Polo nuevo', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(55, 6, 'Puerto colombia', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(56, 6, 'Sabanagrande', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(57, 6, 'Sabanalarga', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(58, 6, 'Santo tomas', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(59, 6, 'Soledad', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(60, 6, 'Suan', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(61, 6, 'Tubara', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(62, 6, 'Usiacuri', 4, NULL, '2017-04-18 22:04:50', '2017-04-18 22:04:50'),
(63, 8, 'Buenavista', 4, NULL, '2017-04-18 22:16:30', '2017-04-18 22:16:30'),
(64, 7, 'Arjona', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(65, 7, 'Bayunca', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(66, 7, 'Calamar', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(67, 7, 'Cantagallo', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(68, 7, 'Clemencia', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(69, 7, 'El carmen de bolivar', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(70, 7, 'Magangue', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(71, 7, 'Malagana', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(72, 7, 'Maria la baja', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(73, 7, 'San estanislao', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(74, 7, 'San jacinto', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(75, 7, 'San juan de nepomuceno', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(76, 7, 'San pablo', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(77, 7, 'Santa rosa de lima', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(78, 7, 'Talaigua', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(79, 7, 'Turbaco', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(80, 7, 'Turbana', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(81, 7, 'Villanueva', 4, NULL, '2017-04-18 22:09:50', '2017-04-18 22:09:50'),
(82, 3, 'Almeida', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(83, 3, 'Aquitania', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(84, 3, 'Arcabuco', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(85, 3, 'Belen', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(86, 3, 'Belencito', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(87, 3, 'Berbeo', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(88, 3, 'Beteitiva', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(89, 3, 'Boyaca', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(90, 3, 'Briceño', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(91, 3, 'Buenavista', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(92, 3, 'Busbanza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(93, 3, 'Caldas', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(94, 3, 'Campohermoso', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(95, 3, 'Cerinza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(96, 3, 'Chinavita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(97, 3, 'Chiquiza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(98, 3, 'Chiscas', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(99, 3, 'Chita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(100, 3, 'Chivata', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(101, 3, 'Cienaga', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(102, 3, 'Combita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(103, 3, 'Covarachia', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(104, 3, 'Cucaita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(105, 3, 'Duitama', 2, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(106, 3, 'El cocuy', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(107, 3, 'El espino', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(108, 3, 'Firavitova', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(109, 3, 'Florecita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(110, 3, 'Gachanvita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(111, 3, 'Guacamayas', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(112, 3, 'Guayata', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(113, 3, 'Iza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(114, 3, 'La capilla', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(115, 3, 'La victoria', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(116, 3, 'Labranzagrande', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(117, 3, 'Maripi', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(118, 3, 'Miraflores', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(119, 3, 'Mongua', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(120, 3, 'Mongui', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(121, 3, 'Moniquira', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(122, 3, 'Motavita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(123, 3, 'Nobsa', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(124, 3, 'Oicata', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(125, 3, 'Paez', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(126, 3, 'Paipa', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(127, 3, 'Pajarito', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(128, 3, 'Panqueba', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(129, 3, 'Pauna', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(130, 3, 'Paz de rio', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(131, 3, 'Pesca', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(132, 3, 'Puerto boyaca', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(133, 3, 'Ramiriqui', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(134, 3, 'Raquira', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(135, 3, 'Rondon', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(136, 3, 'Saboya', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(137, 3, 'Sachica', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(138, 3, 'Samaca', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(139, 3, 'San eduardo', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(140, 3, 'San jose de pare', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(141, 3, 'San luis de gaceno', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(142, 3, 'San mateo', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(143, 3, 'Santa maria', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(144, 3, 'Santa rosa de viterbo', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(145, 3, 'Santa sofia', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(146, 3, 'Santana', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(147, 3, 'Siachoque', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(148, 3, 'Soata', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(149, 3, 'Socha', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(150, 3, 'Socota', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(151, 3, 'Sogamoso', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(152, 3, 'Somondoco', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(153, 3, 'Sora', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(154, 3, 'Sotaquira', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(155, 3, 'Sutamarchan', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(156, 3, 'Sutatenza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(157, 3, 'Tenza', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(158, 3, 'Tibana', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(159, 3, 'Tibasosa', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(160, 3, 'toca', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(161, 3, 'Topaga', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(162, 3, 'Turmeque', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(163, 3, 'Umbita', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(164, 3, 'Ventaquemada', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(165, 3, 'Villa de leyva', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(166, 3, 'Viracacha', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(167, 3, 'Zetaquira', 4, NULL, '2017-04-18 22:12:50', '2017-04-18 22:12:50'),
(168, 9, 'Aguadas', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(169, 9, 'Alvarado', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(170, 9, 'Anserma', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(171, 9, 'Aranzazu', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(172, 9, 'Arauca', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(173, 9, 'Bajo tablazo', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(174, 9, 'Belancazar', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(175, 9, 'Bolivia', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(176, 9, 'Chinchina', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(177, 9, 'Filadelfia', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(178, 9, 'Gurinocito', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(179, 9, 'La dorada', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(180, 9, 'La linda', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(181, 9, 'La merced', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(182, 9, 'Manzanares', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(183, 9, 'Marmato', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(184, 9, 'Marquetalia', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(185, 9, 'Neira', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(186, 9, 'Nocasia', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(187, 9, 'Nuevo colon', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(188, 9, 'Pacora', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(189, 9, 'Palestina', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(190, 9, 'Pensilvania', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(191, 9, 'Riosucio', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(192, 9, 'Risaralda', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(193, 9, 'Salamina', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(194, 9, 'Samana', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(195, 9, 'Victoria', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(196, 9, 'Villamaria', 5, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(197, 9, 'Viterbo', 4, NULL, '2017-04-18 22:20:50', '2017-04-18 22:20:50'),
(198, 10, 'Curillo', 4, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(199, 10, 'Florencia', 3, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(200, 10, 'La montañita', 4, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(201, 10, 'Puerto rico', 4, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(202, 10, 'San jose del fragua', 4, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(203, 10, 'Solita', 4, NULL, '2017-04-18 23:10:50', '2017-04-18 23:10:50'),
(204, 11, 'Aguazul', 4, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(205, 11, 'Mani', 4, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(206, 11, 'Monterrey', 4, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(207, 11, 'Tauramena', 4, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(208, 11, 'Villanueva', 4, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(209, 11, 'Yopal', 5, NULL, '2017-04-18 23:15:50', '2017-04-18 23:15:50'),
(210, 12, 'Argelia', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(211, 12, 'Blaboa', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(212, 12, 'Bolivar', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(213, 12, 'Cajibio', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(214, 12, 'Caloto', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(215, 12, 'El bordo', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(216, 12, 'El plateado', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(217, 12, 'El tambo', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(218, 12, 'Guachene', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(219, 12, 'Miranda', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(220, 12, 'Morales', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(221, 12, 'Ortigal', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(222, 12, 'Padilla', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(223, 12, 'Piendamo', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(224, 12, 'Popayan', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(225, 12, 'Puerto tejada', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(226, 12, 'Santander de quilichao', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(227, 12, 'Silvia', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(228, 12, 'Suarez', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(229, 12, 'Tunia', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(230, 12, 'Villa rica', 4, NULL, '2017-04-18 23:20:10', '2017-04-18 23:16:50'),
(231, 13, 'Aguachica', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(232, 13, 'Astrea', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(233, 13, 'Becerril', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(234, 13, 'Bosconia', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(235, 13, 'Chimichagua', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(236, 13, 'Chiriguana', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(237, 13, 'Codazzi', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(238, 13, 'Curumani', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(239, 13, 'El copey', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(240, 13, 'La loma', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(241, 13, 'La mata', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(242, 13, 'La paz', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(243, 13, 'La sierra', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(244, 13, 'Las vegas', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(245, 13, 'Pailitas', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(246, 13, 'Pelaya', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(247, 13, 'Pueblo bello', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(248, 13, 'San alberto', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(249, 13, 'San diego', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(250, 13, 'San martin', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(251, 13, 'San roque', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(252, 13, 'Tamalameque', 4, NULL, '2017-04-18 23:16:50', '2017-04-18 23:16:50'),
(253, 9, 'San jose', 4, NULL, '2017-04-18 23:30:23', '2017-04-18 23:30:23'),
(254, 9, 'Supia', 4, NULL, '2017-04-18 23:30:23', '2017-04-18 23:30:23'),
(255, 15, 'Ayapel', 4, NULL, '2017-04-18 23:30:23', '2017-04-18 23:30:23'),
(256, 15, 'Canalete', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(257, 15, 'Carrillo', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(258, 15, 'Cerrete', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(259, 15, 'Chinu', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(260, 15, 'Cienaga de oro', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(261, 15, 'Colon', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(262, 15, 'El porvenir', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(263, 15, 'Lorica', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(264, 15, 'Momil', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(265, 15, 'Montelibano', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(266, 15, 'Monteria', 2, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(267, 15, 'Planeta rica', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(268, 15, 'Puerto escondido', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(269, 15, 'Purisima', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(270, 15, 'Sahagun', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(271, 15, 'San andres de sotavento', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(272, 15, 'San antero', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(273, 15, 'San carlos', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(274, 15, 'San pelayo', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(275, 15, 'Tuchin', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(276, 15, 'Valencia', 4, NULL, '2017-04-18 23:30:24', '2017-04-18 23:30:24'),
(277, 2, 'Arbelaez', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(278, 2, 'Cabrera', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(279, 2, 'Caparrapi', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(280, 2, 'Chaguani', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(281, 2, 'Gachala', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(282, 2, 'Junin', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(283, 2, 'La palma', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(284, 2, 'La victoria', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(285, 2, 'Medina', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(286, 2, 'Paratebueno', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(287, 2, 'Puente piedra', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(288, 2, 'Puerto salgar', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(289, 2, 'Puli', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(290, 2, 'Quebradanegra', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(291, 2, 'Quipile', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(292, 2, 'Ricaurte', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(293, 2, 'San bernardo', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(294, 2, 'Silvania', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(295, 2, 'Simijaca', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(296, 2, 'Subia', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(297, 2, 'Tibacuy', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(298, 2, 'Topaipi', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(299, 2, 'Yacopi', 4, NULL, '2017-04-18 23:30:25', '2017-04-18 23:30:25'),
(300, 20, 'Aldana', 4, NULL, '2017-04-18 23:55:48', '2017-04-18 23:55:48'),
(301, 22, 'Aratoca', 4, NULL, '2017-04-19 00:00:28', '2017-04-19 00:00:28'),
(302, 16, 'Acevedo', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(303, 16, 'Aipe', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(304, 16, 'Algeciras', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(305, 16, 'Altamira', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(306, 16, 'Baraya', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(307, 16, 'Belen', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(308, 16, 'Caguan', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(309, 16, 'Campoalegra', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(310, 16, 'Colombia', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(311, 16, 'Elias', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(312, 16, 'Garzon', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(313, 16, 'Gigante', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(314, 16, 'Guadalupe', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(315, 16, 'Guayabal', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(316, 16, 'Hobo', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(317, 16, 'Iquira', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(318, 16, 'La argentina', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(319, 16, 'La plata', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(320, 16, 'Oropara', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(321, 16, 'Pacarni', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(322, 16, 'Paicol', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(323, 16, 'Palermo', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(324, 16, 'Palestina', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(325, 16, 'Pital', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(326, 16, 'Pitalito', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(327, 16, 'Rivera', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(328, 16, 'San agustin', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(329, 16, 'San jose de isnos', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(330, 16, 'Santa maria', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(331, 16, 'Suaza', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(332, 16, 'Taqui', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(333, 16, 'Tello', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(334, 16, 'Teruel', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(335, 16, 'Tesalia', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(336, 16, 'Timana', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(337, 16, 'Ulloa', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(338, 16, 'Villa vieja', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(339, 16, 'Yaguara', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(340, 16, 'Zuluaga', 4, NULL, '2017-04-18 11:43:00', '2017-04-18 11:43:00'),
(341, 17, 'Albania la guajira', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(342, 17, 'Barrancas', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(343, 17, 'Distraccion', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(344, 17, 'Fonseca', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(345, 17, 'La mina', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(346, 17, 'La paz', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(347, 17, 'Maicao', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(348, 17, 'Manaure', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(349, 17, 'Mingueo', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(350, 17, 'Riohacha', 5, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(351, 17, 'San juan del cesar', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(352, 17, 'Uribia', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(353, 17, 'Villanueva', 4, NULL, '2017-04-18 11:43:01', '2017-04-18 11:43:01'),
(354, 18, 'Aracataca', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(355, 18, 'Cienaga', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(356, 18, 'Fundación', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(357, 18, 'Gaira', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(358, 18, 'La gran via', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(359, 18, 'Pijao', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(360, 18, 'Pivijay', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(361, 18, 'Santa ana', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(362, 18, 'Sitio nuevo', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(363, 18, 'Taganga', 4, NULL, '2017-04-18 11:43:02', '2017-04-18 11:43:02'),
(364, 19, 'Alto Pompeya', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(365, 19, 'Apiay', 5, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(366, 19, 'Brranca de upia', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(367, 19, 'Castilla la nueva', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(368, 19, 'Cubarral', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(369, 19, 'Cumaral', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(370, 19, 'El calvario', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(371, 19, 'El castillo', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(372, 19, 'El dorado', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(373, 19, 'Fuente de oro', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(374, 19, 'Granada', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(375, 19, 'Guamal', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(376, 19, 'La palmera', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(377, 19, 'Lejanias', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(378, 19, 'Pachaquiaro', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(379, 19, 'Puerto concordia', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(380, 19, 'Puerto gaitan', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(381, 19, 'Puerto lleras', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(382, 19, 'Puerto lopez', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(383, 19, 'Puerto rico', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(384, 19, 'Restrepo', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(385, 19, 'San juan de arama', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(386, 19, 'San juanito', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(387, 19, 'San martin', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(388, 19, 'Vistahermosa', 4, NULL, '2017-04-18 11:43:03', '2017-04-18 11:43:03'),
(389, 20, 'Belen', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(390, 20, 'Buesaco', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(391, 20, 'Catmbuco', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(392, 20, 'Chachagi', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(393, 20, 'Consaca', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(394, 20, 'Contadero', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(395, 20, 'Cumbal', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(396, 20, 'El encano', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(397, 20, 'El tambo', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(398, 20, 'Genova', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(399, 20, 'Gauchal', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(400, 20, 'Guaitarila', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(401, 20, 'Gualmatan', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(402, 20, 'Ipiales', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(403, 20, 'La cruz', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(404, 20, 'La florida', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(405, 20, 'La llanada', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(406, 20, 'La union', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(407, 20, 'Nariño', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(408, 20, 'Samaniego', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(409, 20, 'San pablo', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(410, 20, 'Sandona', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(411, 20, 'Taminango', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(412, 20, 'Tiquerres', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(413, 20, 'Yacuanquer', 4, NULL, '2017-04-18 11:43:04', '2017-04-18 11:43:04'),
(414, 21, 'Convencion', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(415, 21, 'El tarra', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(416, 21, 'El zulia', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(417, 21, 'Herran', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(418, 21, 'La donjuana', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(419, 21, 'La vega', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(420, 21, 'Labateca', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(421, 21, 'Los patios', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(422, 21, 'Ocaña', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(423, 21, 'Pamplona', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(424, 21, 'San calixto', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(425, 21, 'Santiago', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(426, 21, 'Sardinata', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(427, 21, 'Tibu', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(428, 21, 'Toledo', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(429, 21, 'Villa caro', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(430, 21, 'Villa del rosario', 4, NULL, '2017-04-18 11:43:05', '2017-04-18 11:43:06'),
(431, 23, 'Puerto caicedo', 4, NULL, '2017-04-18 11:49:07', '2017-04-18 11:49:07'),
(432, 23, 'Puerto guzman', 4, NULL, '2017-04-18 11:49:07', '2017-04-18 11:49:07'),
(433, 23, 'Santana', 4, NULL, '2017-04-18 11:49:07', '2017-04-18 11:49:07'),
(434, 8, 'Barcelona', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(435, 8, 'Buenavista', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(436, 8, 'Calarca', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(437, 8, 'Circasia', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(438, 8, 'Cordoba', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(439, 8, 'El caimo', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(440, 8, 'Finlandia', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(441, 8, 'Genova', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(442, 8, 'La tebaida', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(443, 8, 'Montenegro', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(444, 8, 'Pueblo tapado', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(445, 8, 'Quimbaya', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(446, 8, 'Salento', 4, NULL, '2017-04-18 11:49:08', '2017-04-18 11:49:08'),
(447, 24, 'Apia', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(448, 24, 'Balboa', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(449, 24, 'Belen de umbria', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(450, 24, 'Dosquebradas', 2, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(451, 24, 'El crucero de combia', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(452, 24, 'Guatica', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(453, 24, 'Irra', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(454, 24, 'La celia', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(455, 24, 'La virginia', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(456, 24, 'Marsella', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(457, 24, 'Mistrato', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(458, 24, 'Publo rico', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(459, 24, 'Quinchia', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(460, 24, 'Santa rosa de cabal', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(461, 24, 'Santuario', 4, NULL, '2017-04-18 11:49:09', '2017-04-18 11:49:09'),
(462, 22, 'Acapulco', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(463, 22, 'Albania', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(464, 22, 'Barbosa', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(465, 22, 'Barichara', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(466, 22, 'Barrancabermeja', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(467, 22, 'Capitanejo', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(468, 22, 'Charala', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(469, 22, 'Cite', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(470, 22, 'Curiti', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(471, 22, 'El centro', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(472, 22, 'El playon', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(473, 22, 'Floridablanca', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(474, 22, 'Giron', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(475, 22, 'Guepsa', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(476, 22, 'La belleza', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(477, 22, 'Lebrija', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(478, 22, 'Los laureles', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(479, 22, 'Malaga', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(480, 22, 'Oiba', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(481, 22, 'Olival', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(482, 22, 'Paramo', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(483, 22, 'Piedecuesta', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(484, 22, 'Pinchote', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(485, 22, 'Puente nacional', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(486, 22, 'Rionegro', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(487, 22, 'Sabana de torres', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(488, 22, 'San andres', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(489, 22, 'San gil', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(490, 22, 'San jose de miranda', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(491, 22, 'San miguel', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(492, 22, 'San vicente de chucuri', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(493, 22, 'Socorro', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(494, 22, 'Suaita', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(495, 22, 'Tienda nueva', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(496, 22, 'Vado real', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(497, 22, 'Valle de san jose', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(498, 22, 'Velez', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(499, 22, 'Villanueva', 4, NULL, '2017-04-18 11:49:10', '2017-04-18 11:49:10'),
(500, 25, 'Buenavista', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(501, 25, 'Chalan', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(502, 25, 'Corozal', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(503, 25, 'Coveñas', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(504, 25, 'Galeras', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(505, 25, 'Morroa', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(506, 25, 'Sampues', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(507, 25, 'San juan de betulia', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(508, 25, 'San onofre', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(509, 25, 'Sincelejo', 4, NULL, '2017-04-18 11:49:11', '2017-04-18 11:49:11'),
(510, 4, 'Alvarado ', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(511, 4, 'Ambalema', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(512, 4, 'Armero', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(513, 4, 'Ataco', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(514, 4, 'Buenos aires', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(515, 4, 'Cajamarca', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(516, 4, 'Carmen de apicala', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(517, 4, 'Casablanca', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(518, 4, 'Chaparral', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(519, 4, 'Chicoral', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(520, 4, 'Coyaima', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(521, 4, 'Cunday', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(522, 4, 'Falan', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(523, 4, 'Flandes', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(524, 4, 'Fresno', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(525, 4, 'Gualandai', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(526, 4, 'Guamo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(527, 4, 'Herveo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(528, 4, 'Hondo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(529, 4, 'Icononzo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(530, 4, 'Lerida', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(531, 4, 'Libano', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(532, 4, 'Mariquita', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(533, 4, 'Murillo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(534, 4, 'Natagaima', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(535, 4, 'Ortega', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(536, 4, 'Pajonales', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(537, 4, 'Palocabildo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(538, 4, 'Piedras', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(539, 4, 'Planadas', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(540, 4, 'Purificación', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(541, 4, 'Rioblanco', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(542, 4, 'Roncesvalles', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(543, 4, 'Rovira', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(544, 4, 'Saldaña', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(545, 4, 'San antonio', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(546, 4, 'San luis', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(547, 4, 'Suarez', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(548, 4, 'Valle de san juan', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(549, 4, 'Venadillo', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(550, 4, 'Villa hermosa', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(551, 4, 'Villarrica', 4, NULL, '2017-04-18 11:49:12', '2017-04-18 11:49:12'),
(552, 26, 'Alcala', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(553, 26, 'Andalucia', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(554, 26, 'Anserma', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(555, 26, 'Argelia', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(556, 26, 'Bolivar', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(557, 26, 'Borrero ayerbe', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(558, 26, 'Buga', 3, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(559, 26, 'Bugalagrande', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(560, 26, 'Caicedonia', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(561, 26, 'Candelaria', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(562, 26, 'Cartago', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(563, 26, 'Cascajali', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(564, 26, 'Dagua', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(565, 26, 'Darien', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(566, 26, 'El aguila', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(567, 26, 'El cabuyal', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(568, 26, 'El cairo', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(569, 26, 'El carmelo', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(570, 26, 'El cerrito', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(571, 26, 'El dovio', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(572, 26, 'El placer', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(573, 26, 'El saladito', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(574, 26, 'Florida', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(575, 26, 'Ginebra', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(576, 26, 'Guabitas', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(577, 26, 'Guacari', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(578, 26, 'Jamundi', 5, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(579, 26, 'La cumbre', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(580, 26, 'La paila', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(581, 26, 'La union', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(582, 26, 'La victoria', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(583, 26, 'Obando', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(584, 26, 'Palmira', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(585, 26, 'Pradera', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(586, 26, 'Restrepo', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(587, 26, 'Roldanillo', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(588, 26, 'Rozo', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(589, 26, 'San antonio de los caballeros', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(590, 26, 'San pedro', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(591, 26, 'Santa Elena', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(592, 26, 'Sevilla', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(593, 26, 'Toro', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(594, 26, 'Tulua', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(595, 26, 'Ulloa', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(596, 26, 'Uribe uribe', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(597, 26, 'Versalles', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(598, 26, 'Vijes', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(599, 26, 'Villa gorgona', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(600, 26, 'Yotoco', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(601, 26, 'Yumbo', 2, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(602, 26, 'Zaragoza', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(603, 26, 'Zarzal', 4, NULL, '2017-04-18 11:49:13', '2017-04-18 11:49:13'),
(604, 2, 'Beltran ', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(605, 2, 'Briceño ', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(606, 2, 'Chia', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(607, 2, 'Cota', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(608, 2, 'Funza', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(609, 2, 'Madrid', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(610, 2, 'Mosquera', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(611, 2, 'Soacha', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(612, 2, 'Sopo', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(613, 2, 'Tocancipa', 1, NULL, '2017-04-18 23:38:15', '2017-04-18 23:38:15'),
(614, 5, 'Medellin', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(615, 6, 'Barranquilla', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(616, 7, 'Cartagena', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(617, 3, 'Tunja', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(618, 9, 'Manizales', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(619, 13, 'Valledupar', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(620, 16, 'Neiva', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(621, 18, 'Santa marta', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(622, 19, 'Villavicencio', 3, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(623, 20, 'Pasto', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(624, 21, 'Cucuta', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(625, 8, 'Armenia', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(626, 24, 'Pereira', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(627, 22, 'Bucaramanga', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(628, 4, 'Ibague', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(629, 26, 'Cali', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(630, 26, 'Buenaventura', 2, NULL, '2017-04-18 23:38:16', '2017-04-18 23:38:16'),
(631, 3, 'Chiquinquira', 2, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(632, 3, 'Garagoa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(633, 3, 'Guateque', 5, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(634, 3, 'Jenesano', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(635, 3, 'Soraca', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(636, 3, 'Tuta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(637, 2, 'Agua de dios', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(638, 2, 'Alban', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(639, 2, 'Anapoima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(640, 2, 'Anolaima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(641, 2, 'Apulo', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(642, 2, 'Bituima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(643, 2, 'Bojaca', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(644, 2, 'Cachipay', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(645, 2, 'Cajica', 1, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(646, 2, 'Caqueza', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(647, 2, 'Chinauta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(648, 2, 'Chipaque', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(649, 2, 'Choconta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(650, 2, 'Cogua', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(651, 2, 'Cucunuba', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(652, 2, 'Mesitas del colegio', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(653, 2, 'El peñon', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(654, 2, 'El rosal', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(655, 2, 'Facatativa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(656, 2, 'Fomeque', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17');
INSERT INTO `municipalities` (`id`, `department_id`, `name`, `type_id`, `deleted_at`, `updated_at`, `created_at`) VALUES
(657, 2, 'Fusagasuga', 2, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(658, 2, 'Gachancipa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(659, 2, 'Gacheta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(660, 2, 'Girardot', 2, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(661, 2, 'Granada', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(662, 2, 'Guacheta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(663, 2, 'Guaduas', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(664, 2, 'Guasca', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(665, 2, 'Guataqui', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(666, 2, 'Guatavita', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(667, 2, 'Guayabal', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(668, 2, 'Guayabetal', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(669, 2, 'La calera', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(670, 2, 'La florida', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(671, 2, 'La gran via', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(672, 2, 'La mesa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(673, 2, 'La peña', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(674, 2, 'La vega', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(675, 2, 'Leguazaque', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(676, 2, 'Macheta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(677, 2, 'Manta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(678, 2, 'Nemocon', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(679, 2, 'Nilo', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(680, 2, 'Nimaima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(681, 2, 'Nocaima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(682, 2, 'Pacho', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(683, 2, 'Paime', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(684, 2, 'Pasca', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(685, 2, 'Puerto bogota', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(686, 2, 'Quetame', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(687, 2, 'San antonio del tequendama', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(688, 2, 'San francisco', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(689, 2, 'San joaquin', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(690, 2, 'Sam juan de rio seco', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(691, 2, 'Santandercito', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(692, 2, 'Sasaima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(693, 2, 'Sesquile', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(694, 2, 'Sibate', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(695, 2, 'Subachoque', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(696, 2, 'Suesca', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(697, 2, 'Susa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(698, 2, 'Sutatausa', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(699, 2, 'Tabio', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(700, 2, 'Tena', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(701, 2, 'Tenjo', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(702, 2, 'Tibito', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(703, 2, 'Tocaima', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(704, 2, 'Ubala', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(705, 2, 'Ubaque', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(706, 2, 'Ubate', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(707, 2, 'Utica', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(708, 2, 'Venecia', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(709, 2, 'Vergara', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(710, 2, 'Viani', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(711, 2, 'Villapinzon', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(712, 2, 'Villeta', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(713, 2, 'Viota', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(714, 2, 'Zipacon', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(715, 19, 'Acacias', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(716, 19, 'Villavicencio', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(717, 4, 'Espinal', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(718, 4, 'Melgar', 2, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(719, 4, 'Tolemaida', 3, NULL, '2017-04-18 23:38:17', '2017-04-18 23:38:17'),
(720, 14, 'Leticia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(721, 5, 'Abriaqui', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(722, 5, 'Alejandria', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(723, 5, 'Amaga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(724, 5, 'Amalfi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(725, 5, 'Andes', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(726, 5, 'Angostura', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(727, 5, 'Argelia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(728, 5, 'Belmira', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(729, 5, 'Betania', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(730, 5, 'Betulia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(731, 5, 'Briceño', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(732, 5, 'Buritica', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(733, 5, 'Caceres', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(734, 5, 'Campamento', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(735, 5, 'Cañasgordas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(736, 5, 'Caracoli', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(737, 5, 'Caramanta', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(738, 5, 'Carolina', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(739, 5, 'Casabe yondo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(740, 5, 'Chigorodo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(741, 5, 'Cisneros', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(742, 5, 'Ciudad bolivar', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(743, 5, 'Cocorna', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(744, 5, 'Concepción', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(745, 5, 'Dabeiba', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(746, 5, 'El bagre', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(747, 5, 'Entrerios', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(748, 5, 'Frontino', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(749, 5, 'Giraldo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(750, 5, 'Gomez plata', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(751, 5, 'Granada', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(752, 5, 'Guadalupe', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(753, 5, 'Hispania', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(754, 5, 'Jardin', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(755, 5, 'La sierra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(756, 5, 'Maceo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(757, 5, 'Mutata', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(758, 5, 'Nariño', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(759, 5, 'Nechi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(760, 5, 'Necoli', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(761, 5, 'Nueva colonia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(762, 5, 'Palermo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(763, 5, 'Peque', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(764, 5, 'Pueblorrico', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(765, 5, 'Puerto claver', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(766, 5, 'Puerto nare', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(767, 5, 'Puerto perales nuevo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(768, 5, 'Remedios', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(769, 5, 'Salgar', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(770, 5, 'San jeronimo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(771, 5, 'San juan de uraba', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(772, 5, 'San luis', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(773, 5, 'San pedro de los milagros', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(774, 5, 'San pedro de uraba', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(775, 5, 'San rafael', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(776, 5, 'San roque', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(777, 5, 'San vicente', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(778, 5, 'Santa rosa de osos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(779, 5, 'Santo domingo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(780, 5, 'Sonson', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(781, 5, 'Sopetran', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(782, 5, 'Tamesis', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(783, 5, 'Taraza', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(784, 5, 'Tarso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(785, 5, 'Titiribi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(786, 5, 'Turbo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(787, 5, 'Urrao', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(788, 5, 'Valdivia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(789, 5, 'Valparaiso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(790, 5, 'Vegachi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(791, 5, 'Venecia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(792, 5, 'Vigia del fuerte', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(793, 5, 'Yali', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(794, 5, 'Yarumal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(795, 5, 'Yolombo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(796, 5, 'Zaragoza', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(797, 28, 'Arauca', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(798, 28, 'Arauquita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(799, 28, 'Fortul', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(800, 28, 'Saravena', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(801, 28, 'Tame', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(802, 6, 'Aguada de pablo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(803, 6, 'Candelaria', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(804, 6, 'Caracoli', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(805, 6, 'Cascajal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(806, 6, 'La peña', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(807, 6, 'Ponedera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(808, 6, 'Puerto giraldo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(809, 6, 'Repelon', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(810, 6, 'Santa cruz', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(811, 6, 'Santa lucia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(812, 7, 'Achi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(813, 7, 'Barranco', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(814, 7, 'Cicuco', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(815, 7, 'El guamo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(816, 7, 'El peñon', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(817, 7, 'Hatillo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(818, 7, 'Juan arias', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(819, 7, 'Mahates', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(820, 7, 'Margarita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(821, 7, 'Mompos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(822, 7, 'Morales', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(823, 7, 'Pasacaballos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(824, 7, 'Pinillos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(825, 7, 'Punta de cartagena', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(826, 7, 'Rio viejo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(827, 7, 'San cristobal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(828, 7, 'San fernando', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(829, 7, 'San martin de loba', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(830, 7, 'Santa rosa del sur', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(831, 7, 'Simiti', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(832, 7, 'Soplaviento', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(833, 7, 'Tiquisio nuevo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(834, 7, 'Yati', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(835, 7, 'Zambrano', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(836, 3, 'Boavita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(837, 3, 'Chitaraque', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(838, 3, 'Chivor', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(839, 3, 'Coper', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(840, 3, 'Corrales', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(841, 3, 'Cubara', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(842, 3, 'Guican', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(843, 3, 'La uvita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(844, 3, 'Macanal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(845, 3, 'Muzo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(846, 3, 'Otanche', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(847, 3, 'Pachavita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(848, 3, 'Quipama', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(849, 3, 'San miguel de sema', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(850, 3, 'San pablo de borbur', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(851, 3, 'Sativanorte', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(852, 3, 'Sativasur', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(853, 3, 'Tinjaca', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(854, 3, 'Tipacoque', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(855, 3, 'Togui', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(856, 3, 'Trinidad', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(857, 3, 'Tutaza', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(858, 9, 'Marulanda', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(859, 10, 'Albania', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(860, 10, 'Belen de los andaquies', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(861, 10, 'Cartagena del chaira', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(862, 10, 'El doncello', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(863, 10, 'El paujil', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(864, 10, 'San vicente de caguan', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(865, 10, 'Valparaiso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(866, 11, 'Hato corozal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(867, 11, 'Paz de ariporo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(868, 11, 'Pore', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(869, 11, 'Sabanalarga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(870, 11, 'San luis de palenque', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(871, 11, 'Tamara', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(872, 11, 'Trinidad', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(873, 12, 'Corinto', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(874, 12, 'El estrecho', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(875, 12, 'Guapi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(876, 12, 'Mercaderes', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(877, 12, 'Santiago', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(878, 12, 'Timbio', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(879, 13, 'Casacaza', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(880, 13, 'El paso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(881, 13, 'Gamarra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(882, 13, 'La gloria', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(883, 13, 'La jagua de ibirico', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(884, 13, 'Manacure', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(885, 13, 'Mina drumond pribbenow', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(886, 13, 'Rio de oro', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(887, 29, 'Acandi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(888, 29, 'Bahia solano mutis', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(889, 29, 'Belen bajira', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(890, 29, 'Certegui', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(891, 29, 'Condoto', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(892, 29, 'Istmina', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(893, 29, 'Pizarro', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(894, 29, 'Quibdo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(895, 29, 'Riosucio', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(896, 29, 'Tado', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(897, 29, 'Unguia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(898, 29, 'Yuto', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(899, 15, 'Cerromatoso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(900, 15, 'Chima', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(901, 15, 'Cotorra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(902, 15, 'Cotorra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(903, 15, 'La apartada y la frontera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(904, 15, 'Los cordobas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(905, 15, 'Los garzones', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(906, 15, 'Moñitos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(907, 15, 'Pueblo nuevo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(908, 15, 'Puerto libertador', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(909, 15, 'San bernardo del viento', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(910, 15, 'Tierralta', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(911, 2, 'Carmen de carupa', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(912, 2, 'Fosca', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(913, 2, 'Gama', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(914, 2, 'Gutierrez', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(915, 2, 'Jerusalum', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(916, 2, 'Nariño', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(917, 2, 'Pandi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(918, 2, 'Puente quetame', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(919, 2, 'Supata', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(920, 2, 'Villagomez', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(921, 30, 'Puerto inirida', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(922, 31, 'Calamar', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(923, 31, 'San jose del guaviare', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(924, 16, 'Agrado', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(925, 16, 'Bruselas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(926, 16, 'Nataga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(927, 16, 'Saladoblancoi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(928, 17, 'Dibulla', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(929, 17, 'El molino', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(930, 17, 'Hatonuevo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(931, 17, 'Palomino', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(932, 17, 'Paraguachon', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(933, 17, 'Urumita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(934, 18, 'El banco', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(935, 18, 'El dificil', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(936, 18, 'El piñon', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(937, 18, 'El reten', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(938, 18, 'Guamal', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(939, 18, 'Nueva granada', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(940, 18, 'Palermo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(941, 18, 'Plato', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(942, 18, 'Puebloviejo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(943, 18, 'Salamina', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(944, 18, 'San angel', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(945, 18, 'San sebastian de buenavista', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(946, 18, 'Sitio nuevo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(947, 18, 'Tenerife', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(948, 19, 'La macarena', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(949, 19, 'Mapiripan', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(950, 19, 'Mesetas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(951, 19, 'San carlos de guaroa', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(952, 20, 'Alban', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(953, 20, 'Ancuya', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(954, 20, 'Barbacoas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(955, 20, 'Bocas de satinga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(956, 20, 'Cordoba', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(957, 20, 'Cuaspud nucleo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(958, 20, 'El charco', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(959, 20, 'El tablon de gomez', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(960, 20, 'Iscuande', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(961, 20, 'Llorente', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(962, 20, 'Mosquera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(963, 20, 'Olaya herrera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(964, 20, 'Puerres', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(965, 20, 'Pupiales', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(966, 20, 'Ricaurte', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(967, 20, 'Sotomayor', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(968, 20, 'Tumaco', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(969, 21, 'Abrego', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(970, 21, 'Arboledas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(971, 21, 'Bochamela', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(972, 21, 'Cachira', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(973, 21, 'Carcasi', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(974, 21, 'Chinacota', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(975, 21, 'Cucutilla', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(976, 21, 'Duraina', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(977, 21, 'El carmen', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(978, 21, 'Gramalote', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(979, 21, 'Hacari', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(980, 21, 'La floresta', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(981, 21, 'La jarra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(982, 21, 'La playa', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(983, 21, 'Lourdes', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(984, 21, 'Matiscua', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(985, 21, 'Pamplonita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(986, 21, 'Puerto santander', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(987, 21, 'Salazar', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(988, 21, 'San bernardo de bata', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(989, 21, 'San cayetano', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(990, 21, 'Teorama', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(991, 23, 'La dorada', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(992, 23, 'La hormiga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(993, 23, 'Mocoa', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(994, 23, 'Orito', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(995, 23, 'Puerto asis', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(996, 23, 'Sibundoy', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(997, 23, 'Villagarzon', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(998, 8, 'Pijao', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(999, 32, 'San andres', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1000, 22, 'Betulia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1001, 22, 'Bolívar', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1002, 22, 'California', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1003, 22, 'Cerrito', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1004, 22, 'Cimitarra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1005, 22, 'Concepción', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1006, 22, 'Confines', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1007, 22, 'Contratación', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1008, 22, 'Coromoro', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1009, 22, 'El carmen de chucurri', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1010, 22, 'Encino', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1011, 22, 'Enciso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1012, 22, 'Guaca', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1013, 22, 'Jesus maria', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1014, 22, 'Landazuri', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1015, 22, 'Los santos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1016, 22, 'Mogotes', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1017, 22, 'Molagavita', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1018, 22, 'Ocamonte', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1019, 22, 'Onzaga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1020, 22, 'Puente sogamoso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1021, 22, 'Puerto araujo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1022, 22, 'Puerto parra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1023, 22, 'Puerto wilches', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1024, 22, 'Simacota', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1025, 22, 'Sogamoso', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1026, 22, 'Zapatoca', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1027, 25, 'Caimito', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1028, 25, 'La union', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1029, 25, 'Los palmitos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1030, 25, 'Majagual', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1031, 25, 'Ovejas', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1032, 25, 'San benito', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1033, 25, 'San marcos', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1034, 25, 'San pedro', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1035, 25, 'Since', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1036, 25, 'Sucre', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1037, 25, 'Tolu viejo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1038, 25, 'Tolu', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1039, 4, 'Alpujarra', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1040, 4, 'Anzoategui', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1041, 4, 'Dolores', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1042, 4, 'Gaitana', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1043, 4, 'Herrera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1044, 4, 'Prado', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1045, 4, 'Santa isabel', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1046, 4, 'Santiago perez', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1047, 26, 'Amaime', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1048, 26, 'Bahia malaga', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1049, 26, 'Rio frio', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1050, 26, 'Trujillo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1051, 27, 'Cumaribo', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1052, 27, 'La primavera', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18'),
(1053, 27, 'Santa rosalia', 5, NULL, '2017-04-18 23:38:18', '2017-04-18 23:38:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'web', 'web', '2022-01-18 16:25:22', '2022-01-18 16:25:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `logo` text,
  `benefits` text,
  `requirements` text,
  `duration` varchar(255) DEFAULT NULL,
  `aimed_at` text,
  `objective` text,
  `determinants` text,
  `image_procedure` text,
  `required_tools` text,
  `is_virtual` char(1) DEFAULT NULL,
  `person_charge` varchar(255) DEFAULT NULL,
  `contact_email` varchar(48) DEFAULT NULL,
  `telephone` varchar(48) DEFAULT NULL,
  `pqrs_url` text,
  `website` text,
  `stage_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `programs`
--

INSERT INTO `programs` (`id`, `name`, `description`, `logo`, `benefits`, `requirements`, `duration`, `aimed_at`, `objective`, `determinants`, `image_procedure`, `required_tools`, `is_virtual`, `person_charge`, `contact_email`, `telephone`, `pqrs_url`, `website`, `stage_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'FundeMicroMag', 'Programa de prueba para validaciones de sistema de ruta c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 'Nombre persona', 'email persona', NULL, NULL, NULL, 1, '2022-02-08 16:48:27', '2022-02-08 16:49:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `program_has_companies`
--

CREATE TABLE `program_has_companies` (
  `program_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `program_has_companies`
--

INSERT INTO `program_has_companies` (`program_id`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-02-08 11:50:00', '2022-02-08 11:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin', '2022-01-18 16:25:31', '2022-01-18 16:25:31'),
(2, 'cordinator', 'cordinator', '2022-02-08 17:19:22', '2022-02-08 17:19:22'),
(3, 'adviser', 'adviser', '2022-02-08 17:19:32', '2022-02-08 17:19:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stages`
--

CREATE TABLE `stages` (
  `id` int(11) NOT NULL COMMENT 'identificador',
  `name` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'nombre de la etabla',
  `description` text COLLATE utf8mb4_spanish2_ci COMMENT 'desdcripcion de la etapa',
  `previous_stage_id` int(11) DEFAULT NULL COMMENT 'etapa que precede a la etapa actual, si es principal el campo sera nulo',
  `next_stage_id` int(11) DEFAULT NULL COMMENT 'indica cual es la siguiente etapa, si la etapa actual es la final este campo es nulo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='contiene las etapas en las que puede estar una empresa';

--
-- Volcado de datos para la tabla `stages`
--

INSERT INTO `stages` (`id`, `name`, `description`, `previous_stage_id`, `next_stage_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Descubrimiento', NULL, NULL, 2, '2022-02-08 16:57:40', '2022-02-08 12:11:21', NULL),
(2, 'Nacimiento', NULL, 1, 3, '2022-02-08 16:57:52', '2022-02-08 12:11:23', NULL),
(3, 'Despegue', NULL, 2, 4, '2022-02-08 16:57:59', '2022-02-08 12:11:26', NULL),
(4, 'Crecimiento', NULL, 3, 5, '2022-02-08 16:58:09', '2022-02-08 12:11:28', NULL),
(5, 'Madurez', NULL, 4, NULL, '2022-02-08 16:58:18', '2022-02-08 12:11:30', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identification` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'cedula',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'apellido',
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'cargo',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `identification`, `name`, `lastname`, `email`, `position`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1128406761', 'Diego', 'Guzman', 'clientes@cerobox.com', 'Gerente', NULL, '$2y$10$VpS9t.9rTPOwFiWaC7Z/Ge48WhVmFcqGhTrTmAqLWiAscydrAWuHK', NULL, '2022-01-12 01:30:19', NULL, NULL),
(2, '1082972134', 'Ana', 'Rodriguez', 'jefe.fortalecimiento@ccsm.org.co', 'Jefe de fortalecimiento empresarial', NULL, '$2y$10$p1Uz20SaTqk/FqAiypGI7uzDXCBABpdah4nQ1BSIlrxk2LTRKjKxO', NULL, '2022-01-12 21:23:37', '2022-01-18 20:09:03', NULL),
(3, '123456789', 'Coordinador', 'Ruta C', 'coordinador@rutac.com', 'Coordinador', NULL, '$2y$10$GHhmEcGyDLOx8WL0DANreu684Mk4SdqhzMjgLWClSJ1173nO7VgtC', NULL, '2022-02-08 17:24:18', '2022-02-08 17:24:18', NULL),
(4, '123456789', 'Asesor', 'Ruta C', 'asesor@rutac.com', 'Asesor', NULL, '$2y$10$I09Tw9ms3Wk7ord/92kuYeHVd9O9dxjXWe/eVvyQu0ar0J0N7r10W', NULL, '2022-02-08 17:24:46', '2022-02-08 17:24:46', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variables`
--

CREATE TABLE `variables` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` char(1) NOT NULL,
  `values` text,
  `dimension` char(1) DEFAULT NULL,
  `percentage` int(3) DEFAULT NULL,
  `enable_register` char(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `variables`
--

INSERT INTO `variables` (`id`, `name`, `type`, `values`, `dimension`, `percentage`, `enable_register`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '¿Considera que el nivel de satisfacción de sus clientes es?', '0', '{\"0\":\"No lo mido\",\"33\":\"Bajo\",\"60\":\"Medio\",\"100\":\"Alto\"}', '4', 50, '0', '2022-02-15 16:31:46', '2022-02-15 16:31:46', NULL),
(2, '¿Qué afirmación describe mejor su proceso de producción ?', '0', '{\"0\":\"No se tiene proceso.\",\"33\":\"Hemos dise\\u00f1ado un proceso que no ha sido validado con conocimientos t\\u00e9cnicos pero que se encuentra implementado\",\"60\":\"Tenemos un proceso sofisticado pero no contamos con las herramientas y capital humano suficientes para optimizarlo.\",\"100\":\"Tenemos la capacidad de optimizar nuestro modelo de producci\\u00f3n seg\\u00fan las necesidades del mercado.\"}', '4', 30, '1', '2022-02-15 16:40:09', '2022-02-15 19:45:16', NULL),
(3, '¿Cuenta con un presupuesto destinado a la investigación y desarrollo de los procesos y tecnologías de la empresa?', '0', '{\"0\":\"No tengo un presupuesto asignado a estas actividades\",\"33\":\"Tengo un rubro poco representativo.\",\"60\":\"Realizo inversiones de acuerdo a necesidades puntuales identificadas\",\"100\":\"Tengo una planeaci\\u00f3n presupuestal adecuada a los objetivos de mi empresa.\"}', '4', 20, '1', '2022-02-15 16:40:49', '2022-02-15 19:45:09', NULL),
(4, '¿Cantidad de empleados?', '1', NULL, NULL, NULL, '0', '2022-02-15 17:14:59', '2022-02-15 17:14:59', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `action_events`
--
ALTER TABLE `action_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_events_actionable_type_actionable_id_index` (`actionable_type`,`actionable_id`),
  ADD KEY `action_events_batch_id_model_type_model_id_index` (`batch_id`,`model_type`,`model_id`),
  ADD KEY `action_events_user_id_index` (`user_id`);

--
-- Indices de la tabla `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `capsules`
--
ALTER TABLE `capsules`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nit` (`nit`),
  ADD UNIQUE KEY `registration_number` (`registration_number`),
  ADD KEY `stage_id` (`stage_id`);

--
-- Indices de la tabla `companie_users`
--
ALTER TABLE `companie_users`
  ADD PRIMARY KEY (`company_id`,`user_id`),
  ADD KEY `fk_company_users_users` (`user_id`);

--
-- Indices de la tabla `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `department` (`department_id`) USING BTREE;

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `program_has_companies`
--
ALTER TABLE `program_has_companies`
  ADD UNIQUE KEY `program_id` (`program_id`,`company_id`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `previous_stage_id` (`previous_stage_id`),
  ADD KEY `next_stage_id` (`next_stage_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `variables`
--
ALTER TABLE `variables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `action_events`
--
ALTER TABLE `action_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `capsules`
--
ALTER TABLE `capsules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'identificador del municipio', AUTO_INCREMENT=1266;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `stages`
--
ALTER TABLE `stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `variables`
--
ALTER TABLE `variables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_company_stages` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `companie_users`
--
ALTER TABLE `companie_users`
  ADD CONSTRAINT `fk_company_users_companies` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_company_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

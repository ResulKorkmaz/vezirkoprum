-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: vezirkoprum
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_receiver_id_is_read_index` (`receiver_id`,`is_read`),
  KEY `messages_sender_id_created_at_index` (`sender_id`,`created_at`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_29_171331_create_professions_table',1),(5,'2025_05_29_171335_add_profile_fields_to_users_table',1),(6,'2025_05_29_171339_create_messages_table',1),(7,'2025_05_29_171343_create_whatsapp_groups_table',1),(8,'2025_05_29_195013_add_profile_photo_to_users_table',1),(9,'2025_05_29_202227_add_kvkk_consent_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professions`
--

DROP TABLE IF EXISTS `professions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `professions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=432 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professions`
--

LOCK TABLES `professions` WRITE;
/*!40000 ALTER TABLE `professions` DISABLE KEYS */;
INSERT INTO `professions` VALUES (1,'Doktor',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(2,'Hemşire',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(3,'Öğretmen',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(4,'Mühendis',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(5,'Avukat',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(6,'Polis',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(7,'Asker',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(8,'Muhasebeci',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(9,'Bankacı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(10,'Pazarlama Uzmanı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(11,'İnsan Kaynakları Uzmanı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(12,'Grafik Tasarımcı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(13,'Web Tasarımcı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(14,'Yazılım Geliştirici',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(15,'Sistem Yöneticisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(16,'Veri Analisti',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(17,'Proje Yöneticisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(18,'Satış Temsilcisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(19,'Müşteri Hizmetleri',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(20,'Lojistik Uzmanı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(21,'İnşaat Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(22,'Makine Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(23,'Elektrik Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(24,'Bilgisayar Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(25,'Endüstri Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(26,'Gıda Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(27,'Ziraat Mühendisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(28,'Veteriner',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(29,'Eczacı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(30,'Diş Hekimi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(31,'Fizyoterapist',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(32,'Psikolog',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(33,'Diyetisyen',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(34,'Berber',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(35,'Kuaför',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(36,'Estetisyen',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(37,'Masaj Terapisti',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(38,'Şef',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(39,'Aşçı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(40,'Garson',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(41,'Kasiyer',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(42,'Güvenlik Görevlisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(43,'Temizlik Görevlisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(44,'Şoför',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(45,'Kurye',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(46,'Tamirci',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(47,'Elektrikçi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(48,'Tesisatçı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(49,'Boyacı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(50,'Marangoz',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(51,'Terzi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(52,'Ayakkabı Tamircisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(53,'Saat Tamircisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(54,'Cep Telefonu Tamircisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(55,'Oto Tamircisi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(56,'Lastikçi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(57,'Yedek Parça Satıcısı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(58,'Market Sahibi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(59,'Restoran Sahibi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(60,'Cafe Sahibi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(61,'Otel Sahibi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(62,'Emlak Uzmanı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(63,'Sigorta Uzmanı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(64,'Turizm Rehberi',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(65,'Çevirmen',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(66,'Gazeteci',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(67,'Fotoğrafçı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(68,'Video Editörü',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(69,'Ses Teknisyeni',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(70,'Müzisyen',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(71,'Sanatçı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(72,'Sporcu',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(73,'Antrenör',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(74,'Pilot',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(75,'Hostes',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(76,'Kaptan',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(77,'Makinist',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(78,'İtfaiyeci',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(79,'Paramedik',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(80,'Ambulans Şoförü',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(81,'Serbest Meslek',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(82,'Emekli',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(83,'Öğrenci',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(84,'Ev Hanımı',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(85,'İşsiz',1,'2025-05-30 04:24:50','2025-05-30 04:24:50'),(86,'Diğer',1,'2025-05-30 04:24:50','2025-05-30 04:24:50');
/*!40000 ALTER TABLE `professions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('78hdnzVJXesakD5FEwydHeVghzrxnS6A6Hd0c7Dc',NULL,'127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0dBSm5rVkNBeVNvOHREc29yTG5SWkhKRjVaWkNadzJ6RGhaRnhEdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1748589924);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profession_id` bigint unsigned DEFAULT NULL,
  `current_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `show_phone` tinyint(1) NOT NULL DEFAULT '0',
  `birth_year` year DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo_visibility` enum('everyone','members_only','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'members_only',
  `kvkk_consent` tinyint(1) NOT NULL DEFAULT '0',
  `kvkk_consent_date` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_current_city_index` (`current_city`),
  KEY `users_current_district_index` (`current_district`),
  KEY `users_profession_id_index` (`profession_id`),
  CONSTRAINT `users_profession_id_foreign` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_groups`
--

DROP TABLE IF EXISTS `whatsapp_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `invite_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_groups_city_is_active_index` (`city`,`is_active`),
  KEY `whatsapp_groups_district_is_active_index` (`district`,`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_groups`
--

LOCK TABLES `whatsapp_groups` WRITE;
/*!40000 ALTER TABLE `whatsapp_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-30 11:01:13

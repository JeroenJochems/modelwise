/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `action_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `action_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_id` bigint unsigned NOT NULL,
  `target_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `fields` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'running',
  `exception` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `changes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `action_events_actionable_type_actionable_id_index` (`actionable_type`,`actionable_id`),
  KEY `action_events_target_type_target_id_index` (`target_type`,`target_id`),
  KEY `action_events_batch_id_model_type_model_id_index` (`batch_id`,`model_type`,`model_id`),
  KEY `action_events_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_column` int DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `shortlisted_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand_conflicted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `casting_questions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prelisted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `applications_role_id_model_id_unique` (`role_id`,`model_id`),
  KEY `applications_role_id_index` (`role_id`),
  KEY `applications_model_id_index` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `digitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `digitals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int unsigned NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortable_order` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hires` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `application_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `responsible_user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `applied_at` timestamp NULL DEFAULT NULL,
  `extended_application_at` timestamp NULL DEFAULT NULL,
  `invited_at` timestamp NULL DEFAULT NULL,
  `favorited_at` timestamp NULL DEFAULT NULL,
  `shortlisted_at` timestamp NULL DEFAULT NULL,
  `hired_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand_conflicted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `available_dates` json DEFAULT NULL,
  `casting_questions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_model_index` (`role_id`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_exclusive_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_exclusive_countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint unsigned NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_subscribed_to_newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `has_completed_onboarding` tinyint(1) NOT NULL DEFAULT '0',
  `is_accepted` tinyint(1) DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `shoe_size` decimal(3,1) DEFAULT NULL,
  `clothing_size_top` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` decimal(4,1) DEFAULT NULL,
  `inside_leg` int unsigned DEFAULT NULL,
  `chest` decimal(4,1) DEFAULT NULL,
  `waist` decimal(4,1) DEFAULT NULL,
  `hips` decimal(4,1) DEFAULT NULL,
  `hair_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piercings` tinyint(1) DEFAULT NULL,
  `tattoos` tinyint(1) DEFAULT NULL,
  `hair_color_other` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eye_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ethnicity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ethnicity_other` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cup_size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_categories` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen_exclusive_countries` tinyint(1) DEFAULT NULL,
  `preferred_language` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `parent_first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analysis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whatsapp_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showreel_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `models_email_unique` (`email`),
  UNIQUE KEY `models_external_id_unique` (`external_id`),
  KEY `date_of_birth` (`date_of_birth`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `nova_field_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nova_field_attachments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `attachable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachable_id` bigint unsigned NOT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nova_field_attachments_attachable_type_attachable_id_index` (`attachable_type`,`attachable_id`),
  KEY `nova_field_attachments_url_index` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `nova_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nova_notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nova_notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `nova_pending_field_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nova_pending_field_attachments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `draft_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nova_pending_field_attachments_draft_id_index` (`draft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `passes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `passes_role_id_model_id_index` (`role_id`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `photoable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photoable_id` bigint unsigned NOT NULL,
  `folder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortable_order` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `analysis` json DEFAULT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `presentation_listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presentation_listings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `presentation_id` bigint unsigned NOT NULL,
  `listing_id` bigint unsigned NOT NULL,
  `order_column` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presentation_listings_presentation_id_foreign` (`presentation_id`),
  KEY `presentation_listings_listing_id_foreign` (`listing_id`),
  CONSTRAINT `presentation_listings_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `presentation_listings_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `presentations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presentations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `role_id` bigint unsigned NOT NULL,
  `should_show_casting_media` tinyint(1) NOT NULL DEFAULT '0',
  `should_show_digitals` tinyint(1) NOT NULL DEFAULT '0',
  `should_show_socials` tinyint(1) NOT NULL DEFAULT '0',
  `should_show_cover_letter` tinyint(1) NOT NULL DEFAULT '0',
  `should_show_conflicts` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rejections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rejections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `job_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `fee` int DEFAULT NULL,
  `fee_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyout` int DEFAULT NULL,
  `buyout_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `travel_reimbursement_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fields` json DEFAULT NULL,
  `extra_fields` json DEFAULT NULL,
  `casting_photo_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `casting_video_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `casting_questions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taggables` (
  `tag_id` bigint unsigned NOT NULL,
  `taggable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint unsigned NOT NULL,
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` json NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_column` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `videoable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `videoable_id` bigint unsigned NOT NULL,
  `folder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortable_order` int unsigned NOT NULL,
  `mux_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_videoable_type_videoable_id_index` (`videoable_type`,`videoable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `work_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aggregate_root_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int NOT NULL,
  `payload` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idempotency_index` (`aggregate_root_id`,`version`),
  KEY `reconstitution_index` (`aggregate_root_id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2014_10_12_100000_create_password_reset_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2023_06_12_000000_create_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2023_06_19_130946_create_photos',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2023_06_19_133631_add_profile_photo_to_model',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2023_06_20_114957_add_fields_to_model',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2023_06_20_121352_add_newsletter_subscribed_to_models',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2023_06_20_124459_rename_location_on_models',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2023_06_20_130130_make_fields_nullable_on_models',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2023_06_21_071224_add_date_of_birth_to_models',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2023_06_21_130946_create_digitals',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2023_06_23_093228_add_folder_to_photos',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2018_01_01_000000_create_action_events_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2019_05_10_000000_add_fields_to_action_events_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2021_08_25_193039_create_nova_notifications_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2022_04_26_000000_add_fields_to_nova_notifications_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2022_12_19_000000_create_field_attachments_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2023_07_01_134606_add_body_characteristics_to_models',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2023_07_01_134613_create_jobs_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (80,'2023_07_01_193604_create_clients',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (82,'2023_07_01_194518_create_shortlisted_models',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2023_07_01_195823_create_shortlisted_models',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2023_07_04_105627_rename_shortlisted_models',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2023_07_04_114655_model_exclusive_countries',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2023_07_04_133429_add_inside_leg_to_models',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2023_07_07_094059_create_brands',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2023_07_07_094122_add_brand_id_to_jobs',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2023_07_08_072727_add_fields_to_models',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2023_07_10_112637_add_hair_color_other_to_models',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2023_07_11_111937_add_tags_to_models',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2023_07_11_112659_create_tag_tables',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2023_07_11_112659_create_tag_tables',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2023_07_14_070157_make_photos_morphable',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2023_07_14_090649_make_folder_nullable_on_photos',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (103,'2023_07_14_091003_add_fields_to_jobs',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (104,'2023_07_14_111403_rename_job_id_on_longlisted_models',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (105,'2023_07_18_185147_create_applications',26);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (106,'2023_07_19_142837_add_logo_to_brands',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (108,'2023_08_18_080233_add_cover_letter_to_applications',28);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (109,'2023_08_18_130524_rename_table_longlisted_models',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (116,'2023_08_20_071119_add_application_id_to_invites',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (117,'2023_08_23_070202_create_hires',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (118,'2023_08_23_070206_create_rejections',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (119,'2023_08_23_144402_add_seen_exclusive_countries_models',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (120,'2023_08_25_094612_add_other_categories_to_models',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (121,'2023_08_28_063659_add_preferred_language_to_models',32);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (122,'2023_08_28_105116_create_passes',33);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (123,'2023_08_28_145549_add_location_to_jobs',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (124,'2023_08_28_180523_add_sizes_to_roles',35);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (125,'2023_08_30_091032_add_description_to_brand',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (126,'2023_09_01_122923_add_brand_conflicted_to_applications',37);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (128,'2023_09_01_143135_add_responsible_admin_to_jobs',38);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (129,'2023_09_08_073648_create_role_views',39);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (130,'2023_09_08_092721_add_parent_fields_to_models',40);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (131,'2023_09_08_145451_add_column_fields_to_roles',41);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (132,'2023_09_09_085753_drop_sizes_on_roles',42);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (139,'2023_09_12_075229_create_videos',43);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (140,'2023_09_13_112819_add_casting_video_instructions_to_roles',44);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (142,'2023_09_13_112819_add_casting_video_instructions_to_roles',44);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (147,'2023_09_19_093640_add_shortlisted_at_to_applications',45);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (149,'2023_10_03_145313_create_leads',46);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (150,'2023_10_18_072111_add_size_to_models',47);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (151,'2023_11_10_194925_create_passes_table',48);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (152,'2023_11_10_194925_create_passes_table',48);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (153,'2023_11_28_123707_add_order_column_to_applications',49);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (154,'2023_11_28_132353_add_unique_index_on_applications',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (155,'2023_12_03_094045_create_presentations',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (156,'2023_11_28_132353_add_unique_index_on_applications',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (157,'2023_12_03_094045_create_presentations',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (159,'2023_12_06_101919_add_daily_rates_to_models',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (160,'2024_01_18_084555_add_whatsapp_number_to_models',52);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (162,'2024_02_08_091006_add_analysis_to_photos',53);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (163,'2024_02_09_054649_add_analysis_to_models',54);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (164,'2024_02_16_113632_add_casting_questions_to_role',55);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (165,'2024_02_16_113753_add_casting_questions_to_applications',55);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (166,'2024_03_29_151337_add_whatsapp_number_to_models',56);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (167,'2024_05_25_105004_add_client_interested_at_to_applications',57);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (168,'2024_05_29_094353_add_hash_to_photos',58);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (169,'2024_05_29_115619_add_deleted_at_to_photos',59);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (170,'2024_05_29_130032_add_showreel_link_to_models',59);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (171,'2024_06_13_075919_create_work_events',60);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (172,'2024_06_13_082315_initiate_role_aggregates',61);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (173,'2024_06_13_082630_role_model',61);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (174,'2024_06_13_082631_create_listings',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (175,'2024_06_18_085247_add_description_to_presentations',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (176,'2024_06_18_085501_create_presentation_listings',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (177,'2024_06_26_124620_make__start_date_not__nullale_on_roles',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (178,'2024_06_26_143346_copy_applications_to_listings',63);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (179,'2024_06_26_145653_drop_applications_from_presentations',63);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (180,'2024_07_13_053036_create_email_logs',64);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (181,'2024_09_14_145118_add_ethnicity_other_to_models',65);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (182,'2024_09_16_115505_add_external_id_to_models',66);

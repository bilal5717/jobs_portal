/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.10-MariaDB : Database - jobs_portal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`name`,`email`,`password`,`user_role`,`status`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin User','admin@admin.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1,1,NULL,'2020-08-18 11:30:46','2020-08-18 10:57:50');

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `companies` */

insert  into `companies`(`id`,`company_name`,`slug`,`description`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'LOcation 1','location-1','My sample project location','2020-12-05 09:06:41','2020-12-05 09:17:48',NULL),
(2,'LOcation 2','location-2','This is sample project located in different location.','2020-12-05 09:18:28','2020-12-05 09:18:28',NULL),
(3,'Company 3','company-3','Company 3','2020-12-13 09:43:44','2020-12-13 09:43:44',NULL);

/*Table structure for table `company_folder` */

DROP TABLE IF EXISTS `company_folder`;

CREATE TABLE `company_folder` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `company_folder` */

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_required` enum('Y','N') DEFAULT 'Y',
  `is_active` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `documents` */

insert  into `documents`(`id`,`key`,`name`,`is_required`,`is_active`,`created_at`,`updated_at`) values 
(1,'security_licensse','Security Licence','Y','Y','2020-10-02 22:24:23','2020-10-02 22:30:34'),
(2,'security_licence_certificates','Security Licence Certificates','Y','Y','2020-10-02 22:24:18','2020-10-02 22:30:34'),
(3,'first_aid_doc','First Aid','Y','Y','2020-10-02 22:24:08','2020-10-02 22:30:34'),
(4,'rsa_doc','RSA','N','Y','2020-10-02 22:24:02','2020-10-02 22:30:34'),
(5,'white_card_doc','White Card','N','Y','2020-10-02 22:23:53','2020-10-02 22:30:34'),
(6,'traffic_controller_doc','Traffic Controller','N','Y','2020-10-02 22:23:44','2020-10-02 22:30:34'),
(7,'passport_visa_doc','Passport and Visa','Y','Y','2020-10-02 22:23:33','2020-10-02 22:30:34'),
(8,'driving_dicence_doc','Driving Licence or Photo ID','Y','Y','2020-10-02 22:23:26','2020-10-02 22:30:34'),
(9,'tfn_super_detail_doc','TFN and Super Detail','Y','Y','2020-10-02 22:23:12','2020-10-02 22:30:34'),
(10,'other_document','Other document','N','Y','2020-10-03 23:44:24','2020-10-03 23:44:24');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `file_user` */

DROP TABLE IF EXISTS `file_user`;

CREATE TABLE `file_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `file_user` */

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` int(11) NOT NULL,
  `orignal_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `files` */

/*Table structure for table `folder_user` */

DROP TABLE IF EXISTS `folder_user`;

CREATE TABLE `folder_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `folder_user` */

/*Table structure for table `folders` */

DROP TABLE IF EXISTS `folders`;

CREATE TABLE `folders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `folders` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2018_07_03_101401_create_quiz_table',1),
(2,'2018_07_03_101402_create_quiz_questions_table',2),
(3,'2018_07_03_101403_create_quiz_answers_table',3),
(4,'2018_07_03_101404_create_quiz_responses_table',4);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `projects` */

insert  into `projects`(`id`,`company_id`,`name`,`description`,`slug`,`is_active`,`created_at`,`updated_at`) values 
(2,1,'L1 Project 1','L1 Project 1 Desc','l1-project-1','Y','2020-12-12 15:11:24','2020-12-12 15:11:24'),
(3,2,'L2 Project 1','testt','l2-project-1','Y','2020-12-12 16:02:03','2020-12-12 16:02:03'),
(4,1,'L1 Project 2','L1 Project 2','l1-project-2','Y','2020-12-13 09:47:32','2020-12-13 09:47:32');

/*Table structure for table `quiz` */

DROP TABLE IF EXISTS `quiz`;

CREATE TABLE `quiz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quiz` */

insert  into `quiz`(`id`,`title`,`description`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Induction','Basic induction for guards.','2020-09-29 09:09:26','2020-09-29 09:09:30',NULL);

/*Table structure for table `quiz_answers` */

DROP TABLE IF EXISTS `quiz_answers`;

CREATE TABLE `quiz_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_answers_quiz_id_foreign` (`quiz_id`),
  KEY `quiz_answers_question_id_foreign` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quiz_answers` */

/*Table structure for table `quiz_questions` */

DROP TABLE IF EXISTS `quiz_questions`;

CREATE TABLE `quiz_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int(10) unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('multiple_choice','text_answer','result_answer') COLLATE utf8mb4_unicode_ci DEFAULT 'multiple_choice',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_questions_quiz_id_foreign` (`quiz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quiz_questions` */

insert  into `quiz_questions`(`id`,`quiz_id`,`title`,`type`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,'Who is responsible for Work Health and Safety (WHS)?(tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(2,1,'What is a WHS Policy? (tick the correct answer)','multiple_choice','2020-09-29 09:11:50','2020-09-29 09:11:54',NULL),
(3,1,'Is a company motor vehicle classified as the ‘workplace’?Yes / No (Circle the correct answer)','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(4,1,'List three(3)thingsyou should always carry as part of your duties as a Security Guard.','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(5,1,'Being Fit for Work means that you are:','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(6,1,'Which of the following is NOT an aim of Stronghold’s Environmental Management System? (tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(7,1,'Explain in your own words what you should do in the event you witness a workplace injury.','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(8,1,'You have a grievance with a process in the workplace.  What should you do? (tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(9,1,'You are at work and you notice a colleague pouring used vehicle oil down a sewage gutter.  What should you do? (tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(10,1,'Which of the following is NOTa responsibility of StrongholdSecurity’s Officers?','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(11,1,'You are at a client premises and you notice a work colleague accessing a client’s computer files.  What should you do? (tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(12,1,'You are driving a company car and your work colleague refuses to put his seatbelt on.  In your own words, report what you would do.','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(13,1,'Can you use your peronal mobile phone when you are on duty?(tick the correct answer)','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(14,1,'A colleague asks you to download some files from the client’s office and send them to him electronically.  Briefly explain what you would do.','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(15,1,'In your own words explain why it is important to be well dressed and groomed when working for StrongholdSecurity.','text_answer','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL),
(16,1,'While at work, StrongholdSecurity expects you to (tick the correct answer):','multiple_choice','2020-09-29 09:10:33','2020-09-29 09:10:35',NULL);

/*Table structure for table `quiz_responses` */

DROP TABLE IF EXISTS `quiz_responses`;

CREATE TABLE `quiz_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `quizable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quizable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_responses_quizable_type_quizable_id_index` (`quizable_type`,`quizable_id`),
  KEY `quiz_responses_quiz_id_foreign` (`quiz_id`),
  KEY `quiz_responses_question_id_foreign` (`question_id`),
  KEY `quiz_responses_answer_id_foreign` (`answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quiz_responses` */

/*Table structure for table `timesheet_comments` */

DROP TABLE IF EXISTS `timesheet_comments`;

CREATE TABLE `timesheet_comments` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `timesheet_id` int(25) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `timesheet_comments` */

insert  into `timesheet_comments`(`id`,`timesheet_id`,`comment`,`admin_id`,`created_at`,`updated_at`) values 
(1,6,'Everything is fine, thank you for your attention.',1,'2020-09-27 16:35:23','2020-09-27 22:32:05'),
(2,6,'Testing Second comment, gy.',1,'2020-09-27 17:54:02','2020-09-27 17:54:02'),
(3,6,'Test',1,'2020-12-05 11:49:53','2020-12-05 11:49:53');

/*Table structure for table `timesheet_daily_hours` */

DROP TABLE IF EXISTS `timesheet_daily_hours`;

CREATE TABLE `timesheet_daily_hours` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `timesheet_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `timesheet_daily_hours` */

insert  into `timesheet_daily_hours`(`id`,`timesheet_id`,`user_id`,`project_id`,`location`,`check_in_date`,`check_in_time`,`check_out_time`,`notes`,`created_at`,`updated_at`) values 
(4,3,23,NULL,'This is first location','2020-09-01','03:25:00','15:25:00','testing comments 1','2020-09-22 19:28:05','2020-09-22 19:28:05'),
(5,3,23,NULL,'Location2','2020-09-02','13:30:00','21:30:00','testing','2020-09-22 19:29:58','2020-09-22 19:29:58'),
(6,3,23,NULL,NULL,'2020-09-03','07:30:00','21:30:00',NULL,'2020-09-22 19:29:58','2020-09-22 19:31:56'),
(7,3,23,NULL,NULL,'2020-09-04','07:30:00','22:30:00','Nothing here','2020-09-22 19:31:56','2020-09-22 19:33:03'),
(8,3,23,NULL,'No location','2020-09-06',NULL,NULL,NULL,'2020-09-22 19:31:56','2020-09-22 19:31:56'),
(9,5,23,NULL,'Test location 2.1','2020-09-09','12:50:00','15:45:00','Some thing important.','2020-09-23 10:50:13','2020-09-23 10:50:13'),
(10,5,23,NULL,NULL,'2020-09-10','00:50:00','22:50:00','Testttttt','2020-09-23 10:50:13','2020-09-23 10:50:13'),
(11,6,23,NULL,'Hello location 1','2020-09-13','12:15:00','23:45:00','teetttsing','2020-09-24 18:18:12','2020-09-24 18:18:12'),
(12,6,23,NULL,'Nonenene','2020-09-17','07:15:00','21:15:00','fdskfdjsfk','2020-09-24 18:18:12','2020-09-24 18:18:12'),
(13,6,23,NULL,NULL,'2020-09-19','13:20:00','20:20:00','testtttooo','2020-09-24 18:18:12','2020-09-24 18:32:26'),
(14,8,23,NULL,NULL,'2020-09-20',NULL,NULL,'test','2020-09-26 05:59:21','2020-09-26 05:59:21');

/*Table structure for table `timesheets` */

DROP TABLE IF EXISTS `timesheets`;

CREATE TABLE `timesheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `status` enum('new','pending','denied','approved') DEFAULT 'new',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `submit_count` int(10) DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `timesheets` */

insert  into `timesheets`(`id`,`user_id`,`title`,`status`,`start_date`,`end_date`,`submit_count`,`submit_date`,`created_at`,`updated_at`) values 
(5,23,'Test timesheet 2','approved','2020-09-07','2020-09-13',5,'2020-09-26 06:01:41','2020-09-23 10:48:03','2020-10-06 19:42:48'),
(3,23,'Muhammad Babar','approved','2020-09-01','2020-09-07',1,'2020-09-23 09:00:19','2020-09-15 16:34:16','2020-10-06 19:58:08'),
(6,23,'Test timesheet 2.2 third','denied','2020-09-13','2020-09-19',2,'2020-09-24 18:32:36','2020-09-23 10:57:16','2020-10-06 19:56:11'),
(8,23,'Test timesheet 3','new','2020-09-20','2020-09-26',0,'2020-09-26 05:22:44','2020-09-26 05:22:44','2020-09-26 05:26:38'),
(9,24,'till','new','2020-08-01','2020-08-07',0,'2020-09-28 09:32:07','2020-09-28 09:32:07','2020-09-28 09:32:07');

/*Table structure for table `timetable_hours` */

DROP TABLE IF EXISTS `timetable_hours`;

CREATE TABLE `timetable_hours` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `timetable_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `day_name` enum('mon','tue','wed','thu','fri','sat','sun') DEFAULT 'mon',
  `check_in_date` date DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `timetable_hours` */

insert  into `timetable_hours`(`id`,`timetable_id`,`user_id`,`project_id`,`day_name`,`check_in_date`,`check_in_time`,`check_out_time`,`notes`,`created_at`,`updated_at`) values 
(1,1,23,2,'mon','2021-01-04','06:20:00','17:45:00','test1','2020-12-20 18:22:08','2021-01-01 18:49:17'),
(2,1,22,3,'mon','2021-01-04','07:20:00','20:20:00','ttt','2020-12-20 18:22:08','2021-01-01 18:49:17'),
(3,1,24,4,'mon','2021-01-04','00:20:00','21:20:00',NULL,'2020-12-20 18:22:08','2021-01-01 18:49:17'),
(4,1,23,2,'fri','2021-01-08','01:20:00','22:55:00','test2','2020-12-20 18:22:08','2021-01-01 18:49:17'),
(5,2,23,4,'mon','2021-01-04','07:20:00','20:20:00','ttt','2021-01-01 18:38:44','2021-01-03 17:43:25'),
(6,2,22,3,'mon','2021-01-04','06:50:00','18:50:00','tt2223','2021-01-01 18:38:44','2021-01-03 17:43:25'),
(7,2,24,NULL,'mon','2021-01-04','00:20:00','21:20:00',NULL,'2021-01-01 18:38:44','2021-01-03 17:43:25'),
(8,2,23,2,'fri','2021-01-08','01:20:00','22:55:00','test2','2021-01-01 18:38:44','2021-01-03 17:43:25'),
(10,2,23,3,'tue','2021-01-05','06:45:00','17:45:00',NULL,'2021-01-01 18:53:42','2021-01-03 17:43:25'),
(11,2,24,4,'tue','2021-01-05','06:55:00','22:55:00','zz','2021-01-01 18:54:49','2021-01-03 17:43:25');

/*Table structure for table `timetables` */

DROP TABLE IF EXISTS `timetables`;

CREATE TABLE `timetables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `timetables` */

insert  into `timetables`(`id`,`title`,`status`,`start_date`,`end_date`,`created_at`,`updated_at`) values 
(1,'Timetable night shift 2020','active','2021-04-01',NULL,'2020-12-20 18:22:08','2021-01-01 18:49:17'),
(2,'Timetable night shift 2020','active','2021-04-01',NULL,'2021-01-01 18:38:44','2021-01-03 21:39:25');

/*Table structure for table `user_details` */

DROP TABLE IF EXISTS `user_details`;

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `contact` varchar(25) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zipcode` varchar(11) DEFAULT NULL,
  `telephone_home` varchar(25) DEFAULT NULL,
  `mobile_number` varchar(25) DEFAULT NULL,
  `gender` varchar(25) DEFAULT NULL,
  `permanent_cityzen` enum('Y','N') DEFAULT 'Y',
  `visa_status` varchar(200) DEFAULT NULL,
  `worked_before` enum('Y','N') DEFAULT 'N',
  `worked_before_status` varchar(200) DEFAULT NULL,
  `work_anytime` enum('Y','N') DEFAULT 'Y',
  `work_anytime_availability` varchar(200) DEFAULT NULL,
  `tex_file_number` varchar(25) DEFAULT NULL,
  `recruitment_bank` varchar(100) DEFAULT NULL,
  `recruitment_branch` varchar(100) DEFAULT NULL,
  `recruitment_bsb` varchar(25) DEFAULT NULL,
  `recruitment_account_name` varchar(50) DEFAULT NULL,
  `rec_account_number` varchar(30) DEFAULT NULL,
  `super_name` varchar(50) DEFAULT NULL,
  `super_member_id` varchar(25) DEFAULT NULL,
  `super_company_name` varchar(50) DEFAULT NULL,
  `super_abn` varchar(25) DEFAULT NULL,
  `super_com_address` varchar(200) DEFAULT NULL,
  `can_contact_supervisor` enum('Y','N') DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user_details` */

insert  into `user_details`(`id`,`user_id`,`birth_date`,`contact`,`address`,`city`,`state`,`zipcode`,`telephone_home`,`mobile_number`,`gender`,`permanent_cityzen`,`visa_status`,`worked_before`,`worked_before_status`,`work_anytime`,`work_anytime_availability`,`tex_file_number`,`recruitment_bank`,`recruitment_branch`,`recruitment_bsb`,`recruitment_account_name`,`rec_account_number`,`super_name`,`super_member_id`,`super_company_name`,`super_abn`,`super_com_address`,`can_contact_supervisor`,`created_at`,`updated_at`) values 
(1,23,'1991-10-16','092305691689','Test address','Lahore','Punjab','54000','12322-32-23-21','12341233456657','Male','Y',NULL,'N',NULL,'Y',NULL,NULL,'HBL Walton road, Lahore','Test Account Name','012334566789',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N','2020-08-30 11:23:42','2020-10-04 14:05:54'),
(2,24,'1991-10-16','2344559000','ABC test address','Lahore','Punjab','54000','12322-32-23-21','12341233456','Male','N','I Can not tell you everything.','Y','Why are you asking  everything.','N','on call','12','HBL Walton road, Lahore','Test Account Name','012334566789','Bababr','124679809','My Sup Name','001232','The Test Company','23234','This is the test address of supperfund.','Y','2020-10-05 17:22:18','2020-10-12 17:24:29');

/*Table structure for table `user_documents` */

DROP TABLE IF EXISTS `user_documents`;

CREATE TABLE `user_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `security_licensse` varchar(200) DEFAULT NULL,
  `security_licence_certificates` varchar(200) DEFAULT NULL,
  `first_aid_doc` varchar(200) DEFAULT NULL,
  `rsa_doc` varchar(200) DEFAULT NULL,
  `white_card_doc` varchar(200) DEFAULT NULL,
  `passport_visa_doc` varchar(200) DEFAULT NULL,
  `driving_dicence_doc` varchar(200) DEFAULT NULL,
  `tfn_super_detail_doc` varchar(200) DEFAULT NULL,
  `other_document` varchar(200) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `user_documents` */

insert  into `user_documents`(`id`,`user_id`,`security_licensse`,`security_licence_certificates`,`first_aid_doc`,`rsa_doc`,`white_card_doc`,`passport_visa_doc`,`driving_dicence_doc`,`tfn_super_detail_doc`,`other_document`,`updated_at`,`created_at`) values 
(2,24,'security_licensse.jfif','security_licence_certificates.jfif','first_aid_doc.ico','rsa_doc.jfif',NULL,'passport_visa_doc.ico','driving_dicence_doc.ico','tfn_super_detail_doc.ico','other_document.jfif','2020-10-03 18:45:51','2020-10-03 23:45:51'),
(3,23,'security_licensse.jpg','security_licence_certificates.jpg','first_aid_doc.jpg',NULL,NULL,'passport_visa_doc.jpg','driving_dicence_doc.jpg','tfn_super_detail_doc.jpg',NULL,'2020-10-04 07:44:51','2020-10-04 07:44:51');

/*Table structure for table `user_job_details` */

DROP TABLE IF EXISTS `user_job_details`;

CREATE TABLE `user_job_details` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `job_type` enum('security','cleaning','traffic_controller') DEFAULT 'security',
  `license_name` varchar(50) DEFAULT NULL,
  `license_number` varchar(25) DEFAULT NULL,
  `clases` varchar(15) DEFAULT NULL,
  `license_state` varchar(15) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `company_name` varchar(25) DEFAULT NULL,
  `experience_years` varchar(10) DEFAULT NULL,
  `employee_name` varchar(25) DEFAULT NULL,
  `emp_contact_number` varchar(15) DEFAULT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `work_shift_prepared` enum('Y','N') DEFAULT 'Y',
  `explain_availability` text DEFAULT NULL,
  `emergency_name` varchar(50) DEFAULT NULL,
  `emergency_address` varchar(200) DEFAULT NULL,
  `emergency_relationship` varchar(25) DEFAULT NULL,
  `emergency_number` varchar(15) DEFAULT NULL,
  `disability` enum('Y','N') DEFAULT 'N',
  `medical_condition` enum('Y','N') DEFAULT 'N',
  `mental_disorders` enum('Y','N') DEFAULT 'N',
  `allergies` enum('Y','N') DEFAULT 'N',
  `drugs_dependency` enum('Y','N') DEFAULT 'N',
  `smoking` enum('Y','N') DEFAULT 'N',
  `medication` enum('Y','N') DEFAULT 'N',
  `drink_alcohol` enum('frequently','occasional','never') DEFAULT 'never',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user_job_details` */

insert  into `user_job_details`(`id`,`user_id`,`job_type`,`license_name`,`license_number`,`clases`,`license_state`,`expiry_date`,`company_name`,`experience_years`,`employee_name`,`emp_contact_number`,`availability`,`work_shift_prepared`,`explain_availability`,`emergency_name`,`emergency_address`,`emergency_relationship`,`emergency_number`,`disability`,`medical_condition`,`mental_disorders`,`allergies`,`drugs_dependency`,`smoking`,`medication`,`drink_alcohol`,`created_at`,`updated_at`) values 
(1,24,'cleaning','Athena Simon','Torres Cooper Plc','aa','Alaska','2020-10-14','Mann and Guy Inc','1989','Philip Bray','185','Perferendis beatae r','N','Ullam quia nostrum o','Test','Address emergency','Nill','2134567898','Y','Y','Y','Y','Y','Y','Y','frequently','2020-09-30 19:39:53','2020-10-12 17:05:38'),
(2,23,'cleaning','Halee Le la','12341233456657','aa','Alaska','2024-10-21','Mann and Guy Inc','1989','Philip Bray','19523609876','Perferendis beatae r','Y',NULL,'Test','Address emergency','Nill','2134567898','N','N','N','N','N','N','N','occasional','2020-10-04 07:44:51','2020-10-04 14:53:04');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `step` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` enum('new','pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`type`,`step`,`remember_token`,`user_status`,`image`,`created_at`,`updated_at`) values 
(22,'Admin','admin@admin.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','1','v05Z6k48DdqQ9W6NKVldcF4SyROqdZMFf7287h77xjNvGJZ5k8s0Zn3xyvBQ','new',NULL,NULL,'2020-08-11 13:51:21'),
(23,'Babar Ali','mbabarbaqar@gmail.com',NULL,'$2y$10$ZNlMxNGxW6RnVLx3Vls3Hu3TRFKZAWPbqbZ/kS3gUuMA9KvEPkWlO','user','4',NULL,'approved','16012177583001.jpg','2020-08-29 09:41:49','2020-09-27 14:42:38'),
(24,'Babar 2','mbabarbaqar2@gmail.com',NULL,'$2y$10$v/vaq8bk9eX6EphL0vqgrOQM3o7/iZcHbmaiRmGdrdg.oQ95uNcdm','user','3',NULL,'pending','16012202469069.jpg','2020-09-27 14:44:33','2020-10-05 17:22:18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

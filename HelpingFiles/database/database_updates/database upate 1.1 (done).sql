
USE `h2o1`;

/*Table structure for table `company_folder` */

DROP TABLE IF EXISTS `company_folder`;

CREATE TABLE `company_folder` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


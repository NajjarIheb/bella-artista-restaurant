-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: restaurantApp
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (5,'Entrées Chaudes',1,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(6,'Petit Déjeuner',2,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(7,'Salades',3,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(8,'Pâtes',4,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(9,'Les Grillades',5,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(10,'Les Poissons',6,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(11,'Les Pizzas',7,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(12,'Fast Food',8,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(13,'Crêpes Salées',9,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(14,'Crêpes Sucrées',10,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(15,'Gauffres Salées',11,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(16,'Gauffres Sucrées',12,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(17,'Fruits Split',13,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(18,'Salade de Fruits',14,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(19,'Boissons Chaudes',15,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(20,'Boissons Froides',16,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(21,'Desserts',17,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(22,'Glaces',18,'2026-08-02 12:22:19','2026-08-02 12:22:19');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_notifications`
--

DROP TABLE IF EXISTS `customer_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_notifications_order_id_index` (`order_id`),
  KEY `customer_notifications_user_id_index` (`user_id`),
  KEY `customer_notifications_phone_index` (`phone`),
  CONSTRAINT `customer_notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customer_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_notifications`
--

LOCK TABLES `customer_notifications` WRITE;
/*!40000 ALTER TABLE `customer_notifications` DISABLE KEYS */;
INSERT INTO `customer_notifications` VALUES (3,20,NULL,'hgfh','orderConfirmed',NULL,'2026-08-03 20:55:42','2026-08-03 20:55:42'),(4,13,18,NULL,'orderConfirmed',NULL,'2026-08-03 20:57:11','2026-08-03 20:57:11');
/*!40000 ALTER TABLE `customer_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_zones`
--

DROP TABLE IF EXISTS `delivery_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL,
  `delivery_fee` decimal(8,2) NOT NULL DEFAULT 0.00,
  `estimated_time` varchar(255) NOT NULL DEFAULT '30-45 mins',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_zones`
--

LOCK TABLES `delivery_zones` WRITE;
/*!40000 ALTER TABLE `delivery_zones` DISABLE KEYS */;
INSERT INTO `delivery_zones` VALUES (1,'Downtown & Financial District',5.00,'25 - 35 min','2026-08-02 10:29:07','2026-08-02 10:29:07'),(2,'Uptown & Harbor Bay',8.50,'35 - 50 min','2026-08-02 10:29:07','2026-08-02 10:29:07'),(3,'West End Estates',12.00,'45 - 60 min','2026-08-02 10:29:07','2026-08-02 10:29:07');
/*!40000 ALTER TABLE `delivery_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_deal` tinyint(1) NOT NULL DEFAULT 0,
  `deal_group` varchar(255) DEFAULT NULL,
  `allergens` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_category_id_foreign` (`category_id`),
  CONSTRAINT `menu_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (11,'Brik Chevrette',NULL,7.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(12,'Brik Diari',NULL,6.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(13,'Brik Thon',NULL,6.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(14,'Calamar Doré',NULL,28.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(15,'Chevrettes Panées',NULL,31.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-5.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(16,'Chevrettes Sautées à L\'aille',NULL,29.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-6.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(17,'Cocotte Moules sautées','1 kg',34.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(18,'Ojja Chevrette',NULL,28.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(19,'Ojja Escalope et Merguez',NULL,22.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-9.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(20,'Ojja Escalope',NULL,19.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(21,'Ojja Fruits de Mer',NULL,29.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(22,'Ojja Merguez',NULL,19.50,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(23,'Omelette','thon, Fromage',13.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(24,'Plat Frites',NULL,6.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-14.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(25,'Plat Nuggets',NULL,12.00,NULL,5,'Entrées Chaudes','/storage/menu/entrees-chaudes/entrees-chaudes-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(26,'Brunch Bella Artista','2 cafés au Choix, 2 jus au choix, 2 yaourts, 1 mini crêpe chocolat ou salé, 2 croissants ou cakes maison, 2 salades de fruits, beurre, confiture, miel, chocolat, fraidou, charcuterie, assortiment de fromage, omelette, 2 brochettes escalope panés, 4 Nuggets, eau 1L',40.00,NULL,6,'Petit Déjeuner','/storage/menu/petit-dejeuner/petit-dejeuner-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(27,'Brunch Normal','Café au choix, jus, yaourt, croissant ou cake, mini crêpe chocolat ou salé, omelette, charcuterie, assortiment de fromage, beurre, confiture, fraidou, miel, brochette escalope pané, salade de fruits, Nuggets, eau 0.5L.',22.00,NULL,6,'Petit Déjeuner','/storage/menu/petit-dejeuner/petit-dejeuner-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(28,'Good Morning','Café au choix, croissant, Jus.',8.00,NULL,6,'Petit Déjeuner','/storage/menu/petit-dejeuner/petit-dejeuner-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(29,'Kids','Brochette fruits, chocolat au lait, Jus, mini crêpe, grain d\'or, Surprise Bella Artista',13.00,NULL,6,'Petit Déjeuner','/storage/menu/petit-dejeuner/petit-dejeuner-4.png',1,1,'kids',NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(30,'Matin Sucré','Café au choix, croissant ou cake, jus, yaourt, beurre, confiture, miel, eau 0.5L',14.00,NULL,6,'Petit Déjeuner',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 13:20:17'),(31,'Césare','Blanc de poulet, laitue, tomate, sauce césar, fromage parmesan, croton pignon',19.50,NULL,7,'Salades','/storage/menu/salades/salades-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(32,'Italienne','Poulet, fromage, laitue, tomate',16.50,NULL,7,'Salades','/storage/menu/salades/salades-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(33,'Pêcheur','Fruits de mer',32.50,NULL,7,'Salades','/storage/menu/salades/salades-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(34,'Salade Exotique','Laitue, Chevrette, kiwi, noix, figue sèche',31.50,NULL,7,'Salades','/storage/menu/salades/salades-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(35,'Salade Mechouia',NULL,12.00,NULL,7,'Salades','/storage/menu/salades/salades-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(36,'Salade Variée',NULL,15.00,NULL,7,'Salades','/storage/menu/salades/salades-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(37,'Gratin de fruits de mer','Sauce Blanche',31.50,NULL,8,'Pâtes','/storage/menu/pates/pates-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(38,'Lasagne Bolognaise','Sauce Rouge',23.50,NULL,8,'Pâtes','/storage/menu/pates/pates-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(39,'Macaronis Fell aux poissons','مقرونة فل باللحوت',31.00,NULL,8,'Pâtes','/storage/menu/pates/pates-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(40,'Paella','2 Pax',85.00,NULL,8,'Pâtes','/storage/menu/pates/pates-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(41,'Penne 4 Fromages','Sauce Blanche',22.50,NULL,8,'Pâtes','/storage/menu/pates/pates-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(42,'Penne All\'arrabiata','Sauce Rouge',9.50,NULL,8,'Pâtes','/storage/menu/pates/pates-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(43,'Risotto Fruits de mer',NULL,40.00,NULL,8,'Pâtes','/storage/menu/pates/pates-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(44,'Spaghetti aux Fruits de mer','Sauce Blanche',35.50,NULL,8,'Pâtes','/storage/menu/pates/pates-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(45,'Spaghetti aux Fruits de mer','Sauce Rouge',32.50,NULL,8,'Pâtes','/storage/menu/pates/pates-9.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(46,'Spaghetti Bolognaise','Sauce Rouge',19.50,NULL,8,'Pâtes','/storage/menu/pates/pates-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(47,'Spaghetti Carbonara','Sauce Blanche',19.50,NULL,8,'Pâtes','/storage/menu/pates/pates-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(48,'Spaghetti Chevrette','Sauce Rouge',32.00,NULL,8,'Pâtes','/storage/menu/pates/pates-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(49,'Spaghetti Puttanesca','Sauce Rouge',15.50,NULL,8,'Pâtes','/storage/menu/pates/pates-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(50,'Tagliatelle champignon et poulet','Crémeuse',22.50,NULL,8,'Pâtes','/storage/menu/pates/pates-14.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(51,'Tagliatelle Chevrette','SAUCE ROSÉE',29.50,NULL,8,'Pâtes','/storage/menu/pates/pates-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(52,'Tagliatelle Marimonté','Chevrette, Champignon',31.50,NULL,8,'Pâtes','/storage/menu/pates/pates-16.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(53,'Tagliatelle Norvégienne','Crème Fraîche, Saumon, Parmesan - SAUCE ROSÉE',36.50,NULL,8,'Pâtes','/storage/menu/pates/pates-17.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(54,'Tagliatelle Romanove','Crème Fraîche, Sauce Bolognaise, Champignon, Parmesan',23.50,NULL,8,'Pâtes','/storage/menu/pates/pates-18.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(55,'1/2 poulet à l\'Anglaise','1/2 Poulet panée, Mexicaine fromage',27.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(56,'1/2 poulet à la Mexicaine',NULL,22.50,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(57,'Brochettes de poulet',NULL,20.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(58,'Brochettes mixtes',NULL,28.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(59,'Cordon bleu',NULL,26.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(60,'Côte à l\'os XL',NULL,42.00,NULL,9,'Les Grillades',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(61,'Cotelette d\'Agneau','5 Pièces',45.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(62,'Escalope Grillée',NULL,18.50,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(63,'Escalope panée aux amandes',NULL,23.50,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-9.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(64,'Escalope Panée',NULL,21.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(65,'Escalope sauce champignons',NULL,26.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(66,'Filet de Boeuf grillé',NULL,40.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(67,'Filet de Boeuf sauce champignons',NULL,43.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(68,'Filet sauce poivre vert',NULL,43.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-14.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(69,'Filet sauce Roquefort',NULL,43.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(70,'Foie Grillé',NULL,30.50,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-16.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(71,'Galette',NULL,2.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-17.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(72,'Mixte grillée',NULL,39.50,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-18.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(73,'Plat Merguez',NULL,24.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-19.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(74,'Poulet à la Hawaïana','Suprême de poulet, amande, ananas',26.00,NULL,9,'Les Grillades','/storage/menu/les-grillades/les-grillades-20.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(75,'Calamar farcie',NULL,45.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(76,'Couscous au Poisson',NULL,37.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-2.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(77,'Crevete Grillé',NULL,50.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-3.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(78,'Crevete Panné',NULL,52.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-4.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(79,'Daurade Grillée',NULL,27.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-5.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(80,'Filet de Loup en croûte de pistaches',NULL,39.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-6.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(81,'Filet de poisson pané',NULL,33.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-7.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(82,'Grillade Mixte de poissons',NULL,52.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-8.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(83,'Loup farcé aux fruits de mer',NULL,41.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-9.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(84,'Loup Grillé',NULL,30.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(85,'Marmit pêcheur sauté',NULL,45.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(86,'Saumon Grillé',NULL,45.00,NULL,10,'Les Poissons','/storage/menu/les-poissons/les-poissons-12.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(87,'Symphonie de pêcheur',NULL,100.00,NULL,10,'Les Poissons',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(88,'Symphonie Royale BELLA VISTA (2 Pers)','Terre et Mer',130.00,NULL,10,'Les Poissons',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(89,'Margherita','Sauce tomate, Mozzarella, Olive',15.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-1.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(90,'Neptune','Sauce tomate, Mozzarella, Thon, olive',18.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(91,'4 Fromages sauce blanche','Mozzarella, Roquefort, Gruyère, cheddar',23.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-3.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(92,'4 Saisons','Sauce tomate, Mozzarella, légumes, champignons, olives, jambon',18.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(93,'Bianca','Sauce blanche, Jambon, Champignons, Mozzarella',22.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(94,'Bolognaise','Sauce tomate, Mozzarella, Bolognaise',21.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(95,'Chevrette','sauce tomate, chevrettes sautés',27.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(96,'Escalope','Sauce tomate, Mozzarella, Escalope, Légumes',18.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(97,'Fanghi','Sauce tomate, Mozzarella, champignons',18.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-9.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(98,'Fruits De Mer','Sauce tomate, Mozzarella, fruits de mer',29.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(99,'Jambon','Sauce tomate, Mozzarella, Jambon',18.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(100,'La Reine','Sauce tomate, Mozzarella, champignon, Jambon',19.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(101,'Spécial Dio','Thon, escalope',19.50,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(102,'Spécial 4X4','Escalope, champignons, pepperoni, thon',23.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(103,'Spécial Alfredo',NULL,22.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(104,'Spécial BELLA VISTA','Double plus escalope, jambon, champignons, double fromage légumes',29.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-16.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(105,'Spécial Mexican','Viande hachée',22.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-17.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(106,'Spécial Pepperoni','Sauce tomate, Mozzarella, pepperoni',19.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-18.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(107,'Spécial Trio','Jambon, escalope, pepperoni',21.50,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-19.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(108,'Supplément Champignon',NULL,7.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(109,'Supplément Escalope',NULL,7.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(110,'Supplément Jambon',NULL,5.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(111,'Supplément Mozzarella',NULL,8.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(112,'Supplément Œuf',NULL,1.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(113,'Supplément Thon',NULL,8.00,NULL,11,'Les Pizzas',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(114,'Végétarienne','Sauce tomate, Mozzarella, légumes grillés',19.00,NULL,11,'Les Pizzas','/storage/menu/les-pizzas/les-pizzas-26.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(115,'Baguette Farcie - Chevrette',NULL,18.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(116,'Baguette Farcie - Cordon Bleu',NULL,16.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-2.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(117,'Baguette Farcie - Escalope',NULL,14.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-3.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(118,'Baguette Farcie - Thon',NULL,14.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(119,'Baguette Farcie - Viande Hachée',NULL,17.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-5.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(120,'Calzone Farcie - Chevrette',NULL,18.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(121,'Calzone Farcie - Cordon Bleu',NULL,16.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(122,'Calzone Farcie - Escalope',NULL,14.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-8.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(123,'Calzone Farcie - Thon',NULL,14.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-9.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(124,'Calzone Farcie - Viande Hachée',NULL,17.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(125,'Libanais - Chevrette panée',NULL,17.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-11.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(126,'Libanais - Cordon Bleu',NULL,13.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(127,'Libanais - Escalope',NULL,11.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(128,'Libanais - Merguez',NULL,13.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(129,'Libanais - Thon',NULL,11.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(130,'Libanais - Viande Hachée',NULL,15.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-16.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(131,'Makloub - Chevrette panée',NULL,17.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-17.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(132,'Makloub - Cordon Bleu',NULL,13.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-18.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(133,'Makloub - Escalope',NULL,11.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-19.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(134,'Makloub - Merguez',NULL,13.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-20.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(135,'Makloub - Thon',NULL,11.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-21.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(136,'Makloub - Viande Hachée',NULL,15.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-22.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(137,'Paninis - Escalope',NULL,9.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-23.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(138,'Paninis - Jambon',NULL,9.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-24.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(139,'Paninis - Thon',NULL,9.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-25.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(140,'Sandwich Pilote - Escalope','Blancs de poulet panés, Amandes, Gruyère, Cheddar',19.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(141,'Sandwichs Plan B - Chevrette',NULL,18.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-27.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(142,'Sandwichs Plan B - Cordon Bleu',NULL,14.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-28.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(143,'Sandwichs Plan B - Escalope Grillée',NULL,12.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-29.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(144,'Sandwichs Plan B - Escalope panée',NULL,12.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-30.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(145,'Sandwichs Plan B - Viande hachée',NULL,16.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-31.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(146,'Supplément Champignon',NULL,3.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(147,'Supplément Escalope',NULL,5.50,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(148,'Supplément Gruyère Holandais',NULL,6.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(149,'Supplément Jambon',NULL,3.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(150,'Supplément Mozzarella',NULL,5.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(151,'Supplément Œuf',NULL,1.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(152,'Supplément Sauce Fromage',NULL,4.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(153,'Supplément Thon',NULL,5.00,NULL,12,'Fast Food',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(154,'Tacos - Chevrette panées',NULL,17.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-40.png',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(155,'Tacos - Cordon Bleu',NULL,13.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-41.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(156,'Tacos - Escalope panée',NULL,11.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-42.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(157,'Tacos - Viande Hachée',NULL,15.00,NULL,12,'Fast Food','/storage/menu/fast-food/fast-food-43.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(158,'Crêpe classique','Thon, Fromage',11.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(159,'Crêpe escalope',NULL,12.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(160,'Crêpe fourrée chevrette','Fromage, Chevrette, sauce blanche',19.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-3.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(161,'Crêpe fourrée escalope',NULL,17.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(162,'Crêpe Français','Poulet, Champignon, Fromage, Sauce blanche, Sauce Fromage',15.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(163,'Crêpe jambon',NULL,10.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(164,'Crêpe Royale',NULL,18.00,NULL,13,'Crêpes Salées',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(165,'Crêpe Tunisienne','Harissa, Thon, Fromage, Œuf',12.00,NULL,13,'Crêpes Salées','/storage/menu/crepes-salees/crepes-salees-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(166,'Crêpe banane',NULL,10.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(167,'Crêpe BELLA VISTA',NULL,25.00,NULL,14,'Crêpes Sucrées',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(168,'Crêpe botanique','Fruits secs',8.00,NULL,14,'Crêpes Sucrées',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(169,'Crêpe bueno','Fruits secs - banane - bueno',12.00,NULL,14,'Crêpes Sucrées',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(170,'Crêpe chocolat',NULL,12.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-5.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(171,'Crêpe milka nutella banane',NULL,17.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(172,'Crêpe milka nutella fruits sec',NULL,17.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(173,'Crêpe milka nutella',NULL,15.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(174,'Crêpe milka nutella oreo',NULL,17.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-9.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(175,'Crêpe milka nutella spéculos',NULL,17.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-10.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(176,'Crêpe oreo',NULL,11.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(177,'Crêpe spéculoos',NULL,11.00,NULL,14,'Crêpes Sucrées','/storage/menu/crepes-sucrees/crepes-sucrees-12.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(178,'Gauffre Chevrette',NULL,18.00,NULL,15,'Gauffres Salées','/storage/menu/gauffres-salees/gauffres-salees-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(179,'Gauffre Poulet',NULL,15.00,NULL,15,'Gauffres Salées','/storage/menu/gauffres-salees/gauffres-salees-2.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(180,'Gauffre banane',NULL,15.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(181,'Gauffre botanique',NULL,15.00,NULL,16,'Gauffres Sucrées',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(182,'Gauffre Bueno',NULL,17.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(183,'Gauffre chocolat',NULL,13.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-4.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(184,'Gauffre Fruits de saison',NULL,17.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(185,'Gauffre oreo',NULL,16.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-6.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(186,'Gauffre spéculoos',NULL,16.00,NULL,16,'Gauffres Sucrées','/storage/menu/gauffres-sucrees/gauffres-sucrees-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(187,'Banana Split','Banane, 3 boules de glace, Crème chantilly',18.00,NULL,17,'Fruits Split','/storage/menu/fruits-split/fruits-split-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(188,'Corbeille de Fruits de saison',NULL,25.00,NULL,18,'Salade de Fruits',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(189,'Salade de Fruits glacés','Fruits, miel, boules de glace, crème de chantilly',12.00,NULL,18,'Salade de Fruits','/storage/menu/salade-de-fruits/salade-de-fruits-2.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(190,'Salade de Fruits secs & glacés','Fruits, miel, 2 boules de glace, fruits secs, crème de chantilly',16.00,NULL,18,'Salade de Fruits',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(191,'Salade de Fruits secs','Fruits, miel, fruits secs, crème de chantilly',12.00,NULL,18,'Salade de Fruits','/storage/menu/salade-de-fruits/salade-de-fruits-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(192,'Americain',NULL,4.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(193,'Café Avocato',NULL,6.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(194,'Café Liégeois',NULL,8.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-3.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(195,'Café Spécial','Café Nestlé',5.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(196,'Café Turc',NULL,6.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(197,'Caramel Latté Macchiato',NULL,7.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-6.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(198,'Chocolat Chaud',NULL,6.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(199,'Crème',NULL,4.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(200,'Double Express',NULL,5.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-9.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(201,'Express',NULL,3.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-10.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(202,'Macchiato',NULL,4.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-11.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(203,'Mocha Latté Macchiato',NULL,7.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(204,'Nutella Latté',NULL,10.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(205,'Pistache Latté',NULL,12.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-14.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(206,'Thé Amandes',NULL,7.00,NULL,19,'Boissons Chaudes',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(207,'Thé Baklawa',NULL,9.00,NULL,19,'Boissons Chaudes',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(208,'Thé Infusion',NULL,4.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-17.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(209,'Thé',NULL,2.50,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-18.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(210,'Thé pignons',NULL,8.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-19.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(211,'Vanilla Latté',NULL,6.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-20.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(212,'Verveine',NULL,4.00,NULL,19,'Boissons Chaudes','/storage/menu/boissons-chaudes/boissons-chaudes-21.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(213,'Américain Ice Coffee',NULL,5.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(214,'Banane Fraise Jus',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-2.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(215,'Banane Jus',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-3.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(216,'Banane Milkshake',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-4.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(217,'Banane Smoothie',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(218,'Boisson Énergétique',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-6.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(219,'Caramel Frappuccino',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(220,'Caramel Ice Coffee',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-8.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(221,'Chocolat Ice Coffee',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-9.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(222,'Chocolat Milkshake',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-10.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(223,'Citronnade',NULL,5.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-11.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(224,'Classic Mojito','Menthe verte, Citron, glaçon, sprite',8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-12.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(225,'Coffee Frappuccino',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-13.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(226,'Eau Minérale 0.5L',NULL,1.50,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-14.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(227,'Eau Minérale 1L',NULL,3.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-15.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(228,'Énergétique Mojito','Shark ou red bull, menthe verte, citron, glaçon',14.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-16.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(229,'Fraise Banane Smoothie',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-17.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(230,'Fraise Jus',NULL,7.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-18.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(231,'Fraise Milkshake',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-19.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(232,'Fraise Smoothie',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-20.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(233,'Cocktail Fruits de saison',NULL,12.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-21.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(234,'Garci',NULL,3.50,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-22.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(235,'Kiwi Banane Jus',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-23.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(236,'Lotus Ice Coffee',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-24.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(237,'Manga Ice Tea',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-25.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(238,'Noisette Milkshake',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-26.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(239,'Nutella Frappuccino (SPÉCIAL)',NULL,12.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-27.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(240,'Nutella Ice Coffee',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-28.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(241,'Orange',NULL,5.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-29.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(242,'Oreo Frappuccino (SPÉCIAL)',NULL,12.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-30.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(243,'Oreo Milkshake',NULL,11.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-31.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(244,'Parfumé Mojito','Sirop au choix: cerise, framboise, fraise, bleu, fruits de bois',10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-32.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(245,'Peach Ice Tea',NULL,8.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-33.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(246,'Pistache Milkshake',NULL,9.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-34.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(247,'Soda au choix',NULL,3.50,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-35.webp',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(248,'Speculoos Frappuccino (SPÉCIAL)',NULL,12.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-36.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(249,'Speculoos Milkshake',NULL,11.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-37.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(250,'Vanille Frappuccino',NULL,10.00,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-38.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(251,'Vanille Latté Ice Coffee',NULL,8.50,NULL,20,'Boissons Froides','/storage/menu/boissons-froides/boissons-froides-39.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(252,'Cheesecake',NULL,10.00,NULL,21,'Desserts','/storage/menu/desserts/desserts-1.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(253,'Gâteau au choix','Le prix varie',NULL,NULL,21,'Desserts','/storage/menu/desserts/desserts-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(254,'Jawejem Moyenne','Yaourt nature, Fruits, Fruits secs, Miel',10.00,NULL,21,'Desserts',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(255,'Jawejem XL','Yaourt nature, Fruits, Fruits secs, nutella',15.00,NULL,21,'Desserts',NULL,1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(256,'San Sebastian',NULL,11.00,NULL,21,'Desserts','/storage/menu/desserts/desserts-5.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(257,'Tiramisu Classique Nutella',NULL,11.00,NULL,21,'Desserts','/storage/menu/desserts/desserts-6.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(258,'Tiramisu Lotus',NULL,12.50,NULL,21,'Desserts','/storage/menu/desserts/desserts-7.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(259,'Tiramisu Pistache',NULL,14.00,NULL,21,'Desserts','/storage/menu/desserts/desserts-8.jpeg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(261,'Coupe 2 Boules',NULL,7.00,NULL,22,'Glaces','/storage/menu/glaces/glaces-2.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19'),(262,'Coupe 3 Boules',NULL,10.00,NULL,22,'Glaces','/storage/menu/glaces/glaces-3.jpg',1,0,NULL,NULL,'2026-08-02 12:22:19','2026-08-02 12:22:19');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_01_01_000001_create_categories_table',1),(6,'2024_01_01_000002_create_menu_items_table',1),(7,'2024_01_01_000003_create_orders_table',1),(8,'2024_01_01_000004_create_order_items_table',1),(9,'2024_01_01_000005_create_reservations_table',1),(10,'2024_01_01_000006_create_delivery_zones_table',1),(11,'2024_01_01_000007_create_restaurant_infos_table',1),(12,'2024_01_01_000008_create_reviews_table',1),(13,'2026_08_02_000001_alter_menu_items_price_nullable',2),(14,'2026_08_02_000002_add_google_info_to_restaurant_infos_table',3),(15,'2026_08_02_000003_add_delivery_fee_columns',4),(16,'2024_01_01_000009_update_users_and_orders_table',5),(17,'2026_08_03_000001_add_analytics_columns',6),(18,'2026_08_03_000002_create_customer_notifications_table',7),(19,'2026_08_03_000003_add_firebase_uid_to_users_table',8),(20,'2026_08_03_000004_add_google_id_to_users_table_and_drop_firebase_uid',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `menu_item_id` bigint(20) unsigned DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `unit_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_item_id_foreign` (`menu_item_id`),
  CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,2,12,'Brik Diari',6.00,1,NULL,'2026-08-02 20:18:14','2026-08-02 20:18:14'),(4,2,13,'Brik Thon',6.00,1,NULL,'2026-08-02 20:18:14','2026-08-02 20:18:14'),(5,2,14,'Calamar Doré',28.50,1,NULL,'2026-08-02 20:18:14','2026-08-02 20:18:14'),(6,2,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-02 20:18:14','2026-08-02 20:18:14'),(7,3,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:43:30','2026-08-03 14:43:30'),(8,4,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:43:49','2026-08-03 14:43:49'),(9,5,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:44:07','2026-08-03 14:44:07'),(10,6,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:44:28','2026-08-03 14:44:28'),(11,7,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:45:52','2026-08-03 14:45:52'),(12,8,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:47:02','2026-08-03 14:47:02'),(13,9,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:47:23','2026-08-03 14:47:23'),(14,10,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:47:51','2026-08-03 14:47:51'),(15,11,88,'Symphonie Royale BELLA VISTA (2 Pers)',130.00,4,NULL,'2026-08-03 14:48:11','2026-08-03 14:48:11'),(16,12,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 14:49:52','2026-08-03 14:49:52'),(17,12,12,'Brik Diari',6.00,1,NULL,'2026-08-03 14:49:52','2026-08-03 14:49:52'),(18,12,13,'Brik Thon',6.00,1,NULL,'2026-08-03 14:49:52','2026-08-03 14:49:52'),(19,12,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 14:49:52','2026-08-03 14:49:52'),(20,12,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 14:49:52','2026-08-03 14:49:52'),(21,13,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 18:41:29','2026-08-03 18:41:29'),(22,13,12,'Brik Diari',6.00,1,NULL,'2026-08-03 18:41:29','2026-08-03 18:41:29'),(23,13,13,'Brik Thon',6.00,1,NULL,'2026-08-03 18:41:29','2026-08-03 18:41:29'),(24,13,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 18:41:29','2026-08-03 18:41:29'),(25,13,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 18:41:29','2026-08-03 18:41:29'),(26,14,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 18:45:20','2026-08-03 18:45:20'),(27,14,12,'Brik Diari',6.00,1,NULL,'2026-08-03 18:45:20','2026-08-03 18:45:20'),(28,14,13,'Brik Thon',6.00,1,NULL,'2026-08-03 18:45:20','2026-08-03 18:45:20'),(29,14,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 18:45:20','2026-08-03 18:45:20'),(30,14,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 18:45:20','2026-08-03 18:45:20'),(31,15,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 18:45:29','2026-08-03 18:45:29'),(32,15,12,'Brik Diari',6.00,1,NULL,'2026-08-03 18:45:29','2026-08-03 18:45:29'),(33,15,13,'Brik Thon',6.00,1,NULL,'2026-08-03 18:45:29','2026-08-03 18:45:29'),(34,15,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 18:45:29','2026-08-03 18:45:29'),(35,15,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 18:45:29','2026-08-03 18:45:29'),(38,19,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 20:50:26','2026-08-03 20:50:26'),(39,19,12,'Brik Diari',6.00,1,NULL,'2026-08-03 20:50:26','2026-08-03 20:50:26'),(40,19,13,'Brik Thon',6.00,1,NULL,'2026-08-03 20:50:26','2026-08-03 20:50:26'),(41,19,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 20:50:26','2026-08-03 20:50:26'),(42,19,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 20:50:26','2026-08-03 20:50:26'),(43,20,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 20:50:35','2026-08-03 20:50:35'),(44,20,12,'Brik Diari',6.00,1,NULL,'2026-08-03 20:50:35','2026-08-03 20:50:35'),(45,20,13,'Brik Thon',6.00,1,NULL,'2026-08-03 20:50:35','2026-08-03 20:50:35'),(46,20,14,'Calamar Doré',28.50,1,NULL,'2026-08-03 20:50:35','2026-08-03 20:50:35'),(47,20,15,'Chevrettes Panées',31.50,1,NULL,'2026-08-03 20:50:35','2026-08-03 20:50:35'),(49,22,11,'Brik Chevrette',7.00,1,NULL,'2026-08-03 21:01:06','2026-08-03 21:01:06'),(50,22,12,'Brik Diari',6.00,1,NULL,'2026-08-03 21:01:06','2026-08-03 21:01:06'),(51,22,13,'Brik Thon',6.00,1,NULL,'2026-08-03 21:01:06','2026-08-03 21:01:06'),(52,22,16,'Chevrettes Sautées à L\'aille',29.50,1,NULL,'2026-08-03 21:01:06','2026-08-03 21:01:06'),(53,22,17,'Cocotte Moules sautées',34.50,1,NULL,'2026-08-03 21:01:06','2026-08-03 21:01:06');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cash_on_delivery',
  `order_type` varchar(255) NOT NULL DEFAULT 'delivery',
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `flouci_payment_id` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_zone_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_delivery_zone_id_foreign` (`delivery_zone_id`),
  CONSTRAINT `orders_delivery_zone_id_foreign` FOREIGN KEY (`delivery_zone_id`) REFERENCES `delivery_zones` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (2,NULL,'drde','rderdre','rdtred\'e(',84.00,5.00,'confirmed',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,'rdedredre','2026-08-02 20:18:14','2026-08-02 20:19:02',NULL),(3,8,'Test Customer','+21698123456','Rue de la Liberté, Korba 8090',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:43:30','2026-08-03 14:43:30',NULL),(4,9,'Test Customer','+21698123456','Rue de la Liberté, Korba 8090',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:43:49','2026-08-03 14:43:49',NULL),(5,10,'Test Customer','+21698123456','Rue de la Liberté, Korba 8090',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:44:07','2026-08-03 14:44:07',NULL),(6,NULL,'Guest Flouci','+21698123456','Korba',525.00,5.00,'pending',NULL,NULL,'flouci_card','delivery','failed',NULL,NULL,'2026-08-03 14:44:28','2026-08-03 14:44:28',NULL),(7,12,'Leak Test','+21611111111','Korba',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:45:52','2026-08-03 14:45:52',NULL),(8,14,'Tracker Test','+21633333333','Korba',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:47:02','2026-08-03 14:47:02',NULL),(9,15,'Tracker Test2','+21644444444','Korba',525.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:47:23','2026-08-03 14:47:23',NULL),(10,16,'T3','+21655555555','Korba',525.00,5.00,'preparing',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:47:51','2026-08-03 14:47:55',NULL),(11,17,'T4','+21666666666','Korba',525.00,5.00,'cancelled',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,NULL,'2026-08-03 14:48:11','2026-08-03 14:48:15',NULL),(12,NULL,'bvbv','bvbv','bvbvbv',84.00,5.00,'pending',NULL,NULL,'flouci_card','delivery','failed',NULL,'bvbv','2026-08-03 14:49:52','2026-08-03 14:49:52',NULL),(13,18,'iheb','55553187','dsfds',84.00,5.00,'confirmed',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,'sdfdsff','2026-08-03 18:41:29','2026-08-03 20:57:11',1),(14,NULL,'hgfhg','hgfh','hfghgf',84.00,5.00,'pending',NULL,NULL,'flouci_card','delivery','failed',NULL,'gvfdgfdfdgfdg','2026-08-03 18:45:20','2026-08-03 18:45:21',1),(15,NULL,'hgfhg','hgfh','hfghgf',84.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,'gvfdgfdfdgfdg','2026-08-03 18:45:29','2026-08-03 18:45:29',1),(19,NULL,'bvbv','hgfh','ue-(èu',84.00,5.00,'pending',NULL,NULL,'flouci_card','delivery','failed',NULL,'eyu','2026-08-03 20:50:26','2026-08-03 20:50:26',1),(20,NULL,'bvbv','hgfh','ue-(èu',84.00,5.00,'confirmed',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,'eyu','2026-08-03 20:50:35','2026-08-03 20:55:42',1),(22,NULL,'zae','ezr','ezrfez',88.00,5.00,'pending',NULL,NULL,'cash_on_delivery','delivery','unpaid',NULL,'REER','2026-08-03 21:01:06','2026-08-03 21:01:06',1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('cust8133@test.tn','$2y$10$d7zU6dCG6PnsLwoPZHWfp.q0ykaZukwGQs5/jlVLE/VyR12C5x5Ie','2026-08-03 20:37:01');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_infos`
--

DROP TABLE IF EXISTS `restaurant_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_infos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'AURA Fine Dining',
  `hours` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `delivery_radius` varchar(255) NOT NULL DEFAULT '10 km',
  `min_order_amount` decimal(8,2) NOT NULL DEFAULT 30.00,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `plus_code` varchar(255) DEFAULT NULL,
  `cover_url` varchar(255) DEFAULT NULL,
  `maps_url` varchar(255) DEFAULT NULL,
  `place_id` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_infos`
--

LOCK TABLES `restaurant_infos` WRITE;
/*!40000 ALTER TABLE `restaurant_infos` DISABLE KEYS */;
INSERT INTO `restaurant_infos` VALUES (1,'Bella Artista','6:00 AM - 3:00 AM','Avenue de l\'Environnement, Korba, Tunisia','+216 21 804 841','{\"facebook\":\"https:\\/\\/www.facebook.com\\/Bella.artiista\",\"whatsapp\":\"https:\\/\\/wa.me\\/21625258000\",\"maps\":\"https:\\/\\/maps.app.goo.gl\\/4f47MFWhXrCAPzxBA\",\"phone_secondary\":\"+216 25 258 000\"}','15 km in-house radius',50.00,5.00,'2026-08-02 10:29:07','2026-08-02 13:26:14','/storage/restaurant/bella-artista-logo.png','Le concept premium incontournable a Korba.',3.90,'M8G8+7M Korba','/storage/restaurant/bella-artista-cover.jpg','https://maps.google.com','ChIJc3szabe7AhMRb3e4lyOZTC8',36.5761121,10.8639316);
/*!40000 ALTER TABLE `restaurant_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'Lord Edward Sterling',5,'An absolute culinary triumph. The Wagyu Carpaccio and Filet Mignon were exquisite.','2026-07-30',1,'2026-08-02 10:29:07','2026-08-02 10:29:07'),(2,'Victoria Vance',5,'The atmosphere, the dark velvet aesthetic, and the wine pairings were perfection.','2026-07-23',1,'2026-08-02 10:29:07','2026-08-02 10:29:07');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Manager','admin@aura.com',NULL,NULL,'$2y$10$ur/ci/D/2A67ZCTvicxSO.yF9.7m6GhjXanfrN9NC9Ux3rQTFID1e',NULL,'admin',NULL,'2026-08-02 10:29:07','2026-08-03 20:41:53'),(2,'Test Customer','cust8133@test.tn','+21698123456',NULL,'$2y$10$hOjv4ZavIIus32x1HlWsseynUrIcTqS./G0DdoFgbpVH1lv7pVRRK',NULL,'customer',NULL,'2026-08-03 14:41:03','2026-08-03 18:57:37'),(3,'Test Customer','cust89879@test.tn','+21698123456',NULL,'$2y$10$GKhoZfZzeuA6PiwePgqHR../OnkissOw7zI5Twtp6t1AW38tULwny',NULL,'customer',NULL,'2026-08-03 14:41:15','2026-08-03 14:41:15'),(4,'Test Customer','cust15164@test.tn','+21698123456',NULL,'$2y$10$3BzP8LXXto6Q/sUn.KmdsO5GVXzh4E3HnuMZU4Of7ssYML9dIg.US',NULL,'customer',NULL,'2026-08-03 14:41:30','2026-08-03 14:41:30'),(5,'Test Customer','cust37994@test.tn','+21698123456',NULL,'$2y$10$WVk1R3YK71iUeUKKbGSBE.USxrzz0tLffXU7QQ1rzrjATxPYQIsmK',NULL,'customer',NULL,'2026-08-03 14:41:44','2026-08-03 14:41:44'),(6,'Test Customer','cust15938@test.tn','+21698123456',NULL,'$2y$10$MK.VRKV1aYkYk.cD6LbLaeBkk/g7PvvaAnb/VCX.JgLquN.qqGJVi',NULL,'customer',NULL,'2026-08-03 14:42:38','2026-08-03 14:42:38'),(7,'Test Customer','cust55396@test.tn','+21698123456',NULL,'$2y$10$NFwGWDOSREVVhc.wdOzgC.KxOOpTVUHMBKn45NmLbZi/RS3qRLnHO',NULL,'customer',NULL,'2026-08-03 14:43:10','2026-08-03 14:43:10'),(8,'Test Customer','cust6653@test.tn','+21698123456',NULL,'$2y$10$lRW5JbPn.NKth1gc.oqJJOSaHtt.7fL9dfeQgslNP.A5H.ETkgNsG',NULL,'customer',NULL,'2026-08-03 14:43:29','2026-08-03 14:43:29'),(9,'Test Customer','cust61565@test.tn','+21698123456',NULL,'$2y$10$6Ngw/1zDeI/XDONGsan3ie1gX.2aQ0vJiNghyGiv19//jruO17Mta',NULL,'customer',NULL,'2026-08-03 14:43:48','2026-08-03 14:43:48'),(10,'Test Customer','cust25669@test.tn','+21698123456',NULL,'$2y$10$9JtgSaX8moMDlMMo44MoMeVxILHvJh6SlNIfDt2gKOH8WtXEGq/xW',NULL,'customer',NULL,'2026-08-03 14:44:05','2026-08-03 14:44:05'),(11,'Cust','cust65744@test.tn','+21611111111',NULL,'$2y$10$QHS3fMlEopDDmnDQPkx05.mak/hyDB1iBM0oOywV5gro2Q5Uq8OMS',NULL,'customer',NULL,'2026-08-03 14:45:34','2026-08-03 14:45:34'),(12,'Leak Test','cust53273@test.tn','+21611111111',NULL,'$2y$10$.l9aFsUVNZNTUSpA2dIeAujuFzNXictuoskpLHgrzuFii9Fm3ZaNm',NULL,'customer',NULL,'2026-08-03 14:45:51','2026-08-03 14:45:51'),(13,'Logout Test','cust85902@test.tn','+21622222222',NULL,'$2y$10$DvvgLL/xb/g1UsjcRbYoL.kAGmKhMVeNQHLB.Y7ZmwFYwmzPkVp1O',NULL,'customer',NULL,'2026-08-03 14:46:39','2026-08-03 14:46:39'),(14,'Tracker Test','cust49468@test.tn','+21633333333',NULL,'$2y$10$9b58Qr.jQh5nvIiwRduMRe9OV.KkCJkxoe/ugP4wzVMdLT7k2d7KW',NULL,'customer',NULL,'2026-08-03 14:47:00','2026-08-03 14:47:00'),(15,'Tracker Test2','cust28345@test.tn','+21644444444',NULL,'$2y$10$bBxPF3NU2CPO6txBUNj03eu3OspuRS2xj4bVn/N3lRkmCbocIbz5K',NULL,'customer',NULL,'2026-08-03 14:47:22','2026-08-03 14:47:22'),(16,'T3','cust86770@test.tn','+21655555555',NULL,'$2y$10$2V7fvVtVyX0eVRD7OmsJQOrtyBi/zy.0RmUfjH7BDi6qYKbHMmCli',NULL,'customer',NULL,'2026-08-03 14:47:50','2026-08-03 14:47:50'),(17,'T4','cust21467@test.tn','+21666666666',NULL,'$2y$10$mO/l.j/daodUkf5JBr4M1.8jI201pqCwdT1AskL6xcc8blKlF7/ha',NULL,'customer',NULL,'2026-08-03 14:48:10','2026-08-03 14:48:10'),(18,'iheb','ihebnj7@gmail.com','55553187',NULL,'$2y$10$dMTZ3Mcyj59M1tdreHArM.YBMTX2FgK0h2RNKuMtnEHaGLmRKhusm','110810537403611581490','customer',NULL,'2026-08-03 18:40:45','2026-08-03 20:51:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'restaurantApp'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-03 23:52:45

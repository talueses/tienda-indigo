-- MariaDB dump 10.18  Distrib 10.5.8-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: indigo_one
-- ------------------------------------------------------
-- Server version	10.5.8-MariaDB

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
-- Table structure for table `artistas`
--

DROP TABLE IF EXISTS `artistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artistas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estudios` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muestras` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `premios` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_portada` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL,
  `destacado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artistas_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistas`
--

LOCK TABLES `artistas` WRITE;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
INSERT INTO `artistas` VALUES (1,'Alejandra','Devescovi','c855472ea5376303baa59ecd719639da.jpg','Peru','Lima','55555555','<p style=\"font-family: Arial, sans-serif; font-size: 14px;\">Fot&oacute;grafa peruana con&nbsp;<strong>estudios&nbsp;</strong>en Lima, Nueva York y Barcelona. Luego de dedicarse a la docencia por algunos a&ntilde;os, expuso en Lima, Buenos Aires y Barcelona, y colabor&oacute; con diferentes medios como fot&oacute;grafa.</p>\r\n<p style=\"font-family: Arial, sans-serif; font-size: 14px;\">Durante dos a&ntilde;os fue editora gr&aacute;fica de la revista El Rocoto en Barcelona, publicaci&oacute;n mensual dirigida a peruanos radicados en Espa&ntilde;a. En el 2008 crea MMT Photography &amp; Graphics, estudio editorial, con fotograf&iacute;a, dise&ntilde;o gr&aacute;fico, video y direcci&oacute;n de arte.(www.mmt.com.pe). Su trabajo es variado, va desde retratos, arquitectura, bandas de rock hasta viajes, ya sean paisajes o personas, tambi&eacute;n ha desarrollado una l&iacute;nea m&aacute;s conceptual y abstracta.</p>','<ul>\r\n<li>Estudio 1</li>\r\n<li>Estudio 2</li>\r\n<li>Estudio 3</li>\r\n<li>Estudio 4&nbsp;</li>\r\n</ul>','<ul style=\"font-family: Arial, sans-serif; font-size: 14px;\">\r\n<li>Muestra 1</li>\r\n<li>Muestra 2</li>\r\n<li>Muestra 3</li>\r\n<li>Muestra 4</li>\r\n</ul>','<p>Hola no se como se ponen vi&ntilde;etas :(</p>','alejandra-devescovi','50a068198bc40baf9becd2ebcdfd8fb6.jpg',1,1,'2019-11-07 17:18:23','2020-03-05 17:51:23');
/*!40000 ALTER TABLE `artistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorias_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Antigüedades',NULL),(2,'Arte asiático',NULL),(3,'Arte contemporáneo',NULL),(4,'Arte impresionista y moderno',NULL),(5,'Arte Utilitario',NULL),(6,'Arte moderno','Todas las obras de corte contemporáneo y moderno.');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (1,'test','test@test.com','uoyvasvufd','2019-12-02 22:23:26','2019-12-02 22:23:26'),(2,'test','test@test.com','Testing','2019-12-02 22:35:55','2019-12-02 22:35:55');
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuenta_regalos`
--

DROP TABLE IF EXISTS `cuenta_regalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta_regalos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cuenta_regalos_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_regalos`
--

LOCK TABLES `cuenta_regalos` WRITE;
/*!40000 ALTER TABLE `cuenta_regalos` DISABLE KEYS */;
INSERT INTO `cuenta_regalos` VALUES (3,'soporte@ilustraconsultores.com','$2y$10$KvtH11xIS82Ek6Wv6nxih.5icHQHenCAKx2l1XcY.eEVduJMRu0Ti','0c7d9b7aa2a8bad17b44109353f5542438113b609985c8fb1b59b3b1dfb357c6',NULL,'2019-11-12 00:14:33','2019-11-12 00:14:33','2020-01-15 18:33:17'),(4,'ricardo@ilustraconsultores.com','$2y$10$ArZBHXmVXA91j7PjSJeOIOpb0P.h/JDr3MUZGAV78Ma3GNlefF5da','d131c25698e4b6498decedca8fd4abfe3d0f3ab88b0716c7c51121d88bfca6f2',NULL,'2019-12-03 20:13:24','2019-12-03 20:13:24','2019-12-03 20:13:24'),(5,'emanuel@ilustraconsultores.com','$2y$10$.qY6Tk7boM9kCnrHIbDBH.uM9js.HKV8/iWQEScNbWW5xjnJNOnxW','3f496cb9c9334c47f20dd83efb09b9cbbfb0f2177467d10eb3d5d2ca92aa1ecc',NULL,'2020-01-15 18:28:13','2020-01-15 18:28:13','2020-01-15 18:28:13');
/*!40000 ALTER TABLE `cuenta_regalos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `pais_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departamentos_pais_id_foreign` (`pais_id`),
  CONSTRAINT `departamentos_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'Lima',1,1,NULL,NULL),(2,'Amazonas',1,1,NULL,NULL),(3,'Ancash',1,1,NULL,NULL),(4,'Apurimac',1,1,NULL,NULL),(5,'Arequipa',1,1,NULL,NULL),(6,'Ayacucho',1,1,NULL,NULL),(7,'Cajamarca',1,1,NULL,NULL),(8,'Callao',1,1,NULL,NULL),(9,'Cusco',1,1,NULL,NULL),(10,'Huancavelica',1,1,NULL,NULL),(11,'Huanuco',1,1,NULL,NULL),(12,'Ica',1,1,NULL,NULL),(13,'Junin',1,1,NULL,NULL),(14,'La Libertad',1,1,NULL,NULL),(15,'Lambayeque',1,1,NULL,NULL),(16,'Loreto',1,1,NULL,NULL),(17,'Madre De Dios',1,1,NULL,NULL),(18,'Moquegua',1,1,NULL,NULL),(19,'Pasco',1,1,NULL,NULL),(20,'Piura',1,1,NULL,NULL),(21,'Puno',1,1,NULL,NULL),(22,'San Martin',1,1,NULL,NULL),(23,'Tacna',1,1,NULL,NULL),(24,'Tumbes',1,1,NULL,NULL),(25,'Ucayali',1,1,NULL,NULL);
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `descuentos`
--

DROP TABLE IF EXISTS `descuentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `descuentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descuento` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `aplicado` int(11) DEFAULT NULL,
  `procesado` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `descuentos_user_id_foreign` (`user_id`),
  CONSTRAINT `descuentos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `descuentos`
--

LOCK TABLES `descuentos` WRITE;
/*!40000 ALTER TABLE `descuentos` DISABLE KEYS */;
INSERT INTO `descuentos` VALUES (1,'2020-05-15','2020-05-22',15,1,1,1,1,'2020-05-16 03:21:35','2020-05-16 03:21:35'),(2,'2020-05-15','2020-05-21',13,1,1,1,1,'2020-05-16 03:22:05','2020-05-16 03:22:05'),(3,'2020-05-21','2020-05-28',20,4,1,1,1,'2020-05-22 02:19:58','2020-05-22 02:19:58'),(4,'2020-05-21','2020-05-22',20,4,2,1,1,'2020-05-22 02:24:33','2020-05-22 02:24:33'),(5,'2020-05-21','2020-05-22',10,4,2,1,1,'2020-05-22 02:27:28','2020-05-22 02:27:28'),(6,'2020-05-21','2020-05-29',10,4,1,1,1,'2020-05-22 02:28:50','2020-05-22 02:28:50'),(7,'2020-05-21','2020-05-23',10,4,2,1,1,'2020-05-22 02:28:50','2020-05-22 02:28:50'),(8,'2020-05-25','2020-05-26',20,4,5,1,NULL,'2020-05-25 21:34:20','2020-05-25 21:34:20'),(9,'2020-05-25','2020-05-31',1,4,2,1,1,'2020-05-26 03:07:04','2020-05-26 03:07:04'),(10,'2020-06-16','2020-07-07',18,1,2,1,1,'2020-06-16 20:40:47','2020-06-16 20:40:47'),(11,'2020-06-16','2020-06-18',15,6,1,1,1,'2020-06-16 20:49:31','2020-06-16 20:49:31'),(12,'2020-06-30','2020-08-31',80,1,6,1,1,'2020-06-30 23:43:41','2020-06-30 23:43:41'),(13,'2020-08-12','2020-09-05',52,1,6,1,NULL,'2020-08-12 17:31:09','2020-08-12 17:31:10'),(14,'2020-08-12','2020-09-30',13,1,2,1,NULL,'2020-08-12 17:31:31','2020-08-12 17:31:31');
/*!40000 ALTER TABLE `descuentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distritos`
--

DROP TABLE IF EXISTS `distritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distritos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `departamento_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distritos_departamento_id_foreign` (`departamento_id`),
  CONSTRAINT `distritos_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distritos`
--

LOCK TABLES `distritos` WRITE;
/*!40000 ALTER TABLE `distritos` DISABLE KEYS */;
INSERT INTO `distritos` VALUES (1,'Barranco',1,1,1,NULL,NULL),(2,'Miraflores',1,1,1,NULL,NULL),(3,'Surco',1,1,1,NULL,NULL),(4,'San Borja',1,1,1,NULL,NULL),(5,'Surquillo',1,1,1,NULL,NULL),(6,'San Isidro',1,1,1,NULL,NULL),(7,'Chorrillos',1,1,1,NULL,NULL),(8,'Cercado',1,1,1,NULL,NULL),(9,'San Luis',1,1,1,NULL,NULL),(10,'Breña',1,1,1,NULL,NULL),(11,'La Victoria',1,1,1,NULL,NULL),(12,'Rimac',1,1,1,NULL,NULL),(13,'Lince',1,1,1,NULL,NULL),(14,'San Miguel',1,1,1,NULL,NULL),(15,'Jesús María',1,1,1,NULL,NULL),(16,'Magdalena',1,1,1,NULL,NULL),(17,'Pblo. Libre',1,1,1,NULL,NULL),(18,'Ancon',1,0,1,NULL,NULL),(19,'Ate',1,0,1,NULL,NULL),(20,'Carabayllo',1,0,1,NULL,NULL),(21,'Chaclacayo',1,0,1,NULL,NULL),(22,'Cieneguilla',1,0,1,NULL,NULL),(23,'Comas',1,0,1,NULL,NULL);
/*!40000 ALTER TABLE `distritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exposiciones`
--

DROP TABLE IF EXISTS `exposiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exposiciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artista` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL,
  `hora` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distrito` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `galeria_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuente` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exposiciones_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exposiciones`
--

LOCK TABLES `exposiciones` WRITE;
/*!40000 ALTER TABLE `exposiciones` DISABLE KEYS */;
INSERT INTO `exposiciones` VALUES (1,NULL,'<p><a title=\"nota\" href=\"http://www.enlima.pe/agenda-cultural/exposicion/deseo-y-memoria\">http://www.enlima.pe/agenda-cultural/exposicion/deseo-y-memoria</a></p>','ARTE AERO',NULL,1,NULL,NULL,NULL,NULL,NULL,'2018-06-13 05:00:00',NULL,'arte-aero',NULL,'[\"1_20623130645d267aa931167c17f0e43714093ea2.jpg\"]','nota',NULL,'2019-11-07 17:41:01','2019-11-07 17:41:35'),(2,'ff6cf1792723f67e7637bc32c28a5573.jpg','<p>test</p>','El grito 2',NULL,1,'11:00','Museo Central','Lima','av la mar 832',90.00,'2020-05-03 05:00:00','2020-05-22 05:00:00','el-grito-2',NULL,'[\"_37_57f9adc23696f1fa4257687bd0825e8c.jpg\",\"_37_80x80_1aee30ce2111a96201d485aa413409c5.jpg\",\"_37_80x80_1f312d3b8d7b036da043ae1384d009d1.jpg\"]','evento',NULL,'2019-11-07 20:47:42','2019-11-07 20:47:42');
/*!40000 ALTER TABLE `exposiciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generales`
--

DROP TABLE IF EXISTS `generales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generales`
--

LOCK TABLES `generales` WRITE;
/*!40000 ALTER TABLE `generales` DISABLE KEYS */;
INSERT INTO `generales` VALUES (1,'facebook','https://facebook.com/GaleriaIndigo/',NULL,NULL),(2,'instagram','https://www.instagram.com/galeria.indigo/',NULL,NULL),(3,'twitter',NULL,NULL,NULL),(4,'tripadvisor','https://www.tripadvisor.com.pe/Attraction_Review-g294316-d8468446-Reviews-Galeria_Indigo-Lima_Lima_Region.html',NULL,NULL),(5,'free_delivery','Todos los miercoles de 11 a.m. - 8 p.m.',NULL,NULL),(6,'telefonos','440-3099, 421-2428 y 441-2232.',NULL,NULL),(7,'direccion','Av. El Bosque 260 y 263, San Isidro.',NULL,NULL),(8,'horarios','Lunes a Sábados de 11 a.m. - 8 p.m.\r\n\r\nDomingos y feriados de 11 a.m. - 7 p.m.',NULL,NULL),(9,'terminos_condiciones','',NULL,NULL),(10,'politicas_privacidad','',NULL,NULL),(11,'politicas_devoluciones','',NULL,NULL);
/*!40000 ALTER TABLE `generales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_regalo`
--

DROP TABLE IF EXISTS `lista_regalo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_regalo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuenta_regalos_id` int(10) unsigned NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizador_uno` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizador_dos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `entrega` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distrito` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `costo_envio` decimal(10,2) DEFAULT NULL,
  `edicion_finalizada` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tracking` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lista_regalo_codigo_unique` (`codigo`),
  KEY `lista_regalo_cuenta_regalos_id_foreign` (`cuenta_regalos_id`),
  CONSTRAINT `lista_regalo_cuenta_regalos_id_foreign` FOREIGN KEY (`cuenta_regalos_id`) REFERENCES `cuenta_regalos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_regalo`
--

LOCK TABLES `lista_regalo` WRITE;
/*!40000 ALTER TABLE `lista_regalo` DISABLE KEYS */;
INSERT INTO `lista_regalo` VALUES (3,'COD181219T',3,'098f6bcd4621d373cade4e832627b4f6.jpeg','Test',NULL,NULL,NULL,'2019-12-18 05:00:00','recojo_tienda',NULL,NULL,NULL,NULL,1,'2019-12-03 17:33:52','2020-01-15 18:34:21','',NULL),(4,'COD301220P',4,NULL,'Programa Vue JS',NULL,NULL,NULL,'2019-12-30 05:00:00','recojo_tienda',NULL,NULL,NULL,NULL,1,'2019-12-03 20:13:54','2019-12-03 20:14:40','',NULL),(5,'CODUD300320P',5,'c893bad68927b457dbed39460e6afd62.png','prueba','prueba','uno','dis','2022-06-03 17:57:30','delivery','ancash',NULL,'Av. La Mar 832 - Miraflores',100.00,0,'2020-01-15 18:30:44','2020-01-15 18:58:41','',NULL);
/*!40000 ALTER TABLE `lista_regalo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_regalo_password_resets`
--

DROP TABLE IF EXISTS `lista_regalo_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_regalo_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `lista_regalo_password_resets_email_index` (`email`),
  KEY `lista_regalo_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_regalo_password_resets`
--

LOCK TABLES `lista_regalo_password_resets` WRITE;
/*!40000 ALTER TABLE `lista_regalo_password_resets` DISABLE KEYS */;
INSERT INTO `lista_regalo_password_resets` VALUES ('ricardo@ilustraconsultores.com','$2y$10$OtPsblGgv9mbA29pEmL1V.etvY2v6lKSly8zqmxu1Nepo/0KsOofW','2019-11-07 21:19:09');
/*!40000 ALTER TABLE `lista_regalo_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_regalo_producto`
--

DROP TABLE IF EXISTS `lista_regalo_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_regalo_producto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lista_regalos_id` int(10) unsigned NOT NULL,
  `producto_id` int(10) unsigned NOT NULL,
  `solicitados` int(11) NOT NULL,
  `recibidos` int(11) NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recargo` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lista_regalo_producto_producto_id_foreign` (`producto_id`),
  KEY `lista_regalo_producto_lista_regalos_id_index` (`lista_regalos_id`),
  CONSTRAINT `lista_regalo_producto_lista_regalos_id_foreign` FOREIGN KEY (`lista_regalos_id`) REFERENCES `lista_regalo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lista_regalo_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_regalo_producto`
--

LOCK TABLES `lista_regalo_producto` WRITE;
/*!40000 ALTER TABLE `lista_regalo_producto` DISABLE KEYS */;
INSERT INTO `lista_regalo_producto` VALUES (5,3,2,1,0,'verde',NULL,'2019-12-03 17:34:18','2019-12-03 17:34:18'),(6,3,1,1,0,NULL,NULL,'2019-12-03 17:34:22','2019-12-03 17:34:22'),(7,4,2,1,0,'verde',NULL,'2019-12-03 20:14:02','2019-12-03 20:14:02'),(8,4,1,3,0,NULL,NULL,'2019-12-03 20:14:08','2019-12-03 20:14:08'),(9,5,1,5,0,NULL,100.00,'2020-01-15 18:31:07','2020-01-15 18:58:54');
/*!40000 ALTER TABLE `lista_regalo_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materiales`
--

DROP TABLE IF EXISTS `materiales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materiales_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiales`
--

LOCK TABLES `materiales` WRITE;
/*!40000 ALTER TABLE `materiales` DISABLE KEYS */;
INSERT INTO `materiales` VALUES (1,'Asperiores','Nobis aut unde vero saepe corporis quam totam. Debitis dignissimos deleniti porro quis. Quae earum porro iste odit voluptatibus incidunt laborum.'),(2,'Piedra','Todos los productos hechos a base de piedra.');
/*!40000 ALTER TABLE `materiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodo_pagos`
--

DROP TABLE IF EXISTS `metodo_pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metodo_pagos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `metodo_pagos_codigo_index` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodo_pagos`
--

LOCK TABLES `metodo_pagos` WRITE;
/*!40000 ALTER TABLE `metodo_pagos` DISABLE KEYS */;
INSERT INTO `metodo_pagos` VALUES (1,'credito',''),(2,'debito','');
/*!40000 ALTER TABLE `metodo_pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2018_01_26_095138_create_table_paises',1),(3,'2018_02_09_173500_create_roles_table',1),(4,'2018_02_10_000000_create_users_table',1),(5,'2018_02_10_172622_create_tipos_table',1),(6,'2018_02_14_174816_create_metodo_pagos_table',1),(7,'2018_02_14_175511_create_categorias_table',1),(8,'2018_02_14_181847_create_artistas_table',1),(9,'2018_02_14_182533_create_productos_table',1),(10,'2018_02_14_184201_create_ordenes_table',1),(11,'2018_02_14_192513_create_obras_table',1),(12,'2018_02_15_143917_create_pagos_table',1),(13,'2018_02_15_175515_create_cuenta_regalos_table',1),(14,'2018_02_15_175618_create_lista_regalo_table',1),(15,'2018_02_15_175918_create_lista_regalo_producto_table',1),(16,'2018_02_15_175928_create_orden_producto_table',1),(17,'2018_03_01_113848_create_exposiciones_table',1),(18,'2018_03_19_172717_create_paginas_table',1),(19,'2018_03_21_181303_create_generales_table',1),(20,'2018_04_12_144017_create_materiales_table',1),(21,'2018_04_12_153903_create_obra_material_table',1),(22,'2018_04_12_153914_create_producto_material_table',1),(23,'2018_05_30_162655_create_contacto_table',1),(24,'2018_07_13_115319_create_newsletter_table',1),(25,'2019_03_12_121550_create_lista_regalo_password_reset_table',1),(26,'2019_04_01_123117_create_sp_detalle_orden',1),(27,'2019_08_06_142254_add_soft_deletes_to_productos_table',1),(28,'2019_08_24_114317_add_tracking_to_lista_regalo',1),(29,'2019_09_11_165350_add_tracking_and_delivery_at_to_ordenes',1),(30,'2019_09_11_165719_add_delivery_at_to_lista_regalo',1),(31,'2019_09_12_122425_create_departamentos_table',1),(32,'2019_09_12_122519_create_distritos_table',1),(33,'2020_05_07_084923_add_dni_users',2),(34,'2020_05_09_010405_add_card_to_ordenes',2),(35,'2020_05_13_191400_create_descuentos_table',2),(36,'2020_05_13_195106_add_descuento_to_productos',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter`
--

LOCK TABLES `newsletter` WRITE;
/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
INSERT INTO `newsletter` VALUES (1,'soporte@ilustraconsultores.com',1,'Soporte Ilustra'),(2,'emanuel@ilustraconsultores.com',1,'Emanuel Lopez'),(3,'emanuel2@ilustraconsultores.com',1,'Emanuel Lopez'),(4,'pablo@ilustraconsultores.com',1,'Pablo'),(5,'soporte24@ilustraconsultores.com',1,'Soporte Ilustra'),(6,'giorgio@ilustraconsultores.com',1,'Giorgio Pinasco'),(7,'eltioema@gmail.com',1,'Emanuel López');
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obra_material`
--

DROP TABLE IF EXISTS `obra_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obra_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `obra_id` int(10) unsigned NOT NULL,
  `material_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `obra_material_obra_id_foreign` (`obra_id`),
  KEY `obra_material_material_id_foreign` (`material_id`),
  CONSTRAINT `obra_material_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `obra_material_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obra_material`
--

LOCK TABLES `obra_material` WRITE;
/*!40000 ALTER TABLE `obra_material` DISABLE KEYS */;
INSERT INTO `obra_material` VALUES (3,2,1);
/*!40000 ALTER TABLE `obra_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obras`
--

DROP TABLE IF EXISTS `obras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado` tinyint(1) NOT NULL,
  `categoria_id` int(10) unsigned DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_corta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `galeria_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artista_id` int(10) unsigned DEFAULT NULL,
  `tamano` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `disponible_tienda` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `obras_slug_unique` (`slug`),
  KEY `obras_categoria_id_index` (`categoria_id`),
  KEY `obras_artista_id_index` (`artista_id`),
  CONSTRAINT `obras_artista_id_foreign` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`id`),
  CONSTRAINT `obras_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obras`
--

LOCK TABLES `obras` WRITE;
/*!40000 ALTER TABLE `obras` DISABLE KEYS */;
INSERT INTO `obras` VALUES (1,'Nueva Obra',1,1,NULL,'Test','nueva-obra','acd5871f627a78e58086e47fde423ae0.jpg',NULL,1,NULL,NULL,NULL,'','2019-11-11 21:48:40','2019-11-11 21:49:29'),(2,'TEST',1,1,'ergdtb','hola 15-01-2020','test','098f6bcd4621d373cade4e832627b4f6.jpg',NULL,1,'1',12.00,2019,'3','2020-01-15 17:24:43','2020-01-15 17:43:36'),(3,'Prueba obra FR1',1,3,'En metal','Obra prueba','prueba-obra-fr1',NULL,NULL,NULL,NULL,NULL,NULL,'5','2020-03-05 17:37:33','2020-03-05 17:37:52');
/*!40000 ALTER TABLE `obras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_producto`
--

DROP TABLE IF EXISTS `orden_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orden_producto` (
  `orden_producto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orden_id` int(10) unsigned NOT NULL,
  `producto_id` int(10) unsigned NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lista_regalo_id` int(11) DEFAULT NULL,
  `producto_precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `producto_dsct` decimal(10,2) NOT NULL,
  `recargo` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orden_producto_id`),
  KEY `orden_producto_orden_id_foreign` (`orden_id`),
  KEY `orden_producto_producto_id_foreign` (`producto_id`),
  CONSTRAINT `orden_producto_orden_id_foreign` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orden_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_producto`
--

LOCK TABLES `orden_producto` WRITE;
/*!40000 ALTER TABLE `orden_producto` DISABLE KEYS */;
INSERT INTO `orden_producto` VALUES (1,1,2,'verde',NULL,120.00,2,0.00,0.00,240.00,NULL),(2,2,4,NULL,NULL,12.00,2,0.00,0.00,24.00,NULL),(3,3,1,NULL,NULL,99.00,1,0.00,0.00,99.00,NULL),(4,4,1,NULL,NULL,86.00,1,0.00,0.00,86.00,NULL),(5,5,1,NULL,NULL,86.00,1,0.00,0.00,86.00,NULL),(6,6,5,'azul',NULL,50.00,1,0.00,0.00,50.00,NULL),(7,7,1,NULL,NULL,89.00,1,0.00,0.00,89.00,NULL),(8,7,2,'blanco',NULL,120.00,1,0.00,0.00,120.00,NULL),(9,8,1,'rojo',NULL,89.00,1,0.00,0.00,89.00,NULL),(10,8,1,'verde',NULL,89.00,1,0.00,0.00,89.00,NULL),(11,9,5,'azul',NULL,50.00,1,0.00,0.00,50.00,NULL),(12,10,5,'azul',NULL,50.00,1,0.00,0.00,50.00,NULL),(13,11,2,'verde',NULL,120.00,1,0.00,0.00,120.00,NULL),(14,12,2,'blanco',NULL,120.00,1,0.00,0.00,120.00,NULL),(15,13,5,'azul',NULL,30.00,1,0.00,0.00,30.00,NULL),(16,14,5,'verde',NULL,30.00,3,0.00,0.00,90.00,NULL),(17,15,5,'azul',NULL,30.00,5,0.00,0.00,150.00,NULL),(18,16,2,'verde',NULL,120.00,1,0.00,0.00,120.00,NULL),(19,17,2,'blanco',NULL,119.00,1,0.00,0.00,119.00,NULL),(20,17,2,'verde',NULL,119.00,2,0.00,0.00,238.00,NULL),(21,18,2,'blanco',NULL,119.00,1,0.00,0.00,119.00,NULL),(22,19,2,'blanco',NULL,119.00,1,0.00,0.00,119.00,NULL),(23,20,2,'blanco',NULL,119.00,1,0.00,0.00,119.00,NULL),(24,21,1,'rojo',NULL,99.00,1,0.00,0.00,99.00,NULL),(25,22,1,'rojo',NULL,99.00,1,0.00,0.00,99.00,NULL),(26,23,2,'blanco',NULL,119.00,1,17.85,0.00,101.15,NULL),(28,25,4,'dorado',NULL,12.00,1,0.00,0.00,12.00,NULL),(29,26,2,'blanco',NULL,119.00,1,17.85,0.00,101.15,NULL),(30,27,1,'rojo',NULL,99.00,1,0.00,0.00,99.00,NULL),(31,28,1,'rojo',NULL,99.00,1,0.00,0.00,99.00,NULL);
/*!40000 ALTER TABLE `orden_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `estado` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrega` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais_id` int(10) unsigned DEFAULT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distrito` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_envio` decimal(10,2) DEFAULT NULL,
  `monto_devolucion` decimal(10,2) DEFAULT NULL,
  `id_orden_culqi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factura` tinyint(1) DEFAULT NULL,
  `ruc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `payed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tracking` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_at` timestamp NULL DEFAULT NULL,
  `card` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ordenes_pais_id_foreign` (`pais_id`),
  KEY `ordenes_user_id_index` (`user_id`),
  CONSTRAINT `ordenes_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  CONSTRAINT `ordenes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES (1,4,'Pendiente','delivery',1,'Lima',NULL,'Av El Bosque 260 San Isidro',30.00,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-01-15 17:57:46','2020-01-15 18:06:00',NULL,NULL,''),(2,5,'Entregado','delivery',1,'Apurimac',NULL,'Av. La Mar 832 - Miraflores',40.00,NULL,'chr_test_Mojhrs0fixHr6laF',0,NULL,NULL,NULL,NULL,'2020-01-15 18:13:24',NULL,NULL,'2020-01-15 18:03:47','2020-05-25 22:24:22','DHL 1','2020-05-25 22:24:22',''),(3,5,'Entregado','recojo_tienda',NULL,'',NULL,'',NULL,NULL,'chr_test_Bqsh5T4ff2qyxnQP',0,NULL,NULL,NULL,NULL,'2020-01-15 18:24:35',NULL,NULL,'2020-01-15 18:24:32','2020-05-16 03:17:26',NULL,'2020-05-16 03:17:26',''),(4,10,'Entregado','delivery',NULL,'1','san luis','Rosa Toro',NULL,NULL,'chr_test_qRS0PuwunGEqaNyc',0,NULL,NULL,NULL,NULL,'2020-05-16 03:43:29',NULL,NULL,'2020-05-16 03:43:26','2020-05-25 22:24:32',NULL,'2020-05-25 22:24:32','1111'),(5,10,'Entregado','recojo_tienda',NULL,'',NULL,'',NULL,NULL,'chr_test_bZXtsszyun6Pw2gz',0,NULL,NULL,NULL,NULL,'2020-05-19 01:56:45',NULL,NULL,'2020-05-19 01:56:42','2020-05-25 22:24:40',NULL,'2020-05-25 22:24:40','1111'),(6,10,'Entregado','delivery',NULL,'1','san borja','Rosa Toro',NULL,NULL,'chr_test_ILzdInKQx6NVOV66',0,NULL,NULL,NULL,NULL,'2020-05-19 02:07:11',NULL,NULL,'2020-05-19 02:07:09','2020-05-25 22:24:48',NULL,'2020-05-25 22:24:48','1111'),(7,4,'Entregado','recojo_tienda',NULL,'',NULL,'',NULL,NULL,'chr_test_9t06igLvbPNBybno',0,NULL,NULL,NULL,NULL,'2020-05-24 03:23:26',NULL,NULL,'2020-05-24 03:23:23','2020-05-26 00:56:35',NULL,'2020-05-26 00:56:35','1111'),(8,4,'Pagado','delivery',NULL,'1','chorrillos','tu eres t 123',NULL,NULL,'chr_test_3gHnWA9YWiuOAfNr',1,'20345678','tgf',NULL,NULL,'2020-05-24 04:07:57',NULL,NULL,'2020-05-24 04:07:54','2020-05-24 04:07:57',NULL,NULL,'1111'),(9,4,'Pendiente','delivery',1,'1','ate','nhtdc 567',10.00,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-24 04:24:59','2020-05-25 22:03:57',NULL,NULL,''),(10,4,'Cancelado','delivery',1,'1','comas','2da prueba recargo deliv',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'2020-05-25 23:14:35',NULL,'2020-05-24 04:26:24','2020-05-25 23:14:35',NULL,NULL,''),(11,3,'Entregado','delivery',NULL,'1','san isidro','bosque',NULL,NULL,'chr_test_pARkAzmdciLtNvCE',1,'502412','The gift',NULL,NULL,'2020-05-25 22:09:55',NULL,NULL,'2020-05-25 22:09:52','2020-05-25 23:03:30','gap.com','2020-05-25 22:32:23','1111'),(12,3,'Pendiente','delivery',1,'1','chaclacayo','Av La Perla 567',25.00,NULL,NULL,1,'2054','The Gift now',NULL,NULL,NULL,NULL,NULL,'2020-05-25 23:09:02','2020-05-25 23:14:16',NULL,NULL,''),(13,4,'Pagado','delivery',NULL,'1','la victoria','Coro fijo 456',NULL,NULL,'chr_test_BcndXBmKYg6LsIKK',1,'12345','a ver si funca',NULL,NULL,'2020-05-26 01:16:44',NULL,NULL,'2020-05-26 01:16:41','2020-05-26 01:16:44',NULL,NULL,'1111'),(14,4,'Pagado','delivery',NULL,'1','la victoria','pruebisima 123',NULL,NULL,'chr_test_kMkLfBxnShUhwGmM',0,NULL,NULL,NULL,NULL,'2020-05-26 01:56:52',NULL,NULL,'2020-05-26 01:56:49','2020-05-26 01:56:52',NULL,NULL,'1111'),(15,3,'Pagado','recojo_tienda',NULL,'',NULL,'',NULL,NULL,'chr_test_sF5FJjLxvA172Cwd',1,'456245554','A ver',NULL,NULL,'2020-05-26 02:00:28',NULL,NULL,'2020-05-26 02:00:25','2020-05-26 02:00:28',NULL,NULL,'1111'),(16,3,'Calculando','delivery',2,'13','ojala','Sin distrito exterior 123',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-26 02:45:24','2020-05-26 02:45:24',NULL,NULL,''),(17,4,'Pagado','delivery',NULL,'1','surco','av g',NULL,NULL,'chr_test_CWlWS8ZZXrfuTJCO',0,NULL,NULL,NULL,NULL,'2020-05-26 03:18:36',NULL,NULL,'2020-05-26 03:18:34','2020-05-26 03:18:36',NULL,NULL,'1111'),(18,3,'Calculando','delivery',1,'1','carabayllo','NOSE 124',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-28 23:40:44','2020-05-28 23:40:44',NULL,NULL,''),(19,3,'Pagado','delivery',NULL,'1','miraflores','Quiero revisar el mail que llega con delivery gratis 123',NULL,NULL,'chr_test_KDGOEiEPzZFRthT7',0,NULL,NULL,NULL,NULL,'2020-05-28 23:48:54',NULL,NULL,'2020-05-28 23:48:51','2020-05-28 23:48:54',NULL,NULL,'1111'),(20,10,'Pagado','delivery',NULL,'Lima','barranco','pruebas...',NULL,NULL,'chr_test_8anKkGBtM9kBz4zC',0,NULL,NULL,NULL,NULL,'2020-06-16 20:16:38',NULL,NULL,'2020-06-16 20:16:35','2020-06-16 20:36:18','1',NULL,'1111'),(21,10,'Pendiente','delivery',1,'Ancash','Ancash...','Prueba Ancash',55.00,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-16 20:47:38','2020-06-16 20:48:31',NULL,NULL,''),(22,9,'Pendiente','delivery',1,'Lima','ate','conocido',150.00,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-16 20:57:28','2020-06-16 20:57:52',NULL,NULL,''),(23,9,'Calculando','delivery',1,'Ancash','aNCASH','En Ancash',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-19 23:10:42','2020-06-19 23:10:42',NULL,NULL,''),(25,10,'Pagado','recojo_tienda',NULL,'',NULL,'',NULL,NULL,'chr_test_734uRLJkDudZPIf9',1,NULL,'Testing',NULL,NULL,'2020-06-30 23:22:05',NULL,NULL,'2020-06-30 23:22:02','2020-06-30 23:22:05',NULL,NULL,'1111'),(26,10,'Enviado','delivery',NULL,'Lima','miraflores','La mar',NULL,NULL,'chr_test_pvD1SYINvIZ2zNF2',1,NULL,'Un Testing',NULL,NULL,'2020-06-30 23:33:12',NULL,NULL,'2020-06-30 23:33:09','2020-06-30 23:54:16',NULL,'2020-06-30 23:54:16','1111'),(27,10,'Pagado','delivery',1,'Ancash','Ancash','Para Ancash',250.00,NULL,'chr_test_tGCPJYPokptKQ0Nv',0,'1118887745','Un Testing',NULL,NULL,'2020-06-30 23:48:35',NULL,NULL,'2020-06-30 23:37:10','2020-06-30 23:53:16','00101010001',NULL,'1111'),(28,10,'Pagado','delivery',NULL,'Lima','san luis','ibuadsibudas',NULL,NULL,'chr_test_aseURzZD5ILf44dI',1,'98778998741','razon social',NULL,NULL,'2020-07-02 22:31:54',NULL,NULL,'2020-07-02 22:31:51','2020-07-02 22:31:54',NULL,NULL,'1111');
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paginas`
--

DROP TABLE IF EXISTS `paginas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paginas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paginas`
--

LOCK TABLES `paginas` WRITE;
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
INSERT INTO `paginas` VALUES (1,'inicio','sla78e8d54b7767d5ebea9467b5c141e141573145937.jpeg',NULL,0,'2019-11-07 16:58:57','2019-11-07 16:58:57'),(2,'inicio','sl28399874d234eae603904f6f89d9c89d1573145962.jpg',NULL,0,'2019-11-07 16:59:22','2019-11-07 16:59:22'),(3,'inicio','sl3a79fc4f162b971b7f66024ee5f176ab1573146006.jpg',NULL,0,'2019-11-07 17:00:06','2019-11-07 17:01:07'),(4,'tienda','tienda.jpg',NULL,0,'2019-11-07 17:03:01','2019-11-07 17:03:01'),(5,'artistas','artistas.jpg',NULL,0,'2019-11-07 17:03:12','2019-11-07 17:03:12'),(6,'nosotros','nosotros.jpg','<h1 style=\"font-family: Raleway, sans-serif; color: #000000;\"><span style=\"font-size: 36px;\"><strong>AMOR POR EL ARTE</strong></span></h1>\r\n<p><strong><em>Arte y artesan&iacute;a de los m&aacute;s prestigiosos artistas y artesanos peruanos.&nbsp;</em></strong></p>\r\n<p style=\"text-align: justify;\">Hoy en d&iacute;a GALER&Iacute;A INDIGO es considerado el lugar ideal para el deleite de todo aquel en busca de arte, dise&ntilde;o y creatividad peruana, ya que alberga entre sus espacios el trabajo de cientos de prestigiosos artistas reunidos en un solo lugar.</p>\r\n<p style=\"text-align: justify;\">Desde una visi&oacute;n siempre ecl&eacute;ctica y democr&aacute;tica, amplia e integradora, GALER&iacute;A INDIGO ha logrado abrir nuevos horizontes en la experiencia del arte en Lima, ofreciendo todo tipo de formas de arte desde piezas utilitarias hasta magn&iacute;&shy;ficas esculturas, desde fabulosos grabados hasta fascinantes &oacute;leos de gran formato, desde piezas de j&oacute;venes talentos hasta obras de maestros con gran trayectoria y reconocimiento.</p>\r\n<h2><span style=\"font-weight: bolder;\"><span style=\"font-size: 24px;\">MOVIDA CULTURAL</span></span></h2>\r\n<p style=\"text-align: justify;\">Ubicada en una apacible zona de lujo en San Isidro, sus dos emblem&aacute;ticas y tradicionales casonas, cuentan con m&aacute;s de 30 salones de exhibiciones permanentes. Adem&aacute;s, GALERIA INDIGO se convierte todos los meses en el lugar preciso para las m&aacute;s destacadas inauguraciones de arte en la ciudad, complaciendo a su m&aacute;s distinguida clientela, ya sea en su primera sala de exposici&oacute;n conocida como \"La Rotonda\", o en \"Ati&shy;pico\", una amplia y moderna sala. No importa el momento del a&ntilde;o que visites GALER&iacute;A INDIGO, siempre podr&aacute;s apreciar magn&iacute;ficas exposiciones y exhibiciones de talentosos artistas peruanos.</p>\r\n<p style=\"text-align: justify;\"><img class=\"note-float-right\" style=\"width: 353.156px; float: right;\" src=\"../uploads/exhibitions/events/479842165_Movida 2.jpg\" data-filename=\"Movida 2.jpg\" /></p>\r\n<h2><span style=\"font-size: 24px; text-align: left;\"><strong>EN INDIGO ENCONTRAR&Aacute;S:</strong></span></h2>\r\n<ul>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Arte de alta calidad.</span></li>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Atenci&oacute;n personalizada y asesoramiento para tu recorrido y compras.</span></li>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Una amplia variedad de opciones de regalos o piezas de decoraci&oacute;n.</span></li>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Una exposici&oacute;n diferente y de alto nivel al mes, as&iacute; como espacios llenos de arte, finamente decorados.</span></li>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Gran comodidad para comprar con estacionamiento puerta a calle.</span></li>\r\n<li style=\"text-align: left;\"><span style=\"font-size: 14px;\">Programa de beneficios exclusivos para novios.</span></li>\r\n</ul>\r\n<h2 style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-size: 24px;\"><span style=\"font-weight: bolder;\">NUESTRAS L&Iacute;NEAS:</span></span></h2>\r\n<p style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-size: 14px;\"><span style=\"font-family: Arial; font-size: 14px;\">GALER&Iacute;A INDIGO destaca por ser una galer&iacute;a completa y vers&aacute;til. Las l&iacute;neas de arte con las que trabajamos son:</span></span></p>\r\n<ul>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-size: 14px; font-family: Arial;\">Esculturas</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Pinturas&nbsp;</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Grabados</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Piezas utilitarias</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Fotograf&iacute;as</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Accesorios de moda&nbsp;</span></li>\r\n<li style=\"font-family: Roboto, sans-serif; color: #000000;\"><span style=\"font-family: Arial; font-size: 14px;\">Joyas</span></li>\r\n</ul>\r\n<h2 style=\"font-family: Roboto, sans-serif; color: #000000;\"><img src=\"../uploads/exhibitions/events/52276350_slfe82fefb4cb67db061b027a9bb4ad7941531867668.jpg\" alt=\"Variedad de productos\" width=\"597\" height=\"315\" /></h2>\r\n<h2 style=\"font-family: Roboto, sans-serif; color: #000000;\"><!--EndFragment--></h2>',0,'2019-11-07 17:05:09','2019-11-07 17:15:30');
/*!40000 ALTER TABLE `paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orden_id` int(10) unsigned NOT NULL,
  `metodo_pago_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagos_orden_id_foreign` (`orden_id`),
  KEY `pagos_metodo_pago_id_foreign` (`metodo_pago_id`),
  CONSTRAINT `pagos_metodo_pago_id_foreign` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodo_pagos` (`id`),
  CONSTRAINT `pagos_orden_id_foreign` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,2,1,'2020-01-15 18:13:24','2020-01-15 18:13:24'),(2,3,1,'2020-01-15 18:24:35','2020-01-15 18:24:35'),(3,4,1,'2020-05-16 03:43:29','2020-05-16 03:43:29'),(4,5,1,'2020-05-19 01:56:45','2020-05-19 01:56:45'),(5,6,1,'2020-05-19 02:07:11','2020-05-19 02:07:11'),(6,7,1,'2020-05-24 03:23:26','2020-05-24 03:23:26'),(7,8,1,'2020-05-24 04:07:57','2020-05-24 04:07:57'),(8,11,1,'2020-05-25 22:09:55','2020-05-25 22:09:55'),(9,13,1,'2020-05-26 01:16:44','2020-05-26 01:16:44'),(10,14,1,'2020-05-26 01:56:52','2020-05-26 01:56:52'),(11,15,1,'2020-05-26 02:00:28','2020-05-26 02:00:28'),(12,17,1,'2020-05-26 03:18:36','2020-05-26 03:18:36'),(13,19,1,'2020-05-28 23:48:54','2020-05-28 23:48:54'),(14,20,1,'2020-06-16 20:16:38','2020-06-16 20:16:38'),(15,25,1,'2020-06-30 23:22:05','2020-06-30 23:22:05'),(16,26,1,'2020-06-30 23:33:12','2020-06-30 23:33:12'),(17,27,1,'2020-06-30 23:48:35','2020-06-30 23:48:35'),(18,28,1,'2020-07-02 22:31:54','2020-07-02 22:31:54');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `paises_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'Perú',NULL,NULL,NULL),(2,'Brasil',NULL,NULL,NULL),(3,'Test','PRUEBA','2019-11-07 17:48:03','2019-11-07 17:48:03'),(4,'Mexico','Lindo y querido','2020-05-25 21:41:41','2020-05-25 21:41:41');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('soporte2@ilustraconsultores.com','$2y$10$TIWaST.DPL/All2sDwyRl.M4d9rwhdorSD8zdt/XBQJcBIcMDHsqq','2019-11-12 00:08:19'),('ricardo@ilustraconsultores.com','$2y$10$VT7zZbuTgxwxcO7q/MMlmO054ltoUiNLJa5OQQJ2BvoPTQT9yLd1.','2019-12-03 20:13:24'),('soporte@ilustraconsultores.com','$2y$10$gWP0oBzyjui15KMyE3jlQOm0HTyEuQhMD5Qvp9WoI//s.rm8R0Uz2','2021-01-06 22:24:50');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_material`
--

DROP TABLE IF EXISTS `producto_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `producto_id` int(10) unsigned NOT NULL,
  `material_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_material_producto_id_foreign` (`producto_id`),
  KEY `producto_material_material_id_foreign` (`material_id`),
  CONSTRAINT `producto_material_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `producto_material_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_material`
--

LOCK TABLES `producto_material` WRITE;
/*!40000 ALTER TABLE `producto_material` DISABLE KEYS */;
INSERT INTO `producto_material` VALUES (18,5,2),(21,1,2),(24,4,1),(25,2,1);
/*!40000 ALTER TABLE `producto_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado` tinyint(1) NOT NULL,
  `categoria_id` int(10) unsigned DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_corta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `galeria_img` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tamano` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `color` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `otros_detalles` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dsct_lista_regalo` decimal(10,2) NOT NULL,
  `artista_id` int(10) unsigned DEFAULT NULL,
  `tipo_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `descuento_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productos_slug_unique` (`slug`),
  KEY `productos_categoria_id_index` (`categoria_id`),
  KEY `productos_artista_id_index` (`artista_id`),
  KEY `productos_tipo_id_index` (`tipo_id`),
  KEY `productos_descuento_id_foreign` (`descuento_id`),
  CONSTRAINT `productos_artista_id_foreign` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`id`),
  CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `productos_descuento_id_foreign` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`),
  CONSTRAINT `productos_tipo_id_foreign` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Piedra Nueva',1,6,8,'PT0004','Bronce a la cera perdida TEST descripcion larga.','Bronce a la cera perdida TEST descripcion corta. 1 , probando','piedra-nueva','3c2690ceeed5057d9b845f79151f7412.jpg','[\"1_20623130645d267aa931167c17f0e43714093ea2.jpg\",\"1_164315a.jpg\",\"1_164315b.jpg\",\"1_164315c.jpg\"]','17x5x7',1.50,99.00,'[{\"color\":\"rojo\",\"stock\":0},{\"color\":\"verde\",\"stock\":4},{\"color\":\"azul\",\"stock\":4}]','Pieza unica.',0.00,1,5,'2019-11-07 17:35:55','2020-07-02 22:31:51',NULL,NULL),(2,'Gorditos',1,1,124,'PT0009','Raphael Wong',NULL,'gorditos','b8be117eb75e1c2ffeab3d8973c52bd3.jpg','[\"2_2135335b8be117eb75e1c2ffeab3d8973c52bd3.jpg\",\"2_20623130645d267aa931167c17f0e43714093ea2.jpg\"]',NULL,NULL,119.00,'[{\"color\":\"blanco\",\"stock\":12},{\"color\":\"dorado\",\"stock\":112}]',NULL,13.09,1,1,'2019-11-07 20:32:34','2020-08-12 17:34:13',NULL,14),(3,'TEST',1,1,0,NULL,'ergdtb','hola 15-01-2020','test','3098f6bcd4621d373cade4e832627b4f6.jpg',NULL,NULL,NULL,0.00,'[]',NULL,0.00,1,1,'2020-01-15 17:24:55','2020-01-15 17:43:36',NULL,NULL),(4,'erfv',1,1,0,NULL,'prueba 01','adfvae','erfv','513d6cc840b26b9c6767b7b43698cd83.png','[\"4_01.png\"]',NULL,NULL,12.00,'[{\"color\":\"dorado\",\"stock\":0}]',NULL,0.00,1,4,'2020-01-15 17:40:23','2020-06-30 23:22:02',NULL,NULL),(5,'Prueba obra FR1',1,5,0,'ADE54','En metal descripcion larga','Obra prueba desc corta','prueba-obra-fr1',NULL,'[\"5_200626c.jpg\",\"5_200626d.jpg\"]','3x4x5',1.20,30.00,'[{\"color\":\"azul\",\"stock\":0},{\"color\":\"verde\",\"stock\":0}]','Una prueba de detalles. Pieza exclusiva.',0.00,1,5,'2020-03-05 17:37:52','2020-05-26 02:00:25',NULL,8),(6,'Test',1,1,125,NULL,'Testing','Para test','test-1','70a37754eb5a2e7db8cd887aaf11cda7.jpg','[\"6_Mascarillas3M-6200.jpg\"]',NULL,NULL,400.00,'[{\"color\":\"negro\",\"stock\":100},{\"color\":\"gris\",\"stock\":25}]',NULL,52.00,1,1,'2020-06-30 23:42:27','2020-08-12 17:31:09',NULL,13);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin',NULL),(2,'Cliente',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos`
--

DROP TABLE IF EXISTS `tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

LOCK TABLES `tipos` WRITE;
/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` VALUES (1,'Canvas',NULL),(2,'Collage',NULL),(4,'Poster',NULL),(5,'Escultura','Obras destinadas principalmente a apoyarse sobre una base.');
/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `apellidos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dni` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_token_unique` (`token`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Soporte','soporte@ilustraconsultores.com','$2y$10$ew5eqHH7FrzNdKLkTI/5G.LK8z1iuJR0tRbzHoY4Jb8UOqCWLuVMW',1,'Ilustra','','','',NULL,NULL,'5nZwC95yY49vo4wx7GlUDNyPZenz6kNiA1as8mRJo1JPdfR4TXWJ3I5w45Wr','4wK20QHxjzPhwx6WBIZbpLQ2hOrTKQTeifcggCHKHurt1rhj3PF4HbSVpyjp','2018-09-28 01:00:42','2021-01-14 21:59:02',''),(2,'Soporte','ricardo@ilustraconsultores.com','$2y$10$1ccmf1D1jmhM9psFvEZcme4U5laWkDx/hg0/cwmEofOy4i950B8PW',2,'Ilustra','55555',NULL,'Av La mar 832','LIMA','PE',NULL,'VtjGj2HxfafMUIEGNgwodyfgTc0BvkTisamJplDeGicmdDYhAl1q5GPWLAjU','2019-12-26 18:06:44','2019-12-26 18:15:36',''),(3,'Fabiola','fabiola.roque@gmail.com','$2y$10$7Pl4TQm5RaT2GhhD4mEzYeyBT65Uh0tbtbexzcoKDMSRQ/fsolXC2',2,'Briceno','014401849',NULL,'Av El Bosque 260 San Isidro','LIMA','PE','clRhPm5lQJqrgHpjsdftL4z1MFog79M8mvATRWT0BX4lYWRViUO7roqeKnEw','8JdepE1odZOcUHxsynGa3Fsd9PNhGF6Yi5kmsDP4kdjnWesNyQnDwojFfPDb','2020-01-15 17:14:09','2020-05-28 23:38:50','10559936'),(4,'Soporte','soporte2@ilustraconsultores.com','$2y$10$OSZQE9n2u7hDjyJj0T/.hOmwYjvXKAicC0NtpiEMpmb/2f/bZQlSG',1,NULL,NULL,NULL,NULL,NULL,NULL,'DZLvBI1WE7L9cGXKtY7gqGfzbKGV3KIbFvQYLIoVlscPdi0zrC4uWG2OnKcE','TIs9ARy6Ho4IfUbrAuJphd4poNt8z2D7Rq2IIZ13Vz3iJByZN4qLeqmGS22T','2020-01-15 17:14:27','2020-05-26 03:06:09',''),(5,'Emanuel','emanuel@ilustraconsultores.com','$2y$10$MabjGMhDtXrCj3YVDzcXI.4QtM8.BUVsFzQ0H1T5.d3o/XAEVcLci',2,'López Muñoz','998282668','4227400','Av. La Mar 832 - Miraflores','LIMA','PE',NULL,'je6kM6TnEo8ZRv1wmOl5o9KlqFOXyj20pf33utP9X6dyLaICsTWIwNq4roDJ','2020-01-15 18:03:03','2020-03-27 21:38:21',''),(6,'Soporte','joze1402@gmail.com','$2y$10$gRC8zrUY/ahNq3z5s9kgLuvLsXoUAjUiBF7LkXTtlp3mXJqOg1.5q',1,'Ilustra','','','',NULL,NULL,'nCvZpVkOnJafBKQqApVqpTP8a1XzMVUWgY9bbCrD7At09uUlyF2mJPXkbo1G','sdnNWyR6misvHctkn6aOcojR37nGB4SL1gueE9LsEONWISqRiLScmdRijOay','2018-09-28 06:00:42','2020-06-20 21:45:04',''),(7,'Jose','joseph_1402@gmail.com','$2y$10$PIB57G.HbAjhBAM7v8AXk.F.yzbt97UYXgOfQt6.1g1Jso8L1YS4C',2,'test test','123123213213',NULL,'conocido','LIMA','PE',NULL,'v7CJ3Ko67zEdxx0a4vsG0VWkj9TSdJMSRQV5VkIWBlIM4uEgsGigTzfhVcb3','2020-05-15 22:19:21','2020-05-18 16:02:48','123DSE'),(9,'demo test','joseph_1402@hotmail.com','$2y$10$Cm87oRZl1NXcXsZQeQMquuWljhLoFwtQ50nHESSKdU9BCEWSnhoLG',2,'tes test','123321123',NULL,'conocido','AMAZONAS','PE','LAgsmL9dJ92AhuI7gtjLtWUCkrzqbEYDBlNfUNThdtOlpbREFYmHHxhRbLxG','klg6gvYpOe26y3USvdZMaT91GexyLqZNU3rlrLRWRT7yV5pn4dp2yGmAMxp4','2020-05-15 23:02:16','2020-06-19 22:08:58','dnidemo123'),(10,'Jjjjj','jfuentes@ilustraconsultores.com','$2y$10$di623cPx/biHfYQOzgRdSO/MaRe8LSb0IJcMTbTHZH3N7I4qDt3Vu',2,'Kkkkk','999999999',NULL,'Rosa Toro','LIMA','PE','LQVYLjbYrmkwx7I8fZB6LylexyWxbz4oc13gPYoYjNuf6RlASoICJA8tc6g4','5qAPhxdogtpPIMRcCoaTANs55QoaGXXhHO24lD9CltZpMn2g0LgsycFHRBEP','2020-05-16 03:41:18','2020-07-02 22:27:10','11111111111');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'indigo_one'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-14 17:18:58

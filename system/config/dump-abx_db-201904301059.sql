-- MySQL dump 10.16  Distrib 10.3.9-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: abx_db
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `affiliate`
--

DROP TABLE IF EXISTS `affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `approved` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliate`
--

LOCK TABLES `affiliate` WRITE;
/*!40000 ALTER TABLE `affiliate` DISABLE KEYS */;
INSERT INTO `affiliate` VALUES (1,13,1,'Yes'),(2,14,1,'Yes'),(3,15,1,'Yes'),(4,17,1,'Yes'),(5,18,1,'Yes'),(6,19,1,'Yes'),(8,13,2,'Yes'),(9,NULL,NULL,'Yes'),(12,19,2,NULL),(13,13,3,'Yes'),(16,14,2,'Yes'),(17,18,2,'Yes'),(20,17,2,'Yes'),(21,17,3,'Yes'),(23,14,3,'Yes'),(24,18,3,'Yes'),(26,20,1,'Yes'),(32,20,3,'Yes'),(33,19,4,'Yes'),(34,19,3,'Yes'),(35,21,1,'Yes'),(36,21,5,'Yes'),(37,22,1,'Yes');
/*!40000 ALTER TABLE `affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_user_role`
--

DROP TABLE IF EXISTS `group_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_user_role`
--

LOCK TABLES `group_user_role` WRITE;
/*!40000 ALTER TABLE `group_user_role` DISABLE KEYS */;
INSERT INTO `group_user_role` VALUES (1,13,1,1),(2,19,1,1),(3,20,1,1),(4,13,3,5),(9,17,1,1),(10,17,3,3),(13,18,2,1),(14,18,3,3),(15,15,2,1),(21,20,3,5),(22,19,4,3),(23,19,3,3),(24,NULL,1,1),(25,21,1,1),(26,21,5,3),(27,NULL,1,1),(28,NULL,1,1),(29,NULL,1,1),(30,NULL,1,1),(31,NULL,1,1),(32,NULL,1,1),(33,NULL,1,1),(34,NULL,1,1),(35,22,1,3),(36,24,1,1);
/*!40000 ALTER TABLE `group_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `group_photo` varchar(256) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='Table for group''s information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (13,NULL,NULL,'Prueba 1','Prueba 1','1552967118_(iori03_)12345729_862092230578521_320436592_n.jpg',NULL),(14,NULL,13,'Grupo 2','Grupo 2','1553045469_(claudiaalende)12327939_1523138514680505_341742002_n.jpg',NULL),(15,NULL,NULL,'Grupo 3','Grupo 3','1553056938_(silla_e_mimbre)12224228_1654611478130905_689608145_n.jpg',2),(16,NULL,NULL,'Grupo 4','Grupo 4','1553310933_(claudiaalende)12327939_1523138514680505_341742002_n.jpg',NULL),(17,NULL,NULL,'Grupo 5','Descripcion de Grupo, un poco mas larga probando que se vea bien el modal de informacion de grupo','1553054128_(lexypanterra)12362050_1096808836998015_2103085051_n.jpg',NULL),(18,NULL,NULL,'Grupo 6','Grupo 6','1554833587_IMG-20190306-WA0005.jpg',2),(19,NULL,NULL,'Grupo 24','Grupo 4d','1553487426_(iori03_)12345729_862092230578521_320436592_n.jpg',NULL),(20,NULL,14,'New group','New group','1553712932_IMG-20190306-WA0024.jpg',1),(21,NULL,13,'Grupo de Prueba JM','Grupo de Prueba JM',NULL,1),(22,NULL,NULL,'Grupo Exposed','S',NULL,1),(24,NULL,NULL,'Test Group','Si',NULL,1);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `menu_id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `icon` varchar(256) DEFAULT NULL,
  `menu_order` int(5) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `parent_menu_id` int(5) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (7,'Sources','Soruces','empty',0,'source/index',11),(9,'Role','Role','empty',NULL,'role/index',11),(11,'Mantenimiento','Mantenimiento','fab fa-algolia',1,'#',0),(12,'Affiliate','Affiliate','fab fa-500px',3,'affiliate',11),(13,'Group','Group','empty',4,'groups',11),(14,'Note','Note','fas fa-address-book',4,'note',11),(15,'Note Type','Type','fab fa-accessible-icon',5,'note_type',11),(16,'Test','Prueba','fab fa-accessible-icon',5,'#',0),(17,'Note Approver','Note Approver','fas fa-address-book',6,'note_approver',11),(18,'Affiliate To Group','Affiliate To Group','empty',1,'affiliate/items',16),(19,'Note Status','Note Status','fab fa-accessible-icon',2,'status',11),(20,'Create Assignment','Create Assignment','empty',2,'note/create_assignment',21),(21,'Notas','Notas','far fa-address-book',3,NULL,0),(22,'Create Suggested Point','Create Suggested Point','empty',2,'note/create_suggested_point',21),(23,'Create commitment','Create commitment','empty',3,'note/create_commitment',21),(24,'Create agenda point','Create agenda point','empty',4,'note/create_agenda_point',21),(25,'Role group',NULL,'fab fa-adn',23,'group_user_role',11),(26,'Afiliacion a Grupos','Afiliacion a Grupos','empty',2,'affiliate/items',11),(27,'Comentarios','Comentarios','fab fa-accusoft',4,'note_comment',11);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_to` int(11) DEFAULT NULL,
  `user_from` int(11) DEFAULT NULL,
  `controller_to` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `entity_id` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `message_type` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `shipping_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(140) DEFAULT NULL,
  `note_type_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `summary` varchar(256) DEFAULT NULL,
  `init_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `date_approved` date DEFAULT NULL,
  `performer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES (1,1,'Group',1,2,13,'Prueba de Sumario','2019-03-14','2019-03-05',1,NULL,NULL),(2,2,'Crud Test',1,1,NULL,'A','2019-03-22','2019-03-29',1,'2019-03-14',NULL),(3,1,'Comentario de Prueba',3,1,18,'Esto es una prueba de guardado de un comentario',NULL,NULL,1,NULL,NULL),(4,1,'Note test',2,2,13,'Nota de Prueba para usuario Josue Martinez',NULL,NULL,1,'2019-04-01',2),(5,2,'Otra Prueba',2,2,13,'Esta es otra prueba de Nota','2019-04-01','2019-04-11',1,NULL,1),(6,2,'Prueba 2',2,2,14,'Otra Prueba Vale','2019-04-05','2019-04-30',1,NULL,1),(7,1,'Josue',2,1,13,'Prueba','2019-04-03','2019-04-18',1,NULL,1),(8,1,'Highcharts Demo',2,2,19,'Otra prueba','2019-04-08','2019-04-17',1,NULL,1);
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_approver`
--

DROP TABLE IF EXISTS `note_approver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_approver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `choice` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_approver`
--

LOCK TABLES `note_approver` WRITE;
/*!40000 ALTER TABLE `note_approver` DISABLE KEYS */;
INSERT INTO `note_approver` VALUES (1,1,1,NULL),(3,1,2,NULL),(4,3,2,NULL),(5,3,4,NULL),(6,3,5,NULL),(7,4,1,NULL),(8,5,3,NULL),(9,6,3,NULL),(10,7,4,NULL),(11,8,3,NULL);
/*!40000 ALTER TABLE `note_approver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_comment`
--

DROP TABLE IF EXISTS `note_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date_comment` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `note_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_comment`
--

LOCK TABLES `note_comment` WRITE;
/*!40000 ALTER TABLE `note_comment` DISABLE KEYS */;
INSERT INTO `note_comment` VALUES (1,'Prueba','2019-04-01 04:00:00',2,2),(2,'Prueba de Envio de comentario','2019-04-20 21:23:07',5,1),(3,'Prueba de Envio de comentario','2019-04-20 21:24:06',5,1),(4,'Nueva Prueba de Comentario','2019-04-20 21:28:06',5,1),(5,'Prueba 3 limpia campo','2019-04-20 21:29:43',5,1),(6,'Prueba 4','2019-04-20 21:31:07',7,1),(7,'Nuevo comentario de Prueba','2019-04-26 03:24:04',5,1),(8,'pruaba','2019-04-26 03:24:22',8,1),(9,'pruaba','2019-04-26 03:24:22',8,1),(10,'Prueba 1','2019-04-26 03:31:50',5,1),(11,'Prueba 2','2019-04-26 03:31:57',8,1),(12,'hola','2019-04-26 04:03:56',5,1),(13,'probando cierre de modal','2019-04-26 04:05:58',7,1),(14,'probando cierre de modal','2019-04-26 04:05:58',7,1),(15,'H','2019-04-26 04:06:53',7,1),(16,'H','2019-04-26 04:06:53',7,1),(17,'H','2019-04-26 04:06:53',7,1),(18,'Probando','2019-04-26 04:12:05',5,1),(19,'Probando x2','2019-04-26 04:12:27',7,1),(20,'Probando x3','2019-04-26 04:12:45',8,1),(21,'probando x4','2019-04-26 04:14:12',7,1),(22,'hola otra Prueba mas','2019-04-26 04:15:41',7,1),(23,'Probando','2019-04-26 04:15:55',5,1);
/*!40000 ALTER TABLE `note_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_type`
--

DROP TABLE IF EXISTS `note_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_type`
--

LOCK TABLES `note_type` WRITE;
/*!40000 ALTER TABLE `note_type` DISABLE KEYS */;
INSERT INTO `note_type` VALUES (1,'Punto Sugerido','Punto Sugerido','SP'),(2,'Asignaciones','Asignaciones','AS'),(3,'Compromisos','Compromisos','CO'),(4,'Punto de Agenda','Punto de Agenda','AP');
/*!40000 ALTER TABLE `note_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_to_id` int(11) DEFAULT NULL,
  `controller_to` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `entity_id` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `notification_type` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `shipping_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (2,'test notification 2',1,'affiliate/approve_affiliate','1','affiliate','2019-03-29 13:24:09','Y'),(3,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','9','affiliate','2019-03-29 14:28:05','Y'),(4,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','9','affiliate','2019-03-29 22:16:42','Y'),(5,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','9','affiliate','2019-03-29 22:17:33','Y'),(6,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','9','affiliate','2019-03-29 22:18:40','Y'),(7,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','10','affiliate','2019-03-29 22:22:11','Y'),(8,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','12','affiliate','2019-03-29 22:38:37','Y'),(9,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','13','affiliate','2019-04-04 22:24:16','Y'),(10,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','14','affiliate','2019-04-04 23:18:46','Y'),(11,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','14','affiliate','2019-04-04 23:21:58','Y'),(12,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','17','affiliate','2019-04-04 23:28:47','Y'),(13,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','18','affiliate','2019-04-05 20:53:47','Y'),(14,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','21','affiliate','2019-04-05 21:02:40','Y'),(15,'Solicitud Aprobada',3,'groups/group_information','17','approve_affiliate','2019-04-05 21:10:58','Y'),(16,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','22','affiliate','2019-04-05 22:46:22','Y'),(17,'Solicitud Aprobada',3,'groups/group_information','19','approve_affiliate','2019-04-05 22:46:46','Y'),(18,'Nueva Solicitud de Afilicacion',NULL,'affiliate/approve_affiliate','23','affiliate','2019-04-05 23:00:15','N'),(19,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','24','affiliate','2019-04-05 23:01:36','Y'),(20,'Solicitud Declinada',3,'#','18','decline_affiliate','2019-04-05 23:04:23','Y'),(21,'Nueva Solicitud de Afilicacion',2,'affiliate/approve_affiliate','24','affiliate','2019-04-05 23:16:50','Y'),(22,'Solicitud Aprobada',3,'groups/group_information','18','approve_affiliate','2019-04-05 23:18:43','Y'),(23,'Su rol dentro del grupo Grupo 6 ha cambiado',3,'groups/group_information','18','change_role','2019-04-06 14:52:10','Y'),(24,'Su rol dentro del grupo Grupo 6 ha cambiado',3,'groups/group_information','18','change_role','2019-04-06 14:54:29','Y'),(25,'Usted fue Desafiliado del grupo Grupo 6',3,'#',NULL,'desaffiliate_user','2019-04-06 14:56:58','Y'),(26,'Nueva Solicitud de Afilicacion',2,'affiliate/approve_affiliate','24','affiliate','2019-04-06 15:07:09','Y'),(27,'Solicitud Aprobada',3,'groups/group_information','18','approve_affiliate','2019-04-06 15:07:49','Y'),(28,'Usted fue Desafiliado del grupo Grupo 6',3,'#',NULL,'desaffiliate_user','2019-04-06 15:12:03','Y'),(29,'Su rol dentro del grupo Prueba 1 ha cambiado',3,'groups/group_information','13','change_role','2019-04-08 12:21:31','Y'),(30,'Su rol dentro del grupo Prueba 1 ha cambiado',3,'groups/group_information','13','change_role','2019-04-08 12:21:36','Y'),(31,'A sido invitado a participar en el grupo \"Grupo 6\"',3,'affiliate/approve_request','24','request_membership','2019-04-09 17:42:34','Y'),(32,'Solicitud Aprobada',2,'groups/group_information','18','new_member','2019-04-09 19:51:55','Y'),(33,'Nueva Solicitud de Afilicacion',2,'affiliate/approve_affiliate','25','affiliate','2019-04-10 18:35:04','Y'),(34,'Solicitud Aprobada',3,'groups/group_information','15','approve_affiliate','2019-04-10 18:35:26','Y'),(35,'Su rol dentro del grupo Prueba 1 ha cambiado',3,'groups/group_information','13','change_role','2019-04-10 18:48:03','Y'),(36,'Usted fue Desafiliado del grupo Grupo 24',3,'#',NULL,'desaffiliate_user','2019-04-10 19:05:16','Y'),(37,'Usted fue Desafiliado del grupo Grupo 3',3,'#',NULL,'desaffiliate_user','2019-04-10 19:06:03','Y'),(38,'A sido invitado a participar en el grupo \"New group\"',1,'affiliate/approve_request','26','request_membership','2019-04-10 19:19:35','Y'),(39,'Tiene un Nuevo Miembro en su Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:20:03','Y'),(40,'Su rol dentro del grupo New group ha cambiado',1,'groups/group_information','20','change_role','2019-04-10 19:20:13','Y'),(41,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','27','request_membership','2019-04-10 19:25:33','Y'),(42,'Tiene un Nuevo Miembro en su Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:25:48','Y'),(43,'Usted fue Desafiliado del grupo New group',3,'#',NULL,'desaffiliate_user','2019-04-10 19:27:17','Y'),(44,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','28','request_membership','2019-04-10 19:30:04','Y'),(45,' ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:30:23','Y'),(46,' ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:30:25','Y'),(47,'Usted fue Desafiliado del grupo New group',3,'#',NULL,'desaffiliate_user','2019-04-10 19:33:55','Y'),(48,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','29','request_membership','2019-04-10 19:34:39','Y'),(49,'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:37:17','Y'),(50,'Usted fue Desafiliado del grupo New group',3,'#',NULL,'desaffiliate_user','2019-04-10 19:38:08','Y'),(51,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','30','request_membership','2019-04-10 19:38:39','Y'),(52,'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:39:52','Y'),(53,'Usted fue Desafiliado del grupo New group',3,'#',NULL,'desaffiliate_user','2019-04-10 19:40:51','Y'),(54,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','31','request_membership','2019-04-10 19:41:18','Y'),(55,'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"',1,'groups/group_information','20','new_member','2019-04-10 19:42:02','Y'),(56,'Usted fue Desafiliado del grupo New group',3,'#',NULL,'desaffiliate_user','2019-04-10 19:42:22','Y'),(57,'A sido invitado a participar en el grupo \"New group\"',3,'affiliate/approve_request','32','request_membership','2019-04-10 19:42:43','Y'),(58,'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"New group\"',1,'groups/group_information','20','new_member','2019-04-10 19:43:07','Y'),(59,'Nueva Solicitud de Afilicacion',1,'affiliate/approve_affiliate','33','affiliate','2019-04-10 21:29:05','Y'),(60,'Solicitud Aprobada',4,'groups/group_information','19','approve_affiliate','2019-04-10 21:29:35','Y'),(61,'A sido invitado a participar en el grupo \"Grupo 24\"',3,'affiliate/approve_request','34','request_membership','2019-04-10 21:31:04','Y'),(62,'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"Grupo 24\"',1,'groups/group_information','19','new_member','2019-04-10 21:33:33','Y'),(63,'Su rol dentro del grupo New group ha cambiado',3,'groups/group_information','20','change_role','2019-04-10 22:08:46','Y'),(64,'Nueva Solicitud de Afilicacion',NULL,'affiliate/approve_affiliate','35','affiliate','2019-04-11 19:15:37','N'),(65,'A sido invitado a participar en el grupo \"Grupo de Prueba JM\"',5,'affiliate/approve_request','36','request_membership','2019-04-11 19:24:23','Y'),(66,'Ana Maradeyes el Nuevo Miembro \n                                        del Grupo \"Grupo de Prueba J',1,'groups/group_information','21','new_member','2019-04-11 19:27:13','Y'),(67,'A sido invitado a participar en el grupo \"Grupo Exposed\"',1,'affiliate/approve_request','37','request_membership','2019-04-17 22:39:24','Y'),(68,'Administrador es el Nuevo Miembro \n                                        del Grupo \"Grupo Exposed\"',1,'groups/group_information','22','new_member','2019-04-17 22:39:32','Y');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param`
--

DROP TABLE IF EXISTS `param`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `param` (
  `param_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de parametros';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `param`
--

LOCK TABLES `param` WRITE;
/*!40000 ALTER TABLE `param` DISABLE KEYS */;
/*!40000 ALTER TABLE `param` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `menu_id` int(5) DEFAULT NULL,
  `user_level_id` int(5) DEFAULT NULL,
  `can_read` varchar(3) DEFAULT NULL,
  `can_write` varchar(3) DEFAULT NULL,
  `can_edit` varchar(3) DEFAULT NULL,
  `can_delete` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,5,1,'Yes','No','Yes','No'),(2,21,2,'No','No','No','No'),(3,20,2,'No','No','No','No'),(4,16,2,'No',NULL,NULL,NULL),(5,7,2,'No',NULL,NULL,NULL),(6,9,2,'No',NULL,NULL,NULL),(7,12,2,'No',NULL,NULL,NULL),(8,15,2,'No',NULL,NULL,NULL),(9,19,2,'No',NULL,NULL,NULL),(10,21,2,'Yes','Yes','Yes','Yes');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Table for Role''s Information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Lider','Lider','L'),(2,'Administrador','Administrador','A'),(3,'Miembro','Miembro de Grupo','M');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source`
--

LOCK TABLES `source` WRITE;
/*!40000 ALTER TABLE `source` DISABLE KEYS */;
INSERT INTO `source` VALUES (1,'Chat de WhatsApp','Chat de WhatsApp'),(2,'ReuniÃ³n','ReuniÃ³n'),(3,'Reunion en el Almuerzo','A'),(4,'ConversaciÃ³n','ConversaciÃ³n'),(5,'HangOut','HangOut');
/*!40000 ALTER TABLE `source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Pendiente','Pendiente','P'),(2,'Cerrado','Cerrado','C'),(3,'Completado','Completado','CO');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `names` varchar(140) DEFAULT NULL,
  `lastnames` varchar(140) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `profile_photo` varchar(256) DEFAULT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `is_visitor` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'Administrador','Intelix','jmartinezm@intelix.biz','admin','admin','1553488242_Josue Martinez.jpg',1,'No'),(2,0,'Josue ','Martinez','josuermartinezm@gmail.com','jmartinezm','jmartinezm','1554726061_IMG-20190306-WA0053.jpg',1,'No'),(3,NULL,'UsuarioX','ApellidoX','mailX@x.com','usuariox','usuariox','1554415923_image.png',2,'No'),(4,NULL,'Usuario Y','Y','usuarioy@y.com','usuarioy','usuarioy','1554931527_IMG-20190306-WA0005.jpg',2,'No'),(5,NULL,'Ana','Maradey','amaradey@intelix.biz','amaradey','amaradey','1555344069_image.png',2,'No'),(6,NULL,'Jose','Ramos','jramos@mail.com','jramos','jramos',NULL,2,'No');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_level`
--

DROP TABLE IF EXISTS `user_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_level` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name_level` varchar(50) DEFAULT NULL,
  `access_level` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_level`
--

LOCK TABLES `user_level` WRITE;
/*!40000 ALTER TABLE `user_level` DISABLE KEYS */;
INSERT INTO `user_level` VALUES (1,'Administrador',3),(2,'Participante',2);
/*!40000 ALTER TABLE `user_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'abx_db'
--
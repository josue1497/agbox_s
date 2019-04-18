-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-04-2019 a las 21:20:54
-- Tiempo de generación: 18-04-2019 a las 01:28:16
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `abx_db`
--
CREATE DATABASE IF NOT EXISTS `abx_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `abx_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `affiliate`
--

DROP TABLE IF EXISTS `affiliate`;
CREATE TABLE IF NOT EXISTS `affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `approved` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `affiliate`
--

INSERT INTO `affiliate` (`id`, `group_id`, `user_id`, `approved`) VALUES
(1, 13, 1, 'Yes'),
(2, 14, 1, 'Yes'),
(3, 15, 1, 'Yes'),
(4, 17, 1, 'Yes'),
(5, 18, 1, 'Yes'),
(6, 19, 1, 'Yes'),
(8, 13, 2, 'Yes'),
(9, NULL, NULL, 'Yes'),
(12, 19, 2, NULL),
(13, 13, 3, 'Yes'),
(16, 14, 2, 'Yes'),
(17, 18, 2, 'Yes'),
(20, 17, 2, 'Yes'),
(21, 17, 3, 'Yes'),
(23, 14, 3, 'Yes'),
(24, 18, 3, 'Yes'),
(26, 20, 1, 'Yes'),
(32, 20, 3, 'Yes'),
(33, 19, 4, 'Yes'),
(34, 19, 3, 'Yes'),
(35, 21, 1, 'Yes'),
<<<<<<< HEAD
(36, 21, 5, 'Yes');
=======
(36, 21, 5, 'Yes'),
(37, 22, 1, 'Yes');
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `group_photo` varchar(256) DEFAULT NULL,
  `leader_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Table for group''s information';

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `domain_id`, `parent_group_id`, `name`, `description`, `group_photo`, `leader_id`) VALUES
(13, NULL, NULL, 'Prueba 1', 'Prueba 1', '1552967118_(iori03_)12345729_862092230578521_320436592_n.jpg', NULL),
(14, NULL, 13, 'Grupo 2', 'Grupo 2', '1553045469_(claudiaalende)12327939_1523138514680505_341742002_n.jpg', NULL),
(15, NULL, NULL, 'Grupo 3', 'Grupo 3', '1553056938_(silla_e_mimbre)12224228_1654611478130905_689608145_n.jpg', 2),
(16, NULL, NULL, 'Grupo 4', 'Grupo 4', '1553310933_(claudiaalende)12327939_1523138514680505_341742002_n.jpg', NULL),
<<<<<<< HEAD
(17, NULL, NULL, 'Grupo 5', 'Grupo 5', '1553054128_(lexypanterra)12362050_1096808836998015_2103085051_n.jpg', NULL),
(18, NULL, NULL, 'Grupo 6', 'Grupo 6', '1554833587_IMG-20190306-WA0005.jpg', 2),
(19, NULL, NULL, 'Grupo 24', 'Grupo 4d', '1553487426_(iori03_)12345729_862092230578521_320436592_n.jpg', NULL),
(20, NULL, 14, 'New group', 'New group', '1553712932_IMG-20190306-WA0024.jpg', 1),
(21, NULL, 13, 'Grupo de Prueba JM', 'Grupo de Prueba JM', NULL, 1);
=======
(17, NULL, NULL, 'Grupo 5', 'Descripcion de Grupo, un poco mas larga probando que se vea bien el modal de informacion de grupo', '1553054128_(lexypanterra)12362050_1096808836998015_2103085051_n.jpg', NULL),
(18, NULL, NULL, 'Grupo 6', 'Grupo 6', '1554833587_IMG-20190306-WA0005.jpg', 2),
(19, NULL, NULL, 'Grupo 24', 'Grupo 4d', '1553487426_(iori03_)12345729_862092230578521_320436592_n.jpg', NULL),
(20, NULL, 14, 'New group', 'New group', '1553712932_IMG-20190306-WA0024.jpg', 1),
(21, NULL, 13, 'Grupo de Prueba JM', 'Grupo de Prueba JM', NULL, 1),
(22, NULL, NULL, 'Grupo Exposed', 'S', NULL, 1),
(24, NULL, NULL, 'Test Group', 'Si', NULL, 1);
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_user_role`
--

DROP TABLE IF EXISTS `group_user_role`;
CREATE TABLE IF NOT EXISTS `group_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `group_user_role`
--

INSERT INTO `group_user_role` (`id`, `group_id`, `user_id`, `role_id`) VALUES
(1, 13, 1, 1),
(2, 19, 1, 1),
(3, 20, 1, 1),
(4, 13, 3, 5),
(9, 17, 1, 1),
(10, 17, 3, 3),
(13, 18, 2, 1),
(14, 18, 3, 3),
(15, 15, 2, 1),
(21, 20, 3, 5),
(22, 19, 4, 3),
(23, 19, 3, 3),
(24, NULL, 1, 1),
(25, 21, 1, 1),
<<<<<<< HEAD
(26, 21, 5, 3);
=======
(26, 21, 5, 3),
(27, NULL, 1, 1),
(28, NULL, 1, 1),
(29, NULL, 1, 1),
(30, NULL, 1, 1),
(31, NULL, 1, 1),
(32, NULL, 1, 1),
(33, NULL, 1, 1),
(34, NULL, 1, 1),
(35, 22, 1, 3),
(36, 24, 1, 1);
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `icon` varchar(256) DEFAULT NULL,
  `menu_order` int(5) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `parent_menu_id` int(5) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`menu_id`, `title`, `description`, `icon`, `menu_order`, `url`, `parent_menu_id`) VALUES
(7, 'Sources', 'Soruces', 'empty', 0, 'source/index', 11),
(9, 'Role', 'Role', 'empty', NULL, 'role/index', 11),
(11, 'Mantenimiento', 'Mantenimiento', 'fab fa-algolia', 1, '#', 0),
(12, 'Affiliate', 'Affiliate', 'fab fa-500px', 3, 'affiliate', 11),
(13, 'Group', 'Group', 'empty', 4, 'groups', 11),
(14, 'Note', 'Note', 'fas fa-address-book', 4, 'note', 11),
(15, 'Note Type', 'Type', 'fab fa-accessible-icon', 5, 'note_type', 11),
(16, 'Test', 'Prueba', 'fab fa-accessible-icon', 5, '#', 0),
(17, 'Note Approver', 'Note Approver', 'fas fa-address-book', 6, 'note_approver', 11),
(18, 'Affiliate To Group', 'Affiliate To Group', 'empty', 1, 'affiliate/items', 16),
(19, 'Note Status', 'Note Status', 'fab fa-accessible-icon', 2, 'status', 11),
(20, 'Create Assignment', 'Create Assignment', 'empty', 2, 'note/create_assignment', 21),
(21, 'Notas', 'Notas', 'far fa-address-book', 3, NULL, 0),
(22, 'Create Suggested Point', 'Create Suggested Point', 'empty', 2, 'note/create_suggested_point', 21),
(23, 'Create commitment', 'Create commitment', 'empty', 3, 'note/create_commitment', 21),
(24, 'Create agenda point', 'Create agenda point', 'empty', 4, 'note/create_agenda_point', 21),
(25, 'Role group', NULL, 'fab fa-adn', 23, 'group_user_role', 11),
(26, 'Afiliacion a Grupos', 'Afiliacion a Grupos', 'empty', 2, 'affiliate/items', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note`
--

INSERT INTO `note` (`id`, `user_id`, `title`, `note_type_id`, `source_id`, `group_id`, `summary`, `init_date`, `finish_date`, `status_id`, `date_approved`, `performer_id`) VALUES
(1, 1, 'Group', 1, 2, 13, 'Prueba de Sumario', '2019-03-14', '2019-03-05', 1, NULL, NULL),
(2, 2, 'Crud Test', 1, 1, NULL, 'A', '2019-03-22', '2019-03-29', 1, '2019-03-14', NULL),
(3, 1, 'Comentario de Prueba', 3, 1, 18, 'Esto es una prueba de guardado de un comentario', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_approver`
--

DROP TABLE IF EXISTS `note_approver`;
CREATE TABLE IF NOT EXISTS `note_approver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `choice` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_approver`
--

INSERT INTO `note_approver` (`id`, `note_id`, `user_id`, `choice`) VALUES
(1, 1, 1, NULL),
(3, 1, 2, NULL),
(4, 3, 2, NULL),
(5, 3, 4, NULL),
(6, 3, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_type`
--

DROP TABLE IF EXISTS `note_type`;
CREATE TABLE IF NOT EXISTS `note_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_type`
--

INSERT INTO `note_type` (`id`, `name`, `description`, `value`) VALUES
(1, 'Punto Sugerido', 'Punto Sugerido', 'SP'),
(2, 'Asignaciones', 'Asignaciones', 'AS'),
(3, 'Compromisos', 'Compromisos', 'CO'),
(4, 'Punto de Agenda', 'Punto de Agenda', 'AP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
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

--
-- Volcado de datos para la tabla `notification`
--

INSERT INTO `notification` (`id`, `message`, `user_to_id`, `controller_to`, `entity_id`, `notification_type`, `shipping_date`, `read`) VALUES
(2, 'test notification 2', 1, 'affiliate/approve_affiliate', '1', 'affiliate', '2019-03-29 13:24:09', 'Y'),
(3, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '9', 'affiliate', '2019-03-29 14:28:05', 'Y'),
(4, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '9', 'affiliate', '2019-03-29 22:16:42', 'Y'),
(5, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '9', 'affiliate', '2019-03-29 22:17:33', 'Y'),
(6, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '9', 'affiliate', '2019-03-29 22:18:40', 'Y'),
(7, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '10', 'affiliate', '2019-03-29 22:22:11', 'Y'),
(8, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '12', 'affiliate', '2019-03-29 22:38:37', 'Y'),
(9, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '13', 'affiliate', '2019-04-04 22:24:16', 'Y'),
(10, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '14', 'affiliate', '2019-04-04 23:18:46', 'Y'),
(11, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '14', 'affiliate', '2019-04-04 23:21:58', 'Y'),
(12, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '17', 'affiliate', '2019-04-04 23:28:47', 'Y'),
(13, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '18', 'affiliate', '2019-04-05 20:53:47', 'Y'),
(14, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '21', 'affiliate', '2019-04-05 21:02:40', 'Y'),
(15, 'Solicitud Aprobada', 3, 'groups/group_information', '17', 'approve_affiliate', '2019-04-05 21:10:58', 'Y'),
(16, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '22', 'affiliate', '2019-04-05 22:46:22', 'Y'),
(17, 'Solicitud Aprobada', 3, 'groups/group_information', '19', 'approve_affiliate', '2019-04-05 22:46:46', 'Y'),
(18, 'Nueva Solicitud de Afilicacion', NULL, 'affiliate/approve_affiliate', '23', 'affiliate', '2019-04-05 23:00:15', 'N'),
(19, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '24', 'affiliate', '2019-04-05 23:01:36', 'Y'),
(20, 'Solicitud Declinada', 3, '#', '18', 'decline_affiliate', '2019-04-05 23:04:23', 'Y'),
(21, 'Nueva Solicitud de Afilicacion', 2, 'affiliate/approve_affiliate', '24', 'affiliate', '2019-04-05 23:16:50', 'Y'),
(22, 'Solicitud Aprobada', 3, 'groups/group_information', '18', 'approve_affiliate', '2019-04-05 23:18:43', 'Y'),
(23, 'Su rol dentro del grupo Grupo 6 ha cambiado', 3, 'groups/group_information', '18', 'change_role', '2019-04-06 14:52:10', 'Y'),
(24, 'Su rol dentro del grupo Grupo 6 ha cambiado', 3, 'groups/group_information', '18', 'change_role', '2019-04-06 14:54:29', 'Y'),
(25, 'Usted fue Desafiliado del grupo Grupo 6', 3, '#', NULL, 'desaffiliate_user', '2019-04-06 14:56:58', 'Y'),
(26, 'Nueva Solicitud de Afilicacion', 2, 'affiliate/approve_affiliate', '24', 'affiliate', '2019-04-06 15:07:09', 'Y'),
(27, 'Solicitud Aprobada', 3, 'groups/group_information', '18', 'approve_affiliate', '2019-04-06 15:07:49', 'Y'),
(28, 'Usted fue Desafiliado del grupo Grupo 6', 3, '#', NULL, 'desaffiliate_user', '2019-04-06 15:12:03', 'Y'),
(29, 'Su rol dentro del grupo Prueba 1 ha cambiado', 3, 'groups/group_information', '13', 'change_role', '2019-04-08 12:21:31', 'Y'),
(30, 'Su rol dentro del grupo Prueba 1 ha cambiado', 3, 'groups/group_information', '13', 'change_role', '2019-04-08 12:21:36', 'Y'),
(31, 'A sido invitado a participar en el grupo \"Grupo 6\"', 3, 'affiliate/approve_request', '24', 'request_membership', '2019-04-09 17:42:34', 'Y'),
(32, 'Solicitud Aprobada', 2, 'groups/group_information', '18', 'new_member', '2019-04-09 19:51:55', 'Y'),
(33, 'Nueva Solicitud de Afilicacion', 2, 'affiliate/approve_affiliate', '25', 'affiliate', '2019-04-10 18:35:04', 'Y'),
(34, 'Solicitud Aprobada', 3, 'groups/group_information', '15', 'approve_affiliate', '2019-04-10 18:35:26', 'Y'),
(35, 'Su rol dentro del grupo Prueba 1 ha cambiado', 3, 'groups/group_information', '13', 'change_role', '2019-04-10 18:48:03', 'Y'),
(36, 'Usted fue Desafiliado del grupo Grupo 24', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:05:16', 'Y'),
(37, 'Usted fue Desafiliado del grupo Grupo 3', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:06:03', 'Y'),
(38, 'A sido invitado a participar en el grupo \"New group\"', 1, 'affiliate/approve_request', '26', 'request_membership', '2019-04-10 19:19:35', 'Y'),
(39, 'Tiene un Nuevo Miembro en su Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:20:03', 'Y'),
(40, 'Su rol dentro del grupo New group ha cambiado', 1, 'groups/group_information', '20', 'change_role', '2019-04-10 19:20:13', 'Y'),
(41, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '27', 'request_membership', '2019-04-10 19:25:33', 'Y'),
(42, 'Tiene un Nuevo Miembro en su Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:25:48', 'Y'),
(43, 'Usted fue Desafiliado del grupo New group', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:27:17', 'Y'),
(44, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '28', 'request_membership', '2019-04-10 19:30:04', 'Y'),
(45, ' ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:30:23', 'Y'),
(46, ' ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:30:25', 'Y'),
(47, 'Usted fue Desafiliado del grupo New group', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:33:55', 'Y'),
(48, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '29', 'request_membership', '2019-04-10 19:34:39', 'Y'),
(49, 'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:37:17', 'Y'),
(50, 'Usted fue Desafiliado del grupo New group', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:38:08', 'Y'),
(51, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '30', 'request_membership', '2019-04-10 19:38:39', 'Y'),
(52, 'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:39:52', 'Y'),
(53, 'Usted fue Desafiliado del grupo New group', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:40:51', 'Y'),
(54, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '31', 'request_membership', '2019-04-10 19:41:18', 'Y'),
(55, 'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:42:02', 'Y'),
(56, 'Usted fue Desafiliado del grupo New group', 3, '#', NULL, 'desaffiliate_user', '2019-04-10 19:42:22', 'Y'),
(57, 'A sido invitado a participar en el grupo \"New group\"', 3, 'affiliate/approve_request', '32', 'request_membership', '2019-04-10 19:42:43', 'Y'),
(58, 'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"New group\"', 1, 'groups/group_information', '20', 'new_member', '2019-04-10 19:43:07', 'Y'),
(59, 'Nueva Solicitud de Afilicacion', 1, 'affiliate/approve_affiliate', '33', 'affiliate', '2019-04-10 21:29:05', 'Y'),
(60, 'Solicitud Aprobada', 4, 'groups/group_information', '19', 'approve_affiliate', '2019-04-10 21:29:35', 'Y'),
(61, 'A sido invitado a participar en el grupo \"Grupo 24\"', 3, 'affiliate/approve_request', '34', 'request_membership', '2019-04-10 21:31:04', 'Y'),
(62, 'UsuarioX ApellidoXes el Nuevo Miembro \n                                        del Grupo \"Grupo 24\"', 1, 'groups/group_information', '19', 'new_member', '2019-04-10 21:33:33', 'Y'),
(63, 'Su rol dentro del grupo New group ha cambiado', 3, 'groups/group_information', '20', 'change_role', '2019-04-10 22:08:46', 'Y'),
(64, 'Nueva Solicitud de Afilicacion', NULL, 'affiliate/approve_affiliate', '35', 'affiliate', '2019-04-11 19:15:37', 'N'),
(65, 'A sido invitado a participar en el grupo \"Grupo de Prueba JM\"', 5, 'affiliate/approve_request', '36', 'request_membership', '2019-04-11 19:24:23', 'Y'),
<<<<<<< HEAD
(66, 'Ana Maradeyes el Nuevo Miembro \n                                        del Grupo \"Grupo de Prueba J', 1, 'groups/group_information', '21', 'new_member', '2019-04-11 19:27:13', 'Y');


-- ---------------------------------

-- 
-- Estructura de tabla para la tabla `param`
-- 
DROP TABLE IF EXISTS param;
CREATE TABLE `param` (
  `param_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de parametros' AUTO_INCREMENT=1 ;

=======
(66, 'Ana Maradeyes el Nuevo Miembro \n                                        del Grupo \"Grupo de Prueba J', 1, 'groups/group_information', '21', 'new_member', '2019-04-11 19:27:13', 'Y'),
(67, 'A sido invitado a participar en el grupo \"Grupo Exposed\"', 1, 'affiliate/approve_request', '37', 'request_membership', '2019-04-17 22:39:24', 'Y'),
(68, 'Administrador es el Nuevo Miembro \n                                        del Grupo \"Grupo Exposed\"', 1, 'groups/group_information', '22', 'new_member', '2019-04-17 22:39:32', 'Y');
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `menu_id` int(5) DEFAULT NULL,
  `user_level_id` int(5) DEFAULT NULL,
  `can_read` varchar(3) DEFAULT NULL,
  `can_write` varchar(3) DEFAULT NULL,
  `can_edit` varchar(3) DEFAULT NULL,
  `can_delete` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permission`
--

INSERT INTO `permission` (`id`, `menu_id`, `user_level_id`, `can_read`, `can_write`, `can_edit`, `can_delete`) VALUES
(1, 5, 1, 'Yes', 'No', 'Yes', 'No'),
(2, 21, 2, 'No', 'No', 'No', 'No'),
(3, 20, 2, 'No', 'No', 'No', 'No'),
(4, 16, 2, 'No', NULL, NULL, NULL),
(5, 7, 2, 'No', NULL, NULL, NULL),
(6, 9, 2, 'No', NULL, NULL, NULL),
(7, 12, 2, 'No', NULL, NULL, NULL),
(8, 15, 2, 'No', NULL, NULL, NULL),
(9, 19, 2, 'No', NULL, NULL, NULL),
(10, 21, 2, 'Yes', 'Yes', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Table for Role''s Information';

--
-- Volcado de datos para la tabla `role`
--

<<<<<<< HEAD
INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'Lider', 'Lider'),
(2, 'Administrador', 'Administrador'),
(3, 'Participante', 'Participante del Grupo');
=======
INSERT INTO `role` (`id`, `name`, `description`, `value`) VALUES
(1, 'Lider', 'Lider', 'L'),
(2, 'Administrador', 'Administrador', 'A'),
(3, 'Miembro', 'Miembro de Grupo', 'M');
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE IF NOT EXISTS `source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `source`
--

INSERT INTO `source` (`id`, `title`, `description`) VALUES
(1, 'Chat de WhatsApp', 'Chat de WhatsApp'),
(2, 'ReuniÃ³n', 'ReuniÃ³n'),
(3, 'Reunion en el Almuerzo', 'A'),
(4, 'ConversaciÃ³n', 'ConversaciÃ³n'),
(5, 'HangOut', 'HangOut');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`, `description`, `value`) VALUES
(1, 'Pendiente', 'Pendiente', 'P'),
(2, 'Cerrado', 'Cerrado', 'C'),
(3, 'Completado', 'Completado', 'CO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
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

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `employee_id`, `names`, `lastnames`, `mail`, `username`, `password`, `profile_photo`, `user_level_id`, `is_visitor`) VALUES
(1, 1, 'Administrador', 'Intelix', 'jmartinezm@intelix.biz', 'admin', 'admin', '1553488242_Josue Martinez.jpg', 1, 'No'),
(2, 0, 'Josue ', 'Martinez', 'josuermartinezm@gmail.com', 'jmartinezm', 'jmartinezm', '1554726061_IMG-20190306-WA0053.jpg', 1, 'No'),
(3, NULL, 'UsuarioX', 'ApellidoX', 'mailX@x.com', 'usuariox', 'usuariox', '1554415923_image.png', 2, 'No'),
(4, NULL, 'Usuario Y', 'Y', 'usuarioy@y.com', 'usuarioy', 'usuarioy', '1554931527_IMG-20190306-WA0005.jpg', 2, 'No'),
<<<<<<< HEAD
(5, NULL, 'Ana', 'Maradey', 'amaradey@intelix.biz', 'amaradey', 'amaradey', NULL, 2, 'No'),
=======
(5, NULL, 'Ana', 'Maradey', 'amaradey@intelix.biz', 'amaradey', 'amaradey', '1555344069_image.png', 2, 'No'),
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32
(6, NULL, 'Jose', 'Ramos', 'jramos@mail.com', 'jramos', 'jramos', NULL, 2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_level`
--

DROP TABLE IF EXISTS `user_level`;
CREATE TABLE IF NOT EXISTS `user_level` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name_level` varchar(50) DEFAULT NULL,
  `access_level` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_level`
--

INSERT INTO `user_level` (`id`, `name_level`, `access_level`) VALUES
(1, 'Administrador', 3),
<<<<<<< HEAD
(2, 'Manager', 2),
(3, 'Participante', 1);


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `affiliate`
--
ALTER TABLE `affiliate`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `group_user_role`
--
ALTER TABLE `group_user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `note_approver`
--
ALTER TABLE `note_approver`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `note_type`
--
ALTER TABLE `note_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `affiliate`
--
ALTER TABLE `affiliate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `group_user_role`
--
ALTER TABLE `group_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `note_approver`
--
ALTER TABLE `note_approver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `note_type`
--
ALTER TABLE `note_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `source`
--
ALTER TABLE `source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
=======
(2, 'Participante', 2);
COMMIT;
>>>>>>> b68e3bffa532f3c334c61717db6939a7a1af8f32

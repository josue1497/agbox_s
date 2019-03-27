-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-03-2019 a las 19:23:16
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `abx_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `affiliate`
--

CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `approved` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `affiliate`
--

INSERT INTO `affiliate` (`id`, `group_id`, `user_id`, `approved`) VALUES
(1, 13, 1, 'Yes'),
(2, 14, 1, 'Yes'),
(3, 15, 1, NULL),
(4, 17, 1, NULL),
(5, 18, 1, NULL),
(6, 19, 1, NULL),
(7, 16, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `domain_id` int(11) DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `group_photo` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for group''s information';

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `domain_id`, `parent_group_id`, `name`, `description`, `group_photo`) VALUES
(13, NULL, NULL, 'Prueba 1', 'Prueba 1', '1552967118_(iori03_)12345729_862092230578521_320436592_n.jpg'),
(14, NULL, 13, 'Grupo 2', 'Grupo 2', '1553045469_(claudiaalende)12327939_1523138514680505_341742002_n.jpg'),
(15, NULL, NULL, 'Grupo 3', 'Grupo 3', '1553056938_(silla_e_mimbre)12224228_1654611478130905_689608145_n.jpg'),
(16, NULL, NULL, 'Grupo 4', 'Grupo 4', '1553310933_(claudiaalende)12327939_1523138514680505_341742002_n.jpg'),
(17, NULL, NULL, 'Grupo 5', 'Grupo 5', '1553054128_(lexypanterra)12362050_1096808836998015_2103085051_n.jpg'),
(18, NULL, NULL, 'Grupo 6', 'Grupo 6', NULL),
(19, NULL, NULL, 'Grupo 24', 'Grupo 4d', '1553487426_(iori03_)12345729_862092230578521_320436592_n.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_user_role`
--

CREATE TABLE `group_user_role` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `group_user_role`
--

INSERT INTO `group_user_role` (`id`, `group_id`, `user_id`, `role_id`) VALUES
(1, 13, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(5) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `icon` varchar(256) DEFAULT NULL,
  `menu_order` int(5) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `parent_menu_id` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`menu_id`, `title`, `description`, `icon`, `menu_order`, `url`, `parent_menu_id`) VALUES
(7, 'Sources', 'Soruces', 'empty', 0, 'source/index', 11),
(9, 'Role', 'Role', 'empty', NULL, 'role/index', 11),
(11, 'Crud Test', 'Crud', 'fas fa-notes-medical', 1, '#', 0),
(12, 'Affiliate', 'Affiliate', 'fab fa-500px', 3, 'affiliate', 11),
(13, 'Group', 'Group', 'empty', 4, 'groups', 11),
(14, 'Note', 'Note', 'fas fa-address-book', 4, 'note', 11),
(15, 'Note Type', 'Type', 'fab fa-accessible-icon', 5, 'note_type', 11),
(16, 'Test', 'Prueba', 'fab fa-accessible-icon', 5, '#', 0),
(17, 'Note Approver', 'Note Approver', 'fas fa-address-book', 6, 'note_approver', 11),
(18, 'Affiliate To Group', 'Affiliate To Group', 'empty', 1, 'affiliate_to_group/items', 16),
(19, 'Note Status', 'Note Status', 'fab fa-accessible-icon', 2, 'status', 11),
(20, 'Create Assignment', 'Create Assignment', 'empty', 2, 'note/create_assignment', 21),
(21, 'Notas', 'Notas', 'far fa-address-book', 3, NULL, 0),
(22, 'Create Suggested Point', 'Create Suggested Point', 'empty', 2, 'note/create_suggested_point', 21),
(23, 'Create commitment', 'Create commitment', 'empty', 3, 'note/create_commitment', 21),
(24, 'Create agenda point', 'Create agenda point', 'empty', 4, 'note/create_agenda_point', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
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
  `performer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note`
--

INSERT INTO `note` (`id`, `user_id`, `title`, `note_type_id`, `source_id`, `group_id`, `summary`, `init_date`, `finish_date`, `status_id`, `date_approved`, `performer_id`) VALUES
(1, 1, 'Group', 1, 2, 13, 'Prueba de Sumario', '2019-03-14', '2019-03-05', 1, NULL, NULL),
(2, 2, 'Crud Test', 1, 1, NULL, 'A', '2019-03-22', '2019-03-29', 1, '2019-03-14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_approver`
--

CREATE TABLE `note_approver` (
  `id` int(11) NOT NULL,
  `note_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `choice` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_approver`
--

INSERT INTO `note_approver` (`id`, `note_id`, `user_id`, `choice`) VALUES
(1, 1, 1, NULL),
(3, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_type`
--

CREATE TABLE `note_type` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_type`
--

INSERT INTO `note_type` (`id`, `name`, `description`) VALUES
(1, 'Punto Sugerido', 'Punto Sugerido'),
(2, 'Asignaciones', 'Asignaciones'),
(3, 'Compromisos', 'Compromisos'),
(4, 'Punto de Agenda', 'Punto de Agenda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

CREATE TABLE `permission` (
  `id` int(5) NOT NULL,
  `menu_id` int(5) DEFAULT NULL,
  `user_level_id` int(5) DEFAULT NULL,
  `can_read` varchar(3) DEFAULT NULL,
  `can_write` varchar(3) DEFAULT NULL,
  `can_edit` varchar(3) DEFAULT NULL,
  `can_delete` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permission`
--

INSERT INTO `permission` (`id`, `menu_id`, `user_level_id`, `can_read`, `can_write`, `can_edit`, `can_delete`) VALUES
(1, 5, 1, 'Yes', 'No', 'Yes', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for Role''s Information';

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'Lider', 'Lider'),
(2, 'Administrador', 'Administrador'),
(3, 'Miembro', 'Miembro de Grupo'),
(5, 'Invitado', 'Invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `source`
--

CREATE TABLE `source` (
  `id` int(11) NOT NULL,
  `title` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`, `description`) VALUES
(1, 'Abierto', 'Abierto'),
(2, 'Cerrado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `names` varchar(140) DEFAULT NULL,
  `lastnames` varchar(140) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `profile_photo` varchar(256) DEFAULT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `is_visitor` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `employee_id`, `names`, `lastnames`, `mail`, `username`, `password`, `profile_photo`, `user_level_id`, `is_visitor`) VALUES
(1, 1, 'Administrador', 'Intelix', 'jmartinezm@intelix.biz', 'admin', 'admin', '1553488242_Josue Martinez.jpg', 1, 'No'),
(2, 0, 'Josue ', 'Martinez', 'josuermartinezm@gmail.com', 'jmartinezm', 'josu12345', NULL, 1, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_level`
--

CREATE TABLE `user_level` (
  `id` int(5) NOT NULL,
  `name_level` varchar(50) DEFAULT NULL,
  `access_level` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_level`
--

INSERT INTO `user_level` (`id`, `name_level`, `access_level`) VALUES
(1, 'Administrador', 3),
(2, 'Participante', 2);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `group_user_role`
--
ALTER TABLE `group_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `note_approver`
--
ALTER TABLE `note_approver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `note_type`
--
ALTER TABLE `note_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

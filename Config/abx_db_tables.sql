
--
-- Base de datos: `abx_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL,
  `titulo_menu` varchar(256) NOT NULL,
  `descripcion_menu` varchar(256) NOT NULL,
  `icon_menu` varchar(256) NOT NULL,
  `orden_menu` int(5) NOT NULL,
  `url_menu` varchar(256) NOT NULL,
  `id_menu_padre` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `titulo_menu`, `descripcion_menu`, `icon_menu`, `orden_menu`, `url_menu`, `id_menu_padre`) VALUES
(5, 'menu padre', 'padre', 'fas fa-address-book', 2, '', 0),
(6, 'menu hijo2', 'menu hijo 2', 'fas fa-address-book', 1, '', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_usuario`
--

CREATE TABLE `nivel_usuario` (
  `id_nivel_usuario` int(5) NOT NULL,
  `nombre_nivel_usuario` varchar(50) DEFAULT NULL,
  `acceso_nivel_usuario` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel_usuario`
--

INSERT INTO `nivel_usuario` (`id_nivel_usuario`, `nombre_nivel_usuario`, `acceso_nivel_usuario`) VALUES
(1, 'Administrador', 3),
(2, 'Participante', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(5) NOT NULL,
  `id_menu` int(5) NOT NULL,
  `id_nivel_usuario` int(5) NOT NULL,
  `leer_permiso` varchar(3) NOT NULL,
  `escribir_permiso` varchar(3) NOT NULL,
  `editar_permiso` varchar(3) NOT NULL,
  `eliminar_permiso` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `id_menu`, `id_nivel_usuario`, `leer_permiso`, `escribir_permiso`, `editar_permiso`, `eliminar_permiso`) VALUES
(1, 5, 1, 'Yes', 'No', 'Yes', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave_usuario` varchar(50) DEFAULT NULL,
  `id_nivel_usuario` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `clave_usuario`, `id_nivel_usuario`) VALUES
(1, 'admin', 'admin', 1),
(2, 'user', 'user', 2);
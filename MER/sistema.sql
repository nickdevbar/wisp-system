-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-11-2021 a las 13:50:02
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_mantenimientos`
--

CREATE TABLE `act_mantenimientos` (
  `cod_act_man` int(11) NOT NULL,
  `sol_act_man` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obs_act_man` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_act_man` varchar(145) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_act_man` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuarios_cod_usu` int(11) NOT NULL,
  `mantenimientos_cod_man` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cod_cli` int(11) NOT NULL,
  `nom_cli` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_cli` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel2_cli` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ema_cli` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_cli` timestamp NULL DEFAULT NULL,
  `tipo_cli` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ced_cli` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_cli` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pun_ref_cli` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estatus_clientes_cod_est_cli` int(11) NOT NULL,
  `sector_cod_sector` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `cod_company` int(11) NOT NULL,
  `razon_social` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_company` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rif_company` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_company` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_company` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ema_company` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fanpage_company` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram_company` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_company` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_company` timestamp NULL DEFAULT NULL,
  `estatus_cod_est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`cod_company`, `razon_social`, `tipo_company`, `rif_company`, `dir_company`, `tel_company`, `ema_company`, `fanpage_company`, `instagram_company`, `logo_company`, `fec_company`, `estatus_cod_est`) VALUES
(1, 'INTERCOD', 'V-', '29713030', 'Plaza Miranda', '244543942', 'intercod@gmail.com', 'intercod.co', '@intercod', 'intercod.jpg', '2021-11-18 06:50:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `cod_contratos` int(11) NOT NULL,
  `num_contrato` int(11) DEFAULT NULL,
  `fec_contrato` timestamp NULL DEFAULT NULL,
  `clientes_cod_cli` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL,
  `routers_cod_router` int(11) NOT NULL,
  `fecha_corte_cod_fec_corte` int(11) NOT NULL,
  `tipo_instalacion_cod_tipo_ins` int(11) NOT NULL,
  `usuarios_cod_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_contratos`
--

CREATE TABLE `detalles_contratos` (
  `cod_det_con` int(11) NOT NULL,
  `mac_det_con` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contratos_cod_contratos` int(11) NOT NULL,
  `ips_cod_ip` int(11) NOT NULL,
  `planes_cod_plan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `cod_est` int(11) NOT NULL,
  `nom_est` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`cod_est`, `nom_est`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Pendiente'),
(4, 'Realizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_clientes`
--

CREATE TABLE `estatus_clientes` (
  `cod_est_cli` int(11) NOT NULL,
  `nom_est_cli` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estatus_clientes`
--

INSERT INTO `estatus_clientes` (`cod_est_cli`, `nom_est_cli`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Estudio Pendiente'),
(4, 'Estudio Realizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_contable`
--

CREATE TABLE `estatus_contable` (
  `cod_est_con` int(11) NOT NULL,
  `nom_est_con` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estatus_contable`
--

INSERT INTO `estatus_contable` (`cod_est_con`, `nom_est_con`) VALUES
(1, 'Factura Pendiente '),
(2, 'Factura Paga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `cod_fac` int(11) NOT NULL,
  `num_factura` int(11) DEFAULT NULL,
  `fec_cre_fac` timestamp NULL DEFAULT NULL,
  `mes_fac` int(11) DEFAULT NULL,
  `ano_fac` int(11) DEFAULT NULL,
  `mon_fac` float DEFAULT NULL,
  `mon_ded_fac` float DEFAULT NULL,
  `des_fac` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estatus_contable_cod_est_con` int(11) NOT NULL,
  `fecha_corte_cod_fec_corte` int(11) NOT NULL,
  `usuarios_cod_usu` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL,
  `contratos_cod_contratos` int(11) NOT NULL,
  `planes_cod_plan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallas`
--

CREATE TABLE `fallas` (
  `cod_fallas` int(11) NOT NULL,
  `nom_fallas` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `fallas`
--

INSERT INTO `fallas` (`cod_fallas`, `nom_fallas`) VALUES
(1, 'No hay internet'),
(2, 'Se movio la antena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_corte`
--

CREATE TABLE `fecha_corte` (
  `cod_fec_corte` int(11) NOT NULL,
  `dia_fec_corte` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `cod_for_pag` int(11) NOT NULL,
  `nom_for_pag` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`cod_for_pag`, `nom_for_pag`) VALUES
(1, 'Efectivo'),
(2, 'Transferencia COP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_menu`
--

CREATE TABLE `grupo_menu` (
  `cod_gru_men` int(11) NOT NULL,
  `ico_gru_men` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nom_gru_men` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grupo_menu`
--

INSERT INTO `grupo_menu` (`cod_gru_men`, `ico_gru_men`, `nom_gru_men`) VALUES
(1, 'fas fa-users', 'Clientes'),
(2, 'fas fa-wrench', 'Mantenimientos'),
(3, 'fas fa-chart-bar', 'Reportes'),
(4, 'fas fa-broadcast-tower', 'Server'),
(5, 'fas fa-cogs', 'Sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ips`
--

CREATE TABLE `ips` (
  `cod_ip` int(11) NOT NULL,
  `ip_contrato` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_cod_company` int(11) NOT NULL,
  `segmentos_ip_cod_seg_ip` int(11) NOT NULL,
  `estatus_cod_est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `cod_man` int(11) NOT NULL,
  `obs_man` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_man` timestamp NULL DEFAULT NULL,
  `estatus_cod_est` int(11) NOT NULL,
  `usuarios_cod_usu` int(11) NOT NULL,
  `fallas_cod_fallas` int(11) NOT NULL,
  `contratos_cod_contratos` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_link`
--

CREATE TABLE `menu_link` (
  `cod_men_link` int(11) NOT NULL,
  `nom_men_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rut_men_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visible` int(11) DEFAULT NULL,
  `grupo_menu_cod_gru_men` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `menu_link`
--

INSERT INTO `menu_link` (`cod_men_link`, `nom_men_link`, `rut_men_link`, `visible`, `grupo_menu_cod_gru_men`) VALUES
(1, 'Clientes Activos', 'clientes_activos.php', 1, 1),
(2, 'Clientes Inactivos', 'clientes_inactivos.php', 1, 1),
(3, 'Clientes En Espera', 'en_espera.php', 1, 1),
(4, 'Nuevo Cliente', 'nuevo_cliente.php', 1, 1),
(5, 'Pendientes', 'mantenimientos_pendientes.php', 1, 2),
(6, 'Realizados', 'historico_mantenimientos.php', 1, 2),
(7, 'Graficas', 'graficas.php', 1, 3),
(10, 'Routers', 'l_conexiones.php', 1, 4),
(11, 'Segmentos IP', 'segmentos.php', 1, 4),
(12, 'Compañia', 'compania.php', 1, 5),
(13, 'Exportar', 'export.php', 1, 5),
(14, 'Planes', 'l_planes.php', 1, 5),
(15, 'Suspender Clientes', 'suspender.php', 1, 5),
(16, 'Uusarios', 'users.php', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_factura`
--

CREATE TABLE `pago_factura` (
  `cod_pag_fac` int(11) NOT NULL,
  `mon_pag_fac` float DEFAULT NULL,
  `obs_pag_fac` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_pag_fac` timestamp NULL DEFAULT NULL,
  `factura_cod_fac` int(11) NOT NULL,
  `forma_pago_cod_for_pag` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL,
  `usuarios_cod_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `cod_plan` int(11) NOT NULL,
  `nom_plan` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pre_plan` float DEFAULT NULL,
  `vel_sub_plan` int(11) DEFAULT NULL,
  `tx` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vel_des_plan` int(11) DEFAULT NULL,
  `rx` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_cre_plan` timestamp NULL DEFAULT NULL,
  `estatus_cod_est` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puertos_red`
--

CREATE TABLE `puertos_red` (
  `cod_puerto_red` int(11) NOT NULL,
  `nom_puerto_red` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `routers_cod_router` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `cod_rol` int(11) NOT NULL,
  `nom_rol` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`cod_rol`, `nom_rol`) VALUES
(1, 'Gerente '),
(2, 'Secretaria '),
(3, 'Tecnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routers`
--

CREATE TABLE `routers` (
  `cod_router` int(11) NOT NULL,
  `nom_router` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_router` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_router` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_router` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `puerto_router` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `puerto_graf` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blacklist_router` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_cre_router` timestamp NULL DEFAULT NULL,
  `company_cod_company` int(11) NOT NULL,
  `estatus_cod_est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `cod_sector` int(11) NOT NULL,
  `nom_sector` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`cod_sector`, `nom_sector`) VALUES
(1, 'San Antonio'),
(2, 'Ureña');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `segmentos_ip`
--

CREATE TABLE `segmentos_ip` (
  `cod_seg_ip` int(11) NOT NULL,
  `seg_ip` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_seg_ip` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_cod_company` int(11) NOT NULL,
  `routers_cod_router` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_instalacion`
--

CREATE TABLE `tipo_instalacion` (
  `cod_tipo_ins` int(11) NOT NULL,
  `nom_tipo_ins` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_instalacion`
--

INSERT INTO `tipo_instalacion` (`cod_tipo_ins`, `nom_tipo_ins`) VALUES
(1, 'Antena Del Cliente'),
(2, 'Red Cableada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usu` int(11) NOT NULL,
  `nom_usu` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ape_usu` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usu_user` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usu_pass` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_usu` timestamp NULL DEFAULT NULL,
  `tel_usu` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estatus_cod_est` int(11) NOT NULL,
  `company_cod_company` int(11) NOT NULL,
  `roles_cod_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usu`, `nom_usu`, `ape_usu`, `usu_user`, `usu_pass`, `fec_usu`, `tel_usu`, `estatus_cod_est`, `company_cod_company`, `roles_cod_rol`) VALUES
(1, 'Nicolay', 'Giraldo', 'nico', 'c4ca4238a0b923820dcc509a6f75849b', '2021-11-18 04:30:00', '4244543942', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_admin`
--

CREATE TABLE `usuario_admin` (
  `cod_usu_adm` int(11) NOT NULL,
  `usu_adm_user` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usu_adm_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estatus_cod_est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `act_mantenimientos`
--
ALTER TABLE `act_mantenimientos`
  ADD PRIMARY KEY (`cod_act_man`),
  ADD KEY `fk_act_mantenimientos_usuarios1_idx` (`usuarios_cod_usu`),
  ADD KEY `fk_act_mantenimientos_mantenimientos1_idx` (`mantenimientos_cod_man`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cli`),
  ADD UNIQUE KEY `ced_cli_UNIQUE` (`ced_cli`),
  ADD KEY `fk_clientes_estatus_clientes1_idx` (`estatus_clientes_cod_est_cli`),
  ADD KEY `fk_clientes_sector1_idx` (`sector_cod_sector`),
  ADD KEY `fk_clientes_company1_idx` (`company_cod_company`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`cod_company`),
  ADD KEY `fk_company_estatus_idx` (`estatus_cod_est`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`cod_contratos`),
  ADD KEY `fk_contratos_clientes1_idx` (`clientes_cod_cli`),
  ADD KEY `fk_contratos_company1_idx` (`company_cod_company`),
  ADD KEY `fk_contratos_routers1_idx` (`routers_cod_router`),
  ADD KEY `fk_contratos_fecha_corte1_idx` (`fecha_corte_cod_fec_corte`),
  ADD KEY `fk_contratos_tipo_instalacion1_idx` (`tipo_instalacion_cod_tipo_ins`),
  ADD KEY `fk_contratos_usuarios1_idx` (`usuarios_cod_usu`);

--
-- Indices de la tabla `detalles_contratos`
--
ALTER TABLE `detalles_contratos`
  ADD PRIMARY KEY (`cod_det_con`),
  ADD KEY `fk_detalles_contratos_contratos1_idx` (`contratos_cod_contratos`),
  ADD KEY `fk_detalles_contratos_ips1_idx` (`ips_cod_ip`),
  ADD KEY `fk_detalles_contratos_planes1_idx` (`planes_cod_plan`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`cod_est`);

--
-- Indices de la tabla `estatus_clientes`
--
ALTER TABLE `estatus_clientes`
  ADD PRIMARY KEY (`cod_est_cli`);

--
-- Indices de la tabla `estatus_contable`
--
ALTER TABLE `estatus_contable`
  ADD PRIMARY KEY (`cod_est_con`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`cod_fac`),
  ADD KEY `fk_factura_estatus_contable1_idx` (`estatus_contable_cod_est_con`),
  ADD KEY `fk_factura_fecha_corte1_idx` (`fecha_corte_cod_fec_corte`),
  ADD KEY `fk_factura_usuarios1_idx` (`usuarios_cod_usu`),
  ADD KEY `fk_factura_company1_idx` (`company_cod_company`),
  ADD KEY `fk_factura_contratos1_idx` (`contratos_cod_contratos`),
  ADD KEY `fk_factura_planes1_idx` (`planes_cod_plan`);

--
-- Indices de la tabla `fallas`
--
ALTER TABLE `fallas`
  ADD PRIMARY KEY (`cod_fallas`);

--
-- Indices de la tabla `fecha_corte`
--
ALTER TABLE `fecha_corte`
  ADD PRIMARY KEY (`cod_fec_corte`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`cod_for_pag`);

--
-- Indices de la tabla `grupo_menu`
--
ALTER TABLE `grupo_menu`
  ADD PRIMARY KEY (`cod_gru_men`);

--
-- Indices de la tabla `ips`
--
ALTER TABLE `ips`
  ADD PRIMARY KEY (`cod_ip`),
  ADD KEY `fk_ips_company1_idx` (`company_cod_company`),
  ADD KEY `fk_ips_segmentos_ip1_idx` (`segmentos_ip_cod_seg_ip`),
  ADD KEY `fk_ips_estatus1_idx` (`estatus_cod_est`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`cod_man`),
  ADD KEY `fk_mantenimientos_estatus1_idx` (`estatus_cod_est`),
  ADD KEY `fk_mantenimientos_usuarios1_idx` (`usuarios_cod_usu`),
  ADD KEY `fk_mantenimientos_fallas1_idx` (`fallas_cod_fallas`),
  ADD KEY `fk_mantenimientos_contratos1_idx` (`contratos_cod_contratos`),
  ADD KEY `fk_mantenimientos_company1_idx` (`company_cod_company`);

--
-- Indices de la tabla `menu_link`
--
ALTER TABLE `menu_link`
  ADD PRIMARY KEY (`cod_men_link`),
  ADD KEY `fk_menu_link_grupo_menu1_idx` (`grupo_menu_cod_gru_men`);

--
-- Indices de la tabla `pago_factura`
--
ALTER TABLE `pago_factura`
  ADD PRIMARY KEY (`cod_pag_fac`),
  ADD KEY `fk_pago_factura_factura1_idx` (`factura_cod_fac`),
  ADD KEY `fk_pago_factura_forma_pago1_idx` (`forma_pago_cod_for_pag`),
  ADD KEY `fk_pago_factura_company1_idx` (`company_cod_company`),
  ADD KEY `fk_pago_factura_usuarios1_idx` (`usuarios_cod_usu`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`cod_plan`),
  ADD KEY `fk_planes_estatus1_idx` (`estatus_cod_est`),
  ADD KEY `fk_planes_company1_idx` (`company_cod_company`);

--
-- Indices de la tabla `puertos_red`
--
ALTER TABLE `puertos_red`
  ADD PRIMARY KEY (`cod_puerto_red`),
  ADD KEY `fk_puertos_red_routers1_idx` (`routers_cod_router`),
  ADD KEY `fk_puertos_red_company1_idx` (`company_cod_company`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`cod_rol`);

--
-- Indices de la tabla `routers`
--
ALTER TABLE `routers`
  ADD PRIMARY KEY (`cod_router`),
  ADD KEY `fk_routers_company1_idx` (`company_cod_company`),
  ADD KEY `fk_routers_estatus1_idx` (`estatus_cod_est`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`cod_sector`);

--
-- Indices de la tabla `segmentos_ip`
--
ALTER TABLE `segmentos_ip`
  ADD PRIMARY KEY (`cod_seg_ip`),
  ADD KEY `fk_segmentos_ip_company1_idx` (`company_cod_company`),
  ADD KEY `fk_segmentos_ip_routers1_idx` (`routers_cod_router`);

--
-- Indices de la tabla `tipo_instalacion`
--
ALTER TABLE `tipo_instalacion`
  ADD PRIMARY KEY (`cod_tipo_ins`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usu`),
  ADD KEY `fk_usuarios_estatus1_idx` (`estatus_cod_est`),
  ADD KEY `fk_usuarios_company1_idx` (`company_cod_company`),
  ADD KEY `fk_usuarios_roles1_idx` (`roles_cod_rol`);

--
-- Indices de la tabla `usuario_admin`
--
ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`cod_usu_adm`),
  ADD KEY `fk_usuario_admin_estatus1_idx` (`estatus_cod_est`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `act_mantenimientos`
--
ALTER TABLE `act_mantenimientos`
  MODIFY `cod_act_man` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cod_cli` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `cod_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `cod_contratos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_contratos`
--
ALTER TABLE `detalles_contratos`
  MODIFY `cod_det_con` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `cod_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estatus_clientes`
--
ALTER TABLE `estatus_clientes`
  MODIFY `cod_est_cli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estatus_contable`
--
ALTER TABLE `estatus_contable`
  MODIFY `cod_est_con` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `cod_fac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fallas`
--
ALTER TABLE `fallas`
  MODIFY `cod_fallas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fecha_corte`
--
ALTER TABLE `fecha_corte`
  MODIFY `cod_fec_corte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  MODIFY `cod_for_pag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupo_menu`
--
ALTER TABLE `grupo_menu`
  MODIFY `cod_gru_men` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ips`
--
ALTER TABLE `ips`
  MODIFY `cod_ip` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `cod_man` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu_link`
--
ALTER TABLE `menu_link`
  MODIFY `cod_men_link` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pago_factura`
--
ALTER TABLE `pago_factura`
  MODIFY `cod_pag_fac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `cod_plan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puertos_red`
--
ALTER TABLE `puertos_red`
  MODIFY `cod_puerto_red` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `cod_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `routers`
--
ALTER TABLE `routers`
  MODIFY `cod_router` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `cod_sector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `segmentos_ip`
--
ALTER TABLE `segmentos_ip`
  MODIFY `cod_seg_ip` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_instalacion`
--
ALTER TABLE `tipo_instalacion`
  MODIFY `cod_tipo_ins` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario_admin`
--
ALTER TABLE `usuario_admin`
  MODIFY `cod_usu_adm` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `act_mantenimientos`
--
ALTER TABLE `act_mantenimientos`
  ADD CONSTRAINT `fk_act_mantenimientos_mantenimientos1` FOREIGN KEY (`mantenimientos_cod_man`) REFERENCES `mantenimientos` (`cod_man`),
  ADD CONSTRAINT `fk_act_mantenimientos_usuarios1` FOREIGN KEY (`usuarios_cod_usu`) REFERENCES `usuarios` (`cod_usu`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_clientes_estatus_clientes1` FOREIGN KEY (`estatus_clientes_cod_est_cli`) REFERENCES `estatus_clientes` (`cod_est_cli`),
  ADD CONSTRAINT `fk_clientes_sector1` FOREIGN KEY (`sector_cod_sector`) REFERENCES `sector` (`cod_sector`);

--
-- Filtros para la tabla `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_estatus` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`);

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `fk_contratos_clientes1` FOREIGN KEY (`clientes_cod_cli`) REFERENCES `clientes` (`cod_cli`),
  ADD CONSTRAINT `fk_contratos_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_contratos_fecha_corte1` FOREIGN KEY (`fecha_corte_cod_fec_corte`) REFERENCES `fecha_corte` (`cod_fec_corte`),
  ADD CONSTRAINT `fk_contratos_routers1` FOREIGN KEY (`routers_cod_router`) REFERENCES `routers` (`cod_router`),
  ADD CONSTRAINT `fk_contratos_tipo_instalacion1` FOREIGN KEY (`tipo_instalacion_cod_tipo_ins`) REFERENCES `tipo_instalacion` (`cod_tipo_ins`),
  ADD CONSTRAINT `fk_contratos_usuarios1` FOREIGN KEY (`usuarios_cod_usu`) REFERENCES `usuarios` (`cod_usu`);

--
-- Filtros para la tabla `detalles_contratos`
--
ALTER TABLE `detalles_contratos`
  ADD CONSTRAINT `fk_detalles_contratos_contratos1` FOREIGN KEY (`contratos_cod_contratos`) REFERENCES `contratos` (`cod_contratos`),
  ADD CONSTRAINT `fk_detalles_contratos_ips1` FOREIGN KEY (`ips_cod_ip`) REFERENCES `ips` (`cod_ip`),
  ADD CONSTRAINT `fk_detalles_contratos_planes1` FOREIGN KEY (`planes_cod_plan`) REFERENCES `planes` (`cod_plan`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_factura_contratos1` FOREIGN KEY (`contratos_cod_contratos`) REFERENCES `contratos` (`cod_contratos`),
  ADD CONSTRAINT `fk_factura_estatus_contable1` FOREIGN KEY (`estatus_contable_cod_est_con`) REFERENCES `estatus_contable` (`cod_est_con`),
  ADD CONSTRAINT `fk_factura_fecha_corte1` FOREIGN KEY (`fecha_corte_cod_fec_corte`) REFERENCES `fecha_corte` (`cod_fec_corte`),
  ADD CONSTRAINT `fk_factura_planes1` FOREIGN KEY (`planes_cod_plan`) REFERENCES `planes` (`cod_plan`),
  ADD CONSTRAINT `fk_factura_usuarios1` FOREIGN KEY (`usuarios_cod_usu`) REFERENCES `usuarios` (`cod_usu`);

--
-- Filtros para la tabla `ips`
--
ALTER TABLE `ips`
  ADD CONSTRAINT `fk_ips_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_ips_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`),
  ADD CONSTRAINT `fk_ips_segmentos_ip1` FOREIGN KEY (`segmentos_ip_cod_seg_ip`) REFERENCES `segmentos_ip` (`cod_seg_ip`);

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `fk_mantenimientos_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_mantenimientos_contratos1` FOREIGN KEY (`contratos_cod_contratos`) REFERENCES `contratos` (`cod_contratos`),
  ADD CONSTRAINT `fk_mantenimientos_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`),
  ADD CONSTRAINT `fk_mantenimientos_fallas1` FOREIGN KEY (`fallas_cod_fallas`) REFERENCES `fallas` (`cod_fallas`),
  ADD CONSTRAINT `fk_mantenimientos_usuarios1` FOREIGN KEY (`usuarios_cod_usu`) REFERENCES `usuarios` (`cod_usu`);

--
-- Filtros para la tabla `menu_link`
--
ALTER TABLE `menu_link`
  ADD CONSTRAINT `fk_menu_link_grupo_menu1` FOREIGN KEY (`grupo_menu_cod_gru_men`) REFERENCES `grupo_menu` (`cod_gru_men`);

--
-- Filtros para la tabla `pago_factura`
--
ALTER TABLE `pago_factura`
  ADD CONSTRAINT `fk_pago_factura_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_pago_factura_factura1` FOREIGN KEY (`factura_cod_fac`) REFERENCES `factura` (`cod_fac`),
  ADD CONSTRAINT `fk_pago_factura_forma_pago1` FOREIGN KEY (`forma_pago_cod_for_pag`) REFERENCES `forma_pago` (`cod_for_pag`),
  ADD CONSTRAINT `fk_pago_factura_usuarios1` FOREIGN KEY (`usuarios_cod_usu`) REFERENCES `usuarios` (`cod_usu`);

--
-- Filtros para la tabla `planes`
--
ALTER TABLE `planes`
  ADD CONSTRAINT `fk_planes_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_planes_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`);

--
-- Filtros para la tabla `puertos_red`
--
ALTER TABLE `puertos_red`
  ADD CONSTRAINT `fk_puertos_red_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_puertos_red_routers1` FOREIGN KEY (`routers_cod_router`) REFERENCES `routers` (`cod_router`);

--
-- Filtros para la tabla `routers`
--
ALTER TABLE `routers`
  ADD CONSTRAINT `fk_routers_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_routers_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`);

--
-- Filtros para la tabla `segmentos_ip`
--
ALTER TABLE `segmentos_ip`
  ADD CONSTRAINT `fk_segmentos_ip_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_segmentos_ip_routers1` FOREIGN KEY (`routers_cod_router`) REFERENCES `routers` (`cod_router`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_company1` FOREIGN KEY (`company_cod_company`) REFERENCES `company` (`cod_company`),
  ADD CONSTRAINT `fk_usuarios_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`),
  ADD CONSTRAINT `fk_usuarios_roles1` FOREIGN KEY (`roles_cod_rol`) REFERENCES `roles` (`cod_rol`);

--
-- Filtros para la tabla `usuario_admin`
--
ALTER TABLE `usuario_admin`
  ADD CONSTRAINT `fk_usuario_admin_estatus1` FOREIGN KEY (`estatus_cod_est`) REFERENCES `estatus` (`cod_est`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

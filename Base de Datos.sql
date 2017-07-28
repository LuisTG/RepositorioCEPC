-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2017 a las 01:56:14
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cepcrep`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Programación Dinámica'),
(2, 'Ad-Hoc'),
(3, 'Búsqueda'),
(4, 'Ordenamiento'),
(5, 'Teoría de Números'),
(6, 'Teoría de Grafos'),
(7, 'Procesamiento de Cadenas'),
(8, 'Estructuras de Datos'),
(9, 'Geometría Computacional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('habilitado','deshabilitado') DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `id_post`, `content`, `created_date`, `status`) VALUES
(1, 4, 15, 'hola', '2017-05-28 07:05:21', 'habilitado'),
(18, 4, 15, 'ff4wefdvg4ev', '2017-05-30 05:05:33', 'habilitado'),
(19, 4, 15, 'ff4wefdvg4ev', '2017-05-30 05:05:18', 'habilitado'),
(20, 4, 15, 'ff4wefdvg4ev', '2017-05-30 05:05:51', 'habilitado'),
(21, 4, 16, 'sdlfpcmcpmaqñlfmñkdmkmcxczx', '2017-05-30 05:05:49', 'habilitado'),
(22, 4, 16, 'sdlfpcmcpmaqñlfmñkdmkmcxczx', '2017-05-30 05:05:05', 'habilitado'),
(23, 4, 15, 'jhjasasjnasjjdjncjdncjvnvjnfcdfd', '2017-05-30 05:05:28', 'habilitado'),
(24, 4, 34, 'jnasdkjbkasjbxkjabsdx', '2017-05-31 01:50:49', 'habilitado'),
(25, 4, 33, 'Buen post', '2017-05-31 02:12:47', 'habilitado'),
(26, 4, 37, 'Muy buen Post', '2017-05-31 03:01:25', 'habilitado'),
(27, 8, 37, 'interesante imagen ', '2017-05-31 04:10:33', 'habilitado'),
(28, 9, 37, 'Baia Baia :v', '2017-05-31 04:15:10', 'habilitado'),
(29, 9, 38, 'Este post es popo >:v', '2017-05-31 04:30:27', 'habilitado'),
(30, 4, 42, 'prueba', '2017-06-03 07:57:45', 'deshabilitado'),
(31, 4, 42, 'Hola hola', '2017-06-03 08:25:47', 'deshabilitado'),
(32, 4, 42, 'Hola de nuevo :)', '2017-06-03 08:29:05', 'deshabilitado'),
(33, 4, 42, 'hola\r\n', '2017-06-03 08:58:23', 'deshabilitado'),
(34, 4, 42, 'hola', '2017-06-03 09:17:48', 'deshabilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1495249182),
('m130524_201442_init', 1495249185);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `problem_name` varchar(100) NOT NULL,
  `problem_link` varchar(255) NOT NULL,
  `status` enum('habilitado','deshabilidato') DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `created_date`, `id_user`, `problem_name`, `problem_link`, `status`) VALUES
(37, 'MST problem', '<p>Para este problema se deje ejecutar el algortimo.</p><ul><li>Teoria de grafos</li><li>Ordenamiento</li><li>Estructura de datos</li></ul><p style="text-align: center;"><img src="/cepcrep/backend/web/uploads/4/eb6bdd281d-diagrama-conectividad-nuevo.jpg" style="width: 493px; height: 503px;" width="493" height="503"></p>', '2017-05-31 03:01:11', 4, 'Longest Path', 'https://uva.onlinejudge.org/external/101/10100.pdf', 'habilitado'),
(38, 'Testing ', '<p><a href="/cepcrep/backend/web/uploads/8/b7aee80335-practica9.pl">b7aee80335-practica9.pl</a><br></p>', '2017-05-31 04:28:53', 8, 'idk', 'https://es.wikipedia.org/wiki/Geometr%C3%ADa_computacional', 'habilitado'),
(39, 'Esta es una prueba', '<p style="margin-left: 40px;">Probando</p>', '2017-06-01 07:41:04', 4, 'prueba', 'Probando', 'habilitado'),
(40, 'Esta es otra prueba', '<p style="margin-left: 20px;">Estamos probando</p>', '2017-06-01 07:41:39', 4, 'prueba', 'pruebando', 'habilitado'),
(41, 'La ultima prueba', '<p style="margin-left: 20px;">Probando</p>', '2017-06-01 07:42:08', 4, 'Pruebando', 'PROBADOR', ''),
(42, 'adkonjadnx', '<p style="margin-left: 20px;">knclndnsnadskjnaskxc</p>', '2017-06-02 12:30:56', 4, 'dalksndc', 'dklnx', 'habilitado'),
(46, 'dalkdn', '<p>fslfn</p>', '2017-06-04 12:19:19', 4, 'slfn', 'sfkmsklf', 'habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postcategoria`
--

CREATE TABLE `postcategoria` (
  `id` int(100) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `postcategoria`
--

INSERT INTO `postcategoria` (`id`, `id_post`, `id_categoria`) VALUES
(9, 37, 6),
(10, 37, 8),
(11, 37, 4),
(12, 37, 3),
(13, 38, 9),
(14, 39, 1),
(15, 40, 1),
(16, 41, 7),
(29, 46, 9),
(75, 42, 3),
(76, 42, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img_profile` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'uploads/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `name`, `last_name`, `img_profile`) VALUES
(1, 'Luis', 'vQyPpYSU9TQ1wPfbiBPZSyqKJb6USljx', '$2y$13$N7AOW94F17.2mIxO4BMyBOcRXZruvjsWV5c.LqCDE8DO6P0tq4Dwu', NULL, 'siullegna@hotmail.com', 10, 1495250354, 1495250354, '', '', 'uploads/default.jpg'),
(2, 'Juan', 'PG8HBENdKaBpKAqpJtitHi328Jn99Nmw', '$2y$13$1TjHxI52/0.DR9yppU6v5.iELiQKiWHHORzR5oYCUiM5XJ3oppwV6', NULL, 'juan@gmail.com', 10, 1495253055, 1495253055, '', '', 'uploads/default.jpg'),
(3, 'yola', 'i2SUl2hkRXecpahQU2lrZRmJWztyZVXu', '$2y$13$EF1NPZEUwzHz6sGyAWnTr.e/pkoD2VvrcmgYN9nvlSZvqDuJ8DuDe', NULL, 'yola@gmail.com', 10, 1495302715, 1495302715, 'Yolanda', 'Garcia', 'uploads/default.jpg'),
(4, 'pedro', 'L4MSZk5Nxz2z2fIJERq20UF071pSchZZ', '$2y$13$UAhDxTun5SPE4S6NTil/q.sex4fJI49ZQf4f9R4yg8N9n0xZbL7Oa', NULL, 'pedro@gmail.com', 10, 1495307938, 1496516236, 'Pedro', 'Trujillo', 'uploads/pedro.jpg'),
(5, 'LoxFalcon', 'NLjz3fKTE7ETGR6i0s_1bNOMy7f_vNfd', '$2y$13$BaH5j8/svtFrtoPyDvWP/.8XXw.kp1w6lXWUZ7e6bqOA/TqLX8.By', NULL, 'loxfalcon@gmail.com', 10, 1495310123, 1495310123, 'Luis', 'Noriega', 'uploads/default.jpg'),
(6, 'BraveCarePicha', 'UAtNAQmbqgvHtBhcnGD_NrORUVRALpHB', '$2y$13$LEaGOdLwWGshOCxbM9E.KeMwldpYHZ6QEbXCzCSBF7JDQSjjMGYDi', NULL, 'diana@gmail.com', 10, 1495484258, 1495484258, 'Diana', 'Bravo', 'uploads/BraveCarePicha.png'),
(7, 'dnskjadsn', 'is-fdGF4xaPNnlNeg-bP2qN_aYNnD2D8', '$2y$13$ZU8yQFayFUPBnlx8Db96furiopMBL2sLIT4KAeMTML0bh0dOkvCD.', NULL, 'luis_milaus@hotmail.com', 10, 1495694708, 1495694708, 'sdadsnjnda', 'kdnkadn', 'uploads/dnskjadsn.jpg'),
(8, 'brave', 'bV90PuMFPVQ1UZZPQP7BsdjTDQ5IKJnd', '$2y$13$6qAeZoHybtUrS6dkttqTOeBRFv405RSc.we2vLUGGPYtmA4HU4te.', NULL, 'brave@gmail.com', 10, 1496196565, 1496196565, 'Diana Laura', 'Bravo', 'uploads/brave.png'),
(9, 'Artm94', 'vckUPcI1hwQi7HPEcKNEUDdqsjbT9u_l', '$2y$13$LHAATLifokP15RiqFvmP.uHfNQC6MyenDka2gM40lRdL8Rw00qQAm', NULL, 'artm94@hotmail.com', 10, 1496196700, 1496196700, 'Arturo', 'Martinez', 'uploads/default.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `postcategoria`
--
ALTER TABLE `postcategoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT de la tabla `postcategoria`
--
ALTER TABLE `postcategoria`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `postcategoria`
--
ALTER TABLE `postcategoria`
  ADD CONSTRAINT `postcategoria_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `postcategoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

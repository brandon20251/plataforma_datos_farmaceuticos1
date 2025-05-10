-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-05-2025 a las 04:26:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmaceutica_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribucion`
--

CREATE TABLE `distribucion` (
  `id` int(11) NOT NULL,
  `id_medicamento` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `distribucion`
--

INSERT INTO `distribucion` (`id`, `id_medicamento`, `id_proveedor`, `cantidad`, `fecha_entrega`) VALUES
(3, 3, 3, 150, '2025-05-10'),
(4, 4, 4, 120, '2025-05-04'),
(7, 1, 3, 100, '1990-12-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(255) NOT NULL,
  `nombre_generico` varchar(255) NOT NULL,
  `principio_activo` varchar(255) NOT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `presentacion` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `nombre_comercial`, `nombre_generico`, `principio_activo`, `dosis`, `presentacion`, `fecha_registro`) VALUES
(1, 'Paracetamol', 'Paracetamol', 'Paracetamol', '50mg', 'Tabletas', '2025-05-10 00:42:07'),
(3, 'Ibuprofeno', 'Ibuprofeno', 'Ibuprofeno', '400mg', 'Cápsulas', '2025-05-10 00:42:07'),
(4, 'Amoxicilina', 'Amoxicilina', 'Amoxicilina', '500mg', 'Cápsulas', '2025-05-10 00:42:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre_proveedor`, `direccion`, `telefono`, `correo`, `fecha_registro`) VALUES
(3, 'Distribuidora 123', 'Avenida El Dorado #100-200, Bogotá', '3023456789', 'ventas@distribuidora123.com', '2025-05-10 00:42:31'),
(4, 'Proveeduría Nacional', 'Calle 7 #32-45, Cali', '3155678901', 'proveedores@proveedurias.com', '2025-05-10 00:42:31'),
(5, 'MediPharma', 'Calle 13 #45-67, Barranquilla', '3188765432', 'ventas@medipharmacol.com', '2025-05-10 00:42:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reguladores`
--

CREATE TABLE `reguladores` (
  `id` int(11) NOT NULL,
  `entidad` varchar(255) DEFAULT NULL,
  `informe_fecha` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reguladores`
--

INSERT INTO `reguladores` (`id`, `entidad`, `informe_fecha`, `descripcion`, `fecha_registro`) VALUES
(1, 'INVIMA', '2025-04-01', 'Informe sobre la autorización de nuevos medicamentos en el mercado.', '2025-05-10 00:42:55'),
(2, 'SIC', '2025-04-02', 'Informe sobre las condiciones de venta y distribución de medicamentos genéricos.', '2025-05-10 00:42:55'),
(3, 'Ministerio de Salud', '2025-04-03', 'Informe sobre la regulación de precios de medicamentos esenciales.', '2025-05-10 00:42:55'),
(4, 'INVIMA', '2025-04-04', 'Informe sobre la inspección de calidad de productos farmacéuticos.', '2025-05-10 00:42:55'),
(5, 'SIC', '2025-04-05', 'Informe sobre las sanciones a laboratorios por prácticas comerciales desleales.', '2025-05-10 00:42:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasena`, `fecha_registro`) VALUES
(1, 'brandon', '81dc9bdb52d04dc20036dbd8313ed055', '2025-05-10 00:23:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `distribucion`
--
ALTER TABLE `distribucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distribucion_ibfk_1` (`id_medicamento`),
  ADD KEY `fk_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reguladores`
--
ALTER TABLE `reguladores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `distribucion`
--
ALTER TABLE `distribucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reguladores`
--
ALTER TABLE `reguladores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `distribucion`
--
ALTER TABLE `distribucion`
  ADD CONSTRAINT `distribucion_ibfk_1` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `distribucion_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

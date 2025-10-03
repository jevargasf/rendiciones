CREATE TABLE `acciones` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `fecha` datetime NOT NULL,
  `comentario` text DEFAULT NULL,
  `estado_rendicion` varchar(20) DEFAULT NULL,
  `km_rut` varchar(10) DEFAULT NULL,
  `km_nombre` varchar(50) DEFAULT NULL,
  `rendicion_id` int(10) UNSIGNED NOT NULL,
  `persona_id` int(10) UNSIGNED DEFAULT NULL,
  `cargo_id` int(10) UNSIGNED DEFAULT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cargos` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cargos` (`nombre`, `estado`) VALUES
('Presidente', 1),
('Tesorero(a)', 1),
('Secretario(a)', 1),
('Director', 1);

CREATE TABLE `estados_rendiciones` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `estados_rendiciones` (`nombre`, `estado`) VALUES
('Recepcionada', 1),
('En Revisión', 1),
('Observada', 1),
('Rechazada', 1),
('Aprobada', 1);

CREATE TABLE `notificaciones` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `destinatario` varchar(50) DEFAULT NULL,
  `email_id` int DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_lectura` datetime DEFAULT NULL,
  `estado_notificacion` tinyint(1) NOT NULL DEFAULT 0,
  `accion_id` int(10) UNSIGNED NOT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `rut` varchar(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rendiciones` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `subvencion_id` int(10) UNSIGNED NOT NULL UNIQUE,
  `estado_rendicion_id` int(10) UNSIGNED NOT NULL,
  `estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `subvenciones` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `decreto` varchar(20) NOT NULL,
  `fecha_decreto` date NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `destino` varchar(200) NOT NULL,
  `rut` varchar(10) NOT NULL,
  `estado` int(10) NOT NULL,
  `motivo_eliminacion` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `acciones` ADD CONSTRAINT `fk_accion_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`);
ALTER TABLE `acciones` ADD CONSTRAINT `fk_accion_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);
ALTER TABLE `acciones` ADD CONSTRAINT `fk_accion_rendicion` FOREIGN KEY (`rendicion_id`) REFERENCES `rendiciones` (`id`);

ALTER TABLE `notificaciones`ADD CONSTRAINT `fk_notificacion_accion` FOREIGN KEY (`accion_id`) REFERENCES `acciones` (`id`);

ALTER TABLE `rendiciones` ADD CONSTRAINT `fk_rendicion_estado` FOREIGN KEY (`estado_rendicion_id`) REFERENCES `estados_rendiciones` (`id`);
ALTER TABLE `rendiciones` ADD CONSTRAINT `fk_rendicion_subvencion` FOREIGN KEY (`subvencion_id`) REFERENCES `subvenciones` (`id`);
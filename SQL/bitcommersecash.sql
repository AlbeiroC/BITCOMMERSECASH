-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.33-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5263
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para bitcomme_principal
CREATE DATABASE IF NOT EXISTS `bitcomme_principal` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bitcomme_principal`;

-- Volcando estructura para tabla bitcomme_principal.categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorias` varchar(5000) NOT NULL DEFAULT '0',
  `icon` varchar(5000) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.comentarios
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `comentario` varchar(1000) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.egresos
DROP TABLE IF EXISTS `egresos`;
CREATE TABLE IF NOT EXISTS `egresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `monto` varchar(500) NOT NULL DEFAULT '0',
  `concepto` varchar(500) NOT NULL DEFAULT 'recarga',
  `metodo` varchar(500) NOT NULL DEFAULT 'custom',
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_about
DROP TABLE IF EXISTS `empresa_about`;
CREATE TABLE IF NOT EXISTS `empresa_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `about` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_email
DROP TABLE IF EXISTS `empresa_email`;
CREATE TABLE IF NOT EXISTS `empresa_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_facebook
DROP TABLE IF EXISTS `empresa_facebook`;
CREATE TABLE IF NOT EXISTS `empresa_facebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `facebook` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_imagen
DROP TABLE IF EXISTS `empresa_imagen`;
CREATE TABLE IF NOT EXISTS `empresa_imagen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `imagen` varchar(500) NOT NULL DEFAULT '0',
  `status` varchar(500) NOT NULL DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_instagram
DROP TABLE IF EXISTS `empresa_instagram`;
CREATE TABLE IF NOT EXISTS `empresa_instagram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `instagram` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_nombre
DROP TABLE IF EXISTS `empresa_nombre`;
CREATE TABLE IF NOT EXISTS `empresa_nombre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `nombre` varchar(500) NOT NULL DEFAULT '0',
  `status` varchar(500) NOT NULL DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_password
DROP TABLE IF EXISTS `empresa_password`;
CREATE TABLE IF NOT EXISTS `empresa_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `password` varchar(500) NOT NULL DEFAULT '0',
  `status` varchar(500) NOT NULL DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_paypal
DROP TABLE IF EXISTS `empresa_paypal`;
CREATE TABLE IF NOT EXISTS `empresa_paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `paypal` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_twitter
DROP TABLE IF EXISTS `empresa_twitter`;
CREATE TABLE IF NOT EXISTS `empresa_twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `twitter` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_username
DROP TABLE IF EXISTS `empresa_username`;
CREATE TABLE IF NOT EXISTS `empresa_username` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `username` varchar(500) NOT NULL DEFAULT '0',
  `status` varchar(500) NOT NULL DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.empresa_wallet
DROP TABLE IF EXISTS `empresa_wallet`;
CREATE TABLE IF NOT EXISTS `empresa_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  `wallet` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT 'inactive',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.favoritos
DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `item` int(11) NOT NULL DEFAULT '0',
  `status` varchar(500) NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.history
DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `icon` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `code` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.imbox
DROP TABLE IF EXISTS `imbox`;
CREATE TABLE IF NOT EXISTS `imbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `para` varchar(500) NOT NULL DEFAULT '0',
  `mensaje` varchar(500) NOT NULL DEFAULT '0',
  `referencia` varchar(500) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `visto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.ingresos
DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `monto` varchar(500) NOT NULL DEFAULT '0',
  `concepto` varchar(500) NOT NULL DEFAULT 'recarga',
  `metodo` varchar(500) NOT NULL DEFAULT 'custom',
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.items_to_sell
DROP TABLE IF EXISTS `items_to_sell`;
CREATE TABLE IF NOT EXISTS `items_to_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_` varchar(500) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `tmp_user` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(500) NOT NULL DEFAULT '0',
  `descripcion` varchar(500) NOT NULL DEFAULT '0',
  `categoria` varchar(500) NOT NULL DEFAULT 'tecnologia',
  `stock` varchar(500) NOT NULL DEFAULT '1',
  `currency` varchar(500) NOT NULL DEFAULT '0',
  `precio_usd` varchar(500) NOT NULL DEFAULT '0',
  `precio_btc` varchar(500) NOT NULL DEFAULT '0',
  `destination` varchar(500) NOT NULL DEFAULT 'national,international',
  `payment` varchar(500) NOT NULL DEFAULT 'paypal,bank,btc',
  `imagenes` varchar(50000) NOT NULL,
  `trash` varchar(500) NOT NULL DEFAULT 'false',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.orden_de_compras
DROP TABLE IF EXISTS `orden_de_compras`;
CREATE TABLE IF NOT EXISTS `orden_de_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `precio_usd` int(11) NOT NULL DEFAULT '0',
  `precio_btc` varchar(50) NOT NULL DEFAULT '0',
  `wallet` varchar(50) NOT NULL DEFAULT '0',
  `status` varchar(160) NOT NULL DEFAULT 'pending',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.paises
DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` varchar(500) NOT NULL DEFAULT '0',
  `pais_en` varchar(500) NOT NULL DEFAULT '0',
  `iso2` varchar(500) NOT NULL DEFAULT '0',
  `iso3` varchar(500) NOT NULL DEFAULT '0',
  `nombre_moneda` varchar(500) NOT NULL DEFAULT '0',
  `simbolo_moneda` varchar(500) NOT NULL DEFAULT '0',
  `moneda` varchar(500) NOT NULL DEFAULT '0',
  `bandera` varchar(500) NOT NULL DEFAULT '0',
  `continente` varchar(500) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.tokens
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL,
  `token` varchar(500) NOT NULL DEFAULT 'false',
  `type` varchar(500) NOT NULL DEFAULT 'all',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referido` varchar(500) NOT NULL DEFAULT '1906',
  `status` varchar(500) NOT NULL DEFAULT 'inactive',
  `cedula` varchar(500) NOT NULL,
  `vip` int(11) NOT NULL DEFAULT '0',
  `comision` int(11) NOT NULL DEFAULT '2',
  `grants` varchar(500) NOT NULL DEFAULT 'max_item.upload.5,max_item.image.2,max_comments.20,fee.send.5,fee.transferencia.5,fee.withdraw.5',
  `admin` varchar(500) NOT NULL DEFAULT 'false',
  `webmail` varchar(500) NOT NULL,
  `plan` varchar(500) NOT NULL DEFAULT 'free',
  `username` varchar(500) NOT NULL,
  `nombre` varchar(500) NOT NULL DEFAULT 'Empresa Nueva',
  `about` varchar(500) NOT NULL DEFAULT 'Hey, ya estoy en BitCommerseCash.',
  `password` varchar(500) NOT NULL DEFAULT '1234567890',
  `email` varchar(500) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `pais` varchar(500) NOT NULL DEFAULT 'col',
  `divisa` varchar(500) NOT NULL DEFAULT 'cop',
  `facebook` varchar(500) NOT NULL,
  `instagram` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `paypal` varchar(500) NOT NULL,
  `wallet` varchar(500) NOT NULL,
  `btc_price` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1013646819 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla bitcomme_principal.wallets
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(500) NOT NULL DEFAULT '0',
  `direccion` varchar(500) NOT NULL DEFAULT '0',
  `api_key` varchar(500) NOT NULL DEFAULT '0',
  `balance` varchar(500) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

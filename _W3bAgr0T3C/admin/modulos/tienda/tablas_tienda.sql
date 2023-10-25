CREATE TABLE `tblti_carro` (
  `carro` int(11) NOT NULL auto_increment,
  `session_id` varchar(100) default NULL,
  `usuario` varchar(200) default NULL,
  `fecha` datetime default NULL,
  `estado` varchar(100) default 'CARRO',
  `nombre` varchar(255) default NULL,
  `direccion` varchar(255) default NULL,
  `telefono` varchar(100) default NULL,
  `ciudad` varchar(100) default NULL,
  `total_peso` decimal(12,2) default '0.00',
  `total_volumen` decimal(12,2) default '0.00',
  `total_flete` decimal(12,2) default '0.00',
  `destino_descripcion` varchar(255) default NULL,
  `destino_base` decimal(12,2) default '0.00',
  `destino_kilo` decimal(12,2) default '0.00',
  PRIMARY KEY  (`carro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


CREATE TABLE `tblti_carro_detalle` (
  `carro` int(11) NOT NULL,
  `detalle` int(11) NOT NULL auto_increment,
  `item` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio` decimal(12,2) default '0.00',
  `iva` int(11) default '0',
  `subtotal` decimal(12,2) default '0.00',
  `peso` decimal(12,2) default '0.00',
  `volumen` decimal(12,2) default '0.00',
  PRIMARY KEY  (`detalle`),
  UNIQUE KEY `carro` (`carro`,`item`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



CREATE TABLE `tblti_categorias` (
  `idciudad` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL auto_increment,
  `idcategoria_superior` int(11) NOT NULL,
  `nombre` varchar(200) character set latin1 collate latin1_spanish_ci NOT NULL,
  `vpath` text NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY  (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;


CREATE TABLE `tblti_config` (
  `encabezado` text,
  `pie` text,
  `destinos` text,
  `paypal_email` varchar(255) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `tblti_productos` (
  `idciudad` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL auto_increment,
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(200) character set latin1 collate latin1_spanish_ci NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` decimal(12,2) default '0.00',
  `precioant` decimal(12,2) default '0.00',
  `imagen_1` varchar(255) default NULL,
  `imagen_2` varchar(255) default NULL,
  `imagen_3` varchar(255) default NULL,
  `imagen_4` varchar(255) default NULL,
  `activo` int(11) default '0',
  `promocion` int(11) default '0',
  `peso` decimal(12,2) default '0.00',
  `volumen` decimal(12,2) default '0.00',
  PRIMARY KEY  (`idproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


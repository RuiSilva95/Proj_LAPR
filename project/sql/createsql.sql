create database take;
use take;
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(9) NOT NULL,
  `private` int(1) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
LOCK TABLES `client` WRITE;
INSERT INTO `client` VALUES (1,'manel','rua dos ananas','rui_flexa@hotmail.com',921812821,0);
UNLOCK TABLES;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `status` int(1) NOT NULL,
  `data` mediumblob,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,'Rui','admin','$1$r1C0feSA$H3R.bZ53GoCA9oVCgaylN/','rmns95@gmail.com',1,NULL);
UNLOCK TABLES;

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `address` text,
  `email` text,
  `phone` int(9) NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
LOCK TABLES `service` WRITE;
INSERT INTO `service` VALUES (1,'rui','rua das couves','rasdasdas@hotmail.com',435435435);
UNLOCK TABLES;

DROP TABLE IF EXISTS `equipment_status`;
create table `equipment_status`(
  `id_equipment_status` int(11) not null auto_increment,
  `status` text,
  `start_date` text,
  `end_date` text,
  `work_hours` text,
  PRIMARY KEY(`id_equipment_status`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `equip_problem`;
create table `equip_problem`(
  `id_equipment_problem` int(11) not null auto_increment,
  `problem_damage` text,
  `description(client)` text,
  `description(employee)` text,
  `service_provided` text,
  `material_suplied` text,
  PRIMARY KEY(`id_equipment_problem`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `product`;
create table `product`(
  `id_product` int(11) not null auto_increment,
  `equipment` text,
  `mark_models` text,
  `nSeries` text,
  `acessories` text,
  PRIMARY KEY(`id_product`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `service_problem`;
create table `service_problem`(
  `id_service_problem` int(11) not null auto_increment,
  `id_service` int(11),
  `check` text,
  `budget` text,
  `configuration` text,
  `report_problem` text,
  `sending_date` text,
  `deliver_date` text,
  PRIMARY KEY(`id_service_problem`),
  CONSTRAINT `service_problem_ibfk_1` FOREIGN KEY(`id_service`) REFERENCES `service` (`id_service`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `external`;
create table `external`(
  `id_external` int(11) not null auto_increment,
  `id_client` int(11),
  `id_user` int(11),
  `id_equipment_status` int(11),
  `description` text,
  `service_provided` text,
  `budget` text,
  PRIMARY KEY(`id_external`),
  CONSTRAINT `external_ibfk_1` FOREIGN KEY(`id_equipment_status`) REFERENCES `equipment_status` (`id_equipment_status`) ON DELETE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `internal`;
create table `internal`(
  `id_internal` int(11) not null auto_increment,
  `id_client` int(11),
  `id_user` int(11),
  `id_equipment_status` int(11),
  `id_product` int(11),
  `id_equipment_problem` int(11),
  `id_service_problem` int(11),
  `budget` text,
  PRIMARY KEY(`id_internal`),
  CONSTRAINT `internal_ibfk_1` FOREIGN KEY(`id_equipment_status`) REFERENCES `equipment_status` (`id_equipment_status`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_2` FOREIGN KEY(`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_3` FOREIGN KEY(`id_equipment_problem`) REFERENCES `equip_problem` (`id_equipment_problem`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_4` FOREIGN KEY(`id_service_problem`) REFERENCES `service_problem` (`id_service_problem`) ON DELETE CASCADE
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

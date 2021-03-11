-- MySQL dump 10.17  Distrib 10.3.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.2.50    Database: portalesweb
-- ------------------------------------------------------
-- Server version	10.3.27-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `idmodulo` varchar(50) COLLATE utf8_bin NOT NULL,
  `modulo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT 0 COMMENT '1=PHP; 0=CONTENIDO',
  `mostrartitulo` int(11) NOT NULL DEFAULT 1,
  `contenido` text COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idmodulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES ('adminusuarios','Administración de Usuarios',1,1,NULL),('inicio','Mi Pagina de Inicio',0,1,'<p>Mi Propio Contenido</p>'),('otroModulo','Modulo de Prueba',0,1,'<p>Este es otro modulo de pruebas</p>'),('test','Pruebas de Programador',1,1,NULL);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuario` varchar(50) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `llave` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(128) COLLATE utf8_bin NOT NULL,
  `celular` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `superadministrador` smallint(6) NOT NULL DEFAULT 0,
  `activo` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuarios_UN` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('jisoriano','Josue Soriano','jisoriano2686@gmail.com','1986-06-26','730843a457ca6d3988f306eb271ee2f6a09316d00032c4164ef4ba552db89cd829f220cf78c45ee6e9d077a43bbbdb2c64058a1b911bacaa538a39b15f07af41','1bcedd82176dcb7267f1265129c6858939267245598a4816df87ebe896d0f9780c08ea486c91cf322f556754e47f6bb7bc9d28db56829f6eb04690b7f22398c3','33438063',0,1),('jisoriano26','Josue Soriano','jisoriano26@gmail.com','1986-06-26','5ff93de40a254b5bda3a6d06f95cfe941789ebaac371bdfc21d4affe55c04308695f760481b41a98ac00a190568731aba5ec70b41df13da0483e4a58cebafc13','e5351d0b3a1c600a1846252922c05bb873c5f73ec96c53c4bdd8e8cb4126f8dfcb4f344ac5d968a1dd777443546ec6725445b009c9b6ce28f238a75fb32e00a0','33438063',0,1),('jsoriano','Josue Soriano','jsoriano@unicah.edu','1986-06-26','s,djkbc','ljasndclsadkc','33438063',1,1),('master','Usuario Maestro','master@unicah.edu','1986-06-26','s,djkbc','ljasndclsadkc','33438063',1,1),('test','Usuario de Pruebas','testing@unicah.edu','1988-12-31','3793172c56a3e7436f76130285d10b5c98f6ff12d4947d5baeeb1f2f3a255fc750735b800072fdc26316194af413379f1585bb8c5f8cc610bb870d5911e71f77','389c8c3a4c80cd7ef20b0bbcde862d5808a03a4e97b7e45c839e887a969a5aa1073973094861ddb463d81917989b1a25ecd9d20ba2863044a58e90e41291cf0a','33333333',0,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-03 19:18:42

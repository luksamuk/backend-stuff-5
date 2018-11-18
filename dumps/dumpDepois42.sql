-- MySQL dump 10.16  Distrib 10.1.30-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: treinamento-backend
-- ------------------------------------------------------
-- Server version	10.1.32-MariaDB

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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `book_author` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `book_section_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `books_sections_FK` (`book_section_id`),
  CONSTRAINT `books_sections_FK` FOREIGN KEY (`book_section_id`) REFERENCES `sections` (`section_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Structure and Interpretation of Computer Programs','Abelson e Sussman',1),(2,'Land of Lisp','Conrad Barski, M.D.',1),(3,'Real Time Collision Detection','Christer Ericson',1),(4,'The Elements of Computing Systems','Nissan e Schocken',1),(5,'Godel, Escher, Bach','Douglas Hofstadter',2),(6,'I Am a Strange Loop','Douglas Hogstadter',2),(7,'Mente Zen, Mente de Principiante','Shunryu Suzuki',4);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrowings` (
  `borrowing_id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowing_datetime` datetime DEFAULT NULL,
  `borrowing_devolution` date DEFAULT NULL,
  `borrowing_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`borrowing_id`),
  KEY `borrowings_users_FK` (`borrowing_user_id`),
  CONSTRAINT `borrowings_users_FK` FOREIGN KEY (`borrowing_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
INSERT INTO `borrowings` VALUES (1,'2018-11-18 02:30:24','2018-11-18',1),(2,'2018-11-18 02:30:24','2018-11-18',1),(3,'2018-11-18 02:30:24','2018-11-18',2);
/*!40000 ALTER TABLE `borrowings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lendings`
--

DROP TABLE IF EXISTS `lendings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lendings` (
  `lending_book_id` int(11) DEFAULT NULL,
  `lending_borrowing_id` int(11) DEFAULT NULL,
  KEY `lendings_books_FK` (`lending_book_id`),
  KEY `lendings_borrowings_FK` (`lending_borrowing_id`),
  CONSTRAINT `lendings_books_FK` FOREIGN KEY (`lending_book_id`) REFERENCES `books` (`book_id`) ON UPDATE CASCADE,
  CONSTRAINT `lendings_borrowings_FK` FOREIGN KEY (`lending_borrowing_id`) REFERENCES `borrowings` (`borrowing_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lendings`
--

LOCK TABLES `lendings` WRITE;
/*!40000 ALTER TABLE `lendings` DISABLE KEYS */;
INSERT INTO `lendings` VALUES (1,1),(2,2),(4,3);
/*!40000 ALTER TABLE `lendings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `section_location` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'TI','Corredor 0'),(2,'Matemática','Corredor 1'),(3,'Biografias','Corredor 2'),(4,'Budismo','Corredor 3');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `user_address` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `user_phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Lucas','lucasvieira@lisp.com.br','Rua Alguma Coisa, 0','3812345678'),(2,'Fulano','fulano@exemplo.com','Rua Alguma Coisa, 1','3856781234'),(3,'Ciclano','ciclano@exemplo.com','Rua Alguma Coisa, 2','3805639672'),(4,'Beltrano','beltrano@exemplo.com','Rua Alguma Coisa, 3','38126746247');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'treinamento-backend'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-18  0:34:22

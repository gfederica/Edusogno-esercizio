
-- file db da importare

USE `edu_test`;

CREATE TABLE `eventi` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome_evento` varchar(100) NOT NULL,
  `descrizione_evento` text NOT NULL,
  `data` DATE,
  `ora` TIME
);
-- ALTER TABLE `eventi` ADD `link` varchar(100); viene popolato da quickstart.php


CREATE TABLE `utenti` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE
);


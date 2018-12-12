/**************************************
*
*  Script d'initialisation de la BDD
*
***************************************/

DROP DATABASE IF EXISTS todo;
CREATE DATABASE todo;
USE todo;

CREATE TABLE list(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	titre VARCHAR(255) NOT NULL, 
	description TEXT NOT NULL, 
	PRIMARY KEY(id)
);

CREATE USER IF NOT EXISTS 'todo'@'localhost' IDENTIFIED BY 'todopwd';
GRANT ALL PRIVILEGES ON todo TO 'todo'@'localhost';
FLUSH PRIVILEGES;


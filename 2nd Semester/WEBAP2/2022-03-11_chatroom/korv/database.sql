CREATE DATABASE IF NOT EXISTS php_project; -- remember to change this!
USE php_project; -- remember to change this!
CREATE TABLE messages (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    content varchar(255) NOT NULL,
    messagetime DATETIME,
    PRIMARY KEY (id)
);
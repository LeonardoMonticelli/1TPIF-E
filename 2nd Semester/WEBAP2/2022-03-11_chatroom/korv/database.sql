-- DROP DATABASE chatroom;
CREATE DATABASE chatroom;
USE chatroom;

CREATE TABLE messages (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    content varchar(255) NOT NULL,
    messagetime DATETIME,
    PRIMARY KEY (id)
);
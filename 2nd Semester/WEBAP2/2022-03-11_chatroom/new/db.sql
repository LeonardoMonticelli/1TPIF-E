DROP DATABASE IF EXISTS chat;
CREATE DATABASE chat;
use chat;

CREATE TABLE messages (
    msgID int NOT NULL AUTO_INCREMENT,
    msgUser varchar(255) NOT NULL,
    msgText varchar(255) NOT NULL,
    msgTime DATETIME,
    PRIMARY KEY (msgID)
);
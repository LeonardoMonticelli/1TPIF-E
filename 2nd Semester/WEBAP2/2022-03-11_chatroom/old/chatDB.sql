DROP DATABASE IF EXISTS chat;
CREATE DATABASE chat;
use chat;

create table messages(
    msgID int not null auto_increment,
    msgTime datetime,
    username varchar(50) not null,
    msgText varchar(255) not null,
    fromUser int not null,
    primary key (msgID)
);
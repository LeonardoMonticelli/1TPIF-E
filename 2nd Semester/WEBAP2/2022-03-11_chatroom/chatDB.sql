DROP DATABASE IF EXISTS chat;
CREATE DATABASE chat;
use chat;

create table messages(
    msgID int not null auto_increment,
    msgTime time,
    msgText varchar(100),
    fromUser int not null,
    primary key (msgID)
)
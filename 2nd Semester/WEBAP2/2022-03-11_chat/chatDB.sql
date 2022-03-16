drop database chat;
create database chat;
use chat;

create table users(
    userID int not null auto_increment,
    userName varchar(20),
    primary key (userID)
);

create table messages(
    msgID int not null auto_increment,
    msgTime time,
    msgText varchar(100),
    fromUser int not null,
    primary key (msgID),
    foreign key (fromUser) references users(userID)
)
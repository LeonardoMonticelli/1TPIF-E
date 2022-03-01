create database people;

use people;

CREATE TABLE people (
    StudentID int unique not null AUTO_INCREMENT,
    FirstName varchar(255) unique,
    LastName varchar(255) unique,
    EmailAddress varchar(255) unique,
    PRIMARY KEY (StudentID)
);
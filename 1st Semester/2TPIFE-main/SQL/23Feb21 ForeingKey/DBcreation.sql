drop database wsers2; 
create database wsers2;
use wsers2;

CREATE TABLE COUNTRIES(
    ID_Country int not NULL AUTO_INCREMENT,
    CountryName varchar(50),
    primary key (ID_Country)
);

CREATE TABLE PPL(
    ID_PERSON int NOT NULL AUTO_INCREMENT,
    FirstName varchar(50),
    LastName varchar(50),
    Username varchar(50),
    Pswd varchar(100),
    Age int,
    ID_Country int,
    primary key (ID_PERSON),
    foreign key (ID_Country) references COUNTRIES(ID_Country)
);

INSERT INTO COUNTRIES(CountryName) VALUES('Luxembourg');